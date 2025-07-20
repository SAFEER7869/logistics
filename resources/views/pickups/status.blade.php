<!DOCTYPE html>
<html>
<head>
  <title>Pickup Status</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body >


      <strong>Status for {{ $pickup->pickup_id }}:</strong>
      {{ $pickup->status ?? "Not Assigned"}}


</body>
</html>
