<?php
// app/Views/layouts/app.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'Employee Portal' ?></title>
  <link rel="stylesheet" href="/assets/vendor/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
  <header class="navbar navbar-light bg-light">
    <div class="container">
      <span class="navbar-brand">Employee Portal</span>
      <form method="post" action="/logout">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
        <button class="btn btn-outline-danger">Logout</button>
      </form>
    </div>
  </header>
  <main class="container mt-4">
    <?= $content ?? '' ?>
  </main>
</body>
</html>
