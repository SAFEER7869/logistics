<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Track Pickup</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
    
    }
    .card-custom {
      max-width: 500px;
      margin: 60px auto;
      padding: 30px;
      background-color: #fff;
      border: 1px solid #dce3ea;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .btn-submit ,     .btn-submit:hover {
      background-color: #c0ff8c;
      border: none;
      width: 100%;
      padding: 12px;
      font-weight: bold;
      color: #000;
    }
  </style>
</head>
<body>

  <div class="">
    <form method="POST" action="{{ route('pickups.trackcheck') }}">
      @csrf

      <div class="mb-3">
        <label for="pickup_id" class="form-label"><strong>Pickup ID</strong></label>
        <input type="text" id="pickup_id" name="pickup_id" class="form-control py-3" placeholder="Enter Pickup ID" autocomplete="off" />
        @error('pickup_id')
          <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-submit">Submit</button>
    </form>
  </div>

</body>
</html>
