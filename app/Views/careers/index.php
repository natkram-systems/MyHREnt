<h1 style="font-size:1.6rem;margin:0 0 .5rem">Careers at Natkram-Systems</h1>
<p style="color:#64748b;margin:0 0 2rem">Browse our open positions. Applications are reviewed continuously.</p>
<form method="get" style="margin-bottom:2rem">
  <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search by title or keyword…" style="padding:.9rem 1.1rem;font-size:1rem">
</form>
<?php if (empty($jobs)): ?>
  <div class="card" style="text-align:center;color:#64748b">
    <p style="margin:0">No open positions at this time. Check back soon.</p>
  </div>
<?php else: foreach ($jobs as $j): ?>
  <a href="<?= app_url('careers/'.$j['id']) ?>" class="card" style="display:block;text-decoration:none;color:inherit;margin-bottom:1rem">
    <div style="display:flex;justify-content:space-between;align-items:flex-start">
      <div>
        <div style="font-weight:600;font-size:1.05rem"><?= e($j['title']) ?></div>
        <div style="color:#64748b;font-size:.85rem;margin-top:.35rem"><?= e($j['department']) ?> · <?= e(ucwords(str_replace('_', ' ', $j['employment_type']))) ?></div>
      </div>
      <div style="color:#64748b;font-size:.8rem"><?= $j['expires_at'] ? 'Closes ' . e(date('M j', strtotime($j['expires_at']))) : 'Open until filled' ?></div>
    </div>
  </a>
<?php endforeach; endif; ?>