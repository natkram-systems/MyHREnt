<div class="card" style="max-width:420px;margin:2rem auto">
  <div style="text-align:center;margin-bottom:2rem">
    <div style="font-weight:700;font-size:1.8rem;color:#0f2547">MyHR</div>
    <small style="font-size:.62rem;color:#64748b;letter-spacing:1.5px;text-transform:uppercase">Powered by Natkram-Systems</small>
  </div>
  <?php if (!empty($demo)): ?>
    <div style="background:#fef3c7;color:#78350f;padding:.7rem 1rem;border-radius:.4rem;font-size:.82rem;margin-bottom:1rem;text-align:center">
      Demo mode — any credentials will work
    </div>
  <?php endif; ?>
  <form method="post" action="<?= app_url('login') ?>">
    <?= $csrf ?>
    <div style="margin-bottom:1rem">
      <label for="email">Work email</label>
      <input type="email" id="email" name="email" required value="hr.admin@natkram.local">
    </div>
    <div style="margin-bottom:1.5rem">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required value="preview-mode">
    </div>
    <button type="submit" class="btn btn-dark" style="width:100%;justify-content:center">Sign in</button>
  </form>
</div>