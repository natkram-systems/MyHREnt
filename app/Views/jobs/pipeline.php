<a class="back" href="<?= app_url('jobs') ?>">← Job Postings</a>
<div class="page-header" style="margin-top:.5rem">
  <div><h1 class="page-title">Recruitment Pipeline</h1><p class="page-subtitle">Job ID <?= (int) $jobId ?></p></div>
</div>
<div class="kanban">
  <?php
  $labels = ['applied' => 'Applied', 'screening' => 'Screening', 'qualified' => 'Qualified',
             'for_interview' => 'For Interview', 'interviewed' => 'Interviewed', 'offered' => 'Offered'];
  foreach ($labels as $key => $label):
    $apps = $pipeline[$key] ?? [];
  ?>
    <div class="kanban-col">
      <div class="card">
        <div class="card-header"><span><?= e($label) ?></span><span class="status s-inactive"><?= count($apps) ?></span></div>
        <div class="card-body" style="padding:.75rem">
          <?php if (empty($apps)): ?>
            <div style="text-align:center;color:var(--muted);font-size:.78rem;padding:1rem 0">Empty</div>
          <?php else: foreach ($apps as $a): ?>
            <a class="kanban-card" href="<?= app_url('applicant/'.$a['id']) ?>">
              <div style="font-weight:600;font-size:.875rem"><?= e($a['name']) ?></div>
              <div style="color:var(--muted);font-size:.72rem"><?= e($a['email']) ?></div>
              <div style="color:var(--muted);font-size:.7rem;margin-top:.25rem">Applied <?= e(date('M j', strtotime($a['applied_at']))) ?></div>
            </a>
          <?php endforeach; endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>