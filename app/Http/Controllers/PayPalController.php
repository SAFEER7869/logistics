<?php

namespace App\Http\Controllers;
use App\Models\Pickup;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
//   public function createPayment($pickupId)
//     {
//         $provider = new PayPalClient;
//         $provider->setApiCredentials(config('paypal'));
//         $token = $provider->getAccessToken();
//         $provider->setAccessToken($token);

//         $response = $provider->createOrder([
//             "intent" => "CAPTURE",
//             "purchase_units" => [[
//                 "amount" => [
//                     "currency_code" => "USD",
//                     "value" => "200.00"
//                 ]
//             ]],
// "application_context" => [
//     "return_url" => route('paypal.success', ['pickupId' => $pickupId]),
//     "cancel_url" => route('paypal.cancel', ['pickupId' => $pickupId]),
//     "brand_name" => "Z Auto Transport",
//     "landing_page" => "BILLING", // 👈 This shows guest checkout/card form if allowed
//     "user_action" => "PAY_NOW"
// ]


//         ]);

//         foreach ($response['links'] as $link) {
//             if ($link['rel'] === 'approve') {
//                 return redirect()->away($link['href']);
//             }
//         }

//         return redirect()->route('home')->with('error', 'Payment creation failed.');
//     }
public function createPayment($pickupId)
{
    // Initialize PayPal client
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $token = $provider->getAccessToken();
    $provider->setAccessToken($token);

    // Create the PayPal order
    $response = $provider->createOrder([
        "intent" => "CAPTURE",
        "purchase_units" => [[
            "amount" => [
                "currency_code" => "USD",
                "value" => "100.00" // Fixed amount $200
            ]
        ]],
        "application_context" => [
            "return_url" => route('paypal.success', ['pickupId' => $pickupId]),
            "cancel_url" => route('paypal.cancel', ['pickupId' => $pickupId]),
            "brand_name" => "Z Auto Transport",
            "landing_page" => "BILLING",
            "user_action" => "PAY_NOW"
        ]
    ]);

    // Log PayPal response for debugging
    \Log::debug('PayPal response:', $response);

    // Find the "approve" link from PayPal's response
    $approveLink = null;
    foreach ($response['links'] as $link) {
        if ($link['rel'] === 'approve') {
            $approveLink = $link['href'];
            break;
        }
    }

    // If no approval link, return an error
    if (!$approveLink) {
        \Log::error('PayPal payment approval link not found');
        return redirect()->route('home')->with('error', 'Payment creation failed.');
    }

    // Redirect to the PayPal approval link
    return redirect()->away($approveLink);
}



public function handleSuccess(Request $request, $pickupId)
{
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $token = $provider->getAccessToken();
    $provider->setAccessToken($token);

    // Capture the payment
    $order = $provider->capturePaymentOrder($request->token);

    if ($order['status'] === 'COMPLETED') {
        // Update the pickup record if payment is successful
        Pickup::where('id', $pickupId)->update([
            'advance_paid' => 'Paid'
        ]);

        return redirect()->route('client.success')->with('success', 'Payment successful!');
    }

    return redirect()->route('home')->with('error', 'Payment failed.');
}


    public function handleCancel($pickupId)
    {
        return redirect()->route('home')->with('error', 'Payment cancelled.');
    }
}
