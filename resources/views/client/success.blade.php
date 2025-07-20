<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            padding: 40px 30px;
        }
        .checkmark {
            font-size: 80px;
            color: #4CAF50;
        }
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            font-size: 18px;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #0d6efd;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
        }
        .btn:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="checkmark">✔</div>
        <h1>Payment Successful</h1>
        <p>Thank you for your payment! Your advance has been received.</p>
        <a href="{{ route('home') }}" class="btn">Return to Home</a>
    </div>

</body>
</html>
