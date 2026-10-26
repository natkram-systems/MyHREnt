<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title ?? 'MyHR') ?> — MyHR</title>
<link rel="stylesheet" href="<?= app_url('assets/vendor/bootstrap.min.css') ?>">
<style>
body{background:#f4f6fb;color:#1e293b;font-family:system-ui,'Segoe UI',Roboto,sans-serif;margin:0;font-size:15px}
.public-nav{background:#0f2547;padding:1rem 1.5rem;display:flex;justify-content:space-between;align-items:center;color:#fff}
.public-brand{font-weight:700;font-size:1.4rem;text-decoration:none;color:#fff}
.public-brand small{display:block;font-size:.6rem;color:#8a94a6;letter-spacing:1.4px;text-transform:uppercase;margin-top:.2rem}
.public-links a{color:#cfd8e6;text-decoration:none;font-size:.9rem;margin-left:1rem}
.public-links a:hover{color:#fff}
.public-content{max-width:960px;margin:0 auto;padding:2rem 1rem}
.card{background:#fff;border:1px solid #e5e9f0;border-radius:.75rem;padding:2rem;box-shadow:0 2px 10px rgba(16,32,64,.04)}
.btn{display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.1rem;border-radius:.4rem;font-size:.88rem;font-weight:500;text-decoration:none;border:1px solid transparent;color:inherit;cursor:pointer}
.btn-dark{background:#0f2547;color:#fff}
.btn-outline{background:transparent;border-color:#e5e9f0;color:#1e293b}
.btn-outline:hover{background:#f4f6fb}
input,select,textarea{width:100%;padding:.65rem .75rem;border:1px solid #e5e9f0;border-radius:.4rem;font-size:.9rem;font-family:inherit}
label{font-size:.8rem;font-weight:600;display:block;margin-bottom:.35rem;color:#0f2547}
</style>
</head>
<body>
<header class="public-nav">
  <a href="<?= app_url('careers') ?>" class="public-brand">MyHR<small>Natkram-Systems Careers</small></a>
  <div class="public-links">
    <a href="<?= app_url('careers') ?>">Open Positions</a>
    <a href="<?= app_url('careers/status') ?>">My Applications</a>
    <a href="<?= app_url('login') ?>">Employee Login</a>
  </div>
</header>
<main class="public-content">
  <?php foreach ($flash ?? [] as [$type, $msg]): ?>
    <div style="padding:.9rem 1.1rem;background:<?= $type==='danger'?'#fee2e2':'#dcfce7' ?>;color:<?= $type==='danger'?'#991b1b':'#166534' ?>;border-radius:.5rem;margin-bottom:1rem"><?= e($msg) ?></div>
  <?php endforeach; ?>
  <?= $content ?>
</main>
<footer style="text-align:center;padding:2rem;color:#64748b;font-size:.78rem">
  © <?= date('Y') ?> Natkram-Systems. All rights reserved.
</footer>
</body>
</html>