<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PickupController extends Controller
{
    public function index()
    {
        $pickups = Pickup::paginate(10);
        return view('pickups.index', compact('pickups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pickup_date' => 'nullable|string',
            'pickup_location' => 'nullable|string',
            'drop_location' => 'nullable|string',
            'size_of_vehicle' => 'nullable|string',
            'email' => 'nullable|email',
            'contact' => 'nullable|string',
            'extra_field_1' => 'nullable|string',
            'extra_field_2' => 'nullable|string',
        ]);

        $data['pickup_id'] = $this->generatePickupId();

        $pickup = Pickup::create($data);

        if (!$pickup) {
            return back()->with('error', 'Not Send.');
        }

        return view('redirect-script', [
            'url' => 'https://zauto.nexvertise.com/pickup-confirmation/'
        ]);
    }

    protected function generatePickupId(): string
    {
        do {
            $pickupId = 'ZAUT0' . str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Pickup::where('pickup_id', $pickupId)->exists());

        return $pickupId;
    }

    public function destroy($pickup)
    {
        Pickup::destroy($pickup);
        return redirect()->route('pickups.index');
    }

    public function edit(Pickup $pickup)
    {
        return view('pickups.edit', compact('pickup'));
    }

    public function update(Request $request, Pickup $pickup)
    {
        $validated = $request->validate([
            'status' => 'string',
            'price' => 'nullable|numeric',
        ]);

        $pickup->price = $request->price;
        $pickup->status = $request->status;
        $pickup->advance_paid = $request->advance_paid;
        $pickup->save();

        return redirect()->route('pickups.index')
            ->with('success', 'Pickup status updated successfully.');
    }

    public function create()
    {
        return view('pickups.create');
    }

    public function trackindex()
    {
        return view('pickups.trackindex');
    }

    public function trackcheck(Request $request)
    {
        $request->validate([
            'pickup_id' => 'required|string'
        ]);

        $pickup = Pickup::where('pickup_id', $request->pickup_id)->first();

        if ($pickup) {
            return view('pickups.status', compact('pickup'));
        } else {
            return back()->with('error', 'No pickup found with this Request ID.');
        }
    }

    public function sendEmail(Pickup $pickup)
    {
        try {
            $paymentLink = route('paypal.pay', $pickup->id);

            Mail::send('pickups.emailtemplate', [
                'pickup' => $pickup,
                'paymentLink' => $paymentLink
            ], function ($message) use ($pickup) {
                $message->to($pickup->email ?? 'rsuny83@gmail.com')
                        ->subject('Pickup Info: ' . $pickup->pickup_id);
            });

            return back()->with('success', 'Email sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
