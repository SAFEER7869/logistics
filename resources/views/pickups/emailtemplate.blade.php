<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pickup Notification</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; background: #fff; padding: 20px;">

    <!-- Logo -->
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ asset('path/to/logo.png') }}" alt="Z Auto Transport" style="max-width: 250px;">
    </div>

    <!-- Greeting -->
    <p>Hello,</p>

    <p>Thank you for completing a Z Auto Transport estimate.</p>

    <!-- Quote Link (Optional) -->
    @if(isset($pickup->pickup_id))
    <p>
        For your convenience here is your direct link 
        where you can take the next steps if not already.
    </p>
    @endif

    <!-- Summary -->
    <h3>Quote Summary:</h3>
    <table style="width: 100%; max-width: 600px; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Pickup Location:</td>
            <td style="padding: 6px 8px;">{{ $pickup->pickup_location ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Delivery Location:</td>
            <td style="padding: 6px 8px;">{{ $pickup->drop_location ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Pickup Date:</td>
            <td style="padding: 6px 8px;">{{ $pickup->pickup_date ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Phone:</td>
            <td style="padding: 6px 8px;">{{ $pickup->contact ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Email:</td>
            <td style="padding: 6px 8px;">
                <a href="mailto:{{ $pickup->email }}" style="color: #007bff;">{{ $pickup->email ?? '—' }}</a>
            </td>
        </tr>
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Size Of vehicle:</td>
            <td style="padding: 6px 8px;">{{ $pickup->size_of_vehicle ?? '—' }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 8px; font-weight: bold;">Price:</td>
            <td style="padding: 6px 8px;">${{ $pickup->price ?? '—' }}</td>
        </tr>
    </table>

    <!-- Payment Link -->
    <p>
        Please pay a $100 advance by clicking the link below to complete the payment process.
    </p>
    
    <a href="{{ $paymentLink }}" 
       style="background-color:#0d6efd;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px; margin-top:20px;">
        Pay $100 Advance
    </a>

    <br><br>
    Please pay using the same email: {{ $pickup->email ?? '—' }}<br><br>

    <!-- Footer -->
    <p style="margin-top: 20px;">Warm regards,<br>Team Z Auto Transport</p>

</body>
</html>
