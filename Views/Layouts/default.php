<!-- Default layout -->
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Property Listing</title>
    <script src="/Public/assets/js/jquery.min.js"></script>
    <script src="/Public/assets/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/assets/css/main.css" rel="stylesheet">
    <link href="/Public/assets/css/tables.min.css" rel="stylesheet">
  </head>

  <body>
  <main role="main" class="container">
    <div class="main-content">
      <?= $content ?? ''; ?>
    </div>
  </main>
  </body>
</html>
