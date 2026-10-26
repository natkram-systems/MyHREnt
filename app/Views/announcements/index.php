<div class="page-header">
  <div><h1 class="page-title">Announcements</h1><p class="page-subtitle"><?= count($rows) ?> published</p></div>
  <a class="btn btn-dark">+ New Announcement</a>
</div>
<div class="row">
  <?php foreach ($rows as $a): ?>
    <div class="col-2">
      <div class="card" style="height:100%">
        <div class="card-body">
          <div style="display:flex;justify-content:space-between;align-items:start;margin-bottom:.5rem">
            <div style="font-weight:600"><?= e($a['title']) ?></div>
            <?php if ($a['priority'] === 'high'): ?><span class="status s-terminated">High</span><?php endif; ?>
          </div>
          <p style="color:var(--muted);font-size:.85rem;margin:.5rem 0"><?= e($a['body']) ?></p>
          <div style="color:var(--muted);font-size:.72rem">By <?= e($a['author']) ?> · <?= e(date('M j, Y', strtotime($a['published_at']))) ?></div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>