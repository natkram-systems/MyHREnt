<div style="text-align:center;padding:4rem 1rem">
  <div style="font-size:5rem;font-weight:700;color:#0f2547;opacity:.15;line-height:1">500</div>
  <h1 style="font-size:1.35rem;margin:.5rem 0">Something went wrong</h1>
  <p style="color:#64748b;margin-bottom:1rem">An unexpected error occurred. Our team has been notified.</p>
  <?php if (!empty($ref)): ?>
    <p style="color:#64748b;font-size:.82rem;font-family:monospace">Reference: <?= e($ref) ?></p>
  <?php endif; ?>
  <a href="<?= app_url('dashboard') ?>" class="btn btn-dark" style="margin-top:1rem">← Back to Dashboard</a>
</div>