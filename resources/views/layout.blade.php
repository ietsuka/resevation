<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>予約確認</title>
  <link rel="stylesheet" type="text/css" href="css/app.css">
  <!-- <script src="https://unpkg.com/v-switch-case@1.0.2/dist/v-switch.min.js"></script> -->
</head>
<body>
  <div id="app">
    <index-component></index-component>
  </div>
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
