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

    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'pickup_date' => 'nullable|string',
    //         'pickup_location' => 'nullable|string',
    //         'drop_location' => 'nullable|string',
    //         'size_of_vehicle' => 'nullable|string',
    //         'email' => 'nullable|email',
    //         'contact' => 'nullable|string',
    //         'extra_field_1' => 'nullable|string',
    //         'extra_field_2' => 'nullable|string',
    //     ]);

    //     $data['pickup_id'] = $this->generatePickupId();

    //     $pickup = Pickup::create($data);

    //     if (!$pickup) {
    //         return back()->with('error', 'Not Send.');
    //     }

    //     return view('redirect-script', [
    //         'url' => 'https://zauto.nexvertise.com/pickup-confirmation/'
    //     ]);
    // }
    public function store(Request $request)
{
    $validated = $request->validate([
        'pickup_location' => 'required|string|max:255',
        'drop_location' => 'required|string|max:255',
      
        'pickup_date' => 'nullable|string|max:255',
        'size_of_vehicle' => 'required|string|max:255',
        'email' => 'nullable|email',
        'contact' => 'nullable|string|max:20',
        'pickup_lat' => 'nullable|numeric',
        'pickup_lon' => 'nullable|numeric',
        'drop_lat' => 'nullable|numeric',
        'drop_lon' => 'nullable|numeric',
    ]);

    // Estimate distance (optional: store for future use)
    $distance = null;
    if ($request->pickup_lat && $request->pickup_lon && $request->drop_lat && $request->drop_lon) {
        $lat1 = $request->pickup_lat;
        $lon1 = $request->pickup_lon;
        $lat2 = $request->drop_lat;
        $lon2 = $request->drop_lon;
        $distance = $this->haversine($lat1, $lon1, $lat2, $lon2);
    }

    $pickup = new Pickup();
    $pickup->pickup_location = $validated['pickup_location'];
    $pickup->drop_location = $validated['drop_location'];
 
    $pickup->pickup_date = $validated['pickup_date'];
    $pickup->size_of_vehicle = $validated['size_of_vehicle'];
    $pickup->email = $validated['email'];
    $pickup->contact = $validated['contact'];
    $pickup->pickup_lat = $request->pickup_lat;
    $pickup->pickup_lon = $request->pickup_lon;
    $pickup->drop_lat = $request->drop_lat;
    $pickup->drop_lon = $request->drop_lon;
    $pickup->estimated_miles = $distance;
    $pickup->estimated_price = $request->estimated_price;


    $pickup->save();

    return view('redirect-script', [
            'url' => 'https://zauto.nexvertise.com/pickup-confirmation/'
        ]);
}

// Add this helper in the same controller
private function haversine($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 3958.8; // in miles

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return $earthRadius * $c;
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
