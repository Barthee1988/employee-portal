<?php
// app/Views/dashboard/index.php
$title = 'Dashboard';
ob_start();
?>
<h1>Welcome</h1>
<p>Leave Available: <?= $data['leave_available'] ?></p>
<p>Loan Status: <?= $data['loan_status'] ?></p>
<ul>
  <?php foreach ($data['notifications'] as $note): ?>
    <li><?= $note ?></li>
  <?php endforeach; ?>
</ul>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
