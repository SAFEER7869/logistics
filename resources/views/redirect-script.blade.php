<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Redirecting...</title>
</head>
<body>
  <script>
    // Use top window to redirect even if inside iframe
    window.top.location.href = "{{ $url }}";
  </script>
</body>
</html>
