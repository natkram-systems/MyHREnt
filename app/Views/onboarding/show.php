<a class="back" href="<?= app_url('employees/'.$emp['id']) ?>">← Back to <?= e($emp['first_name']) ?></a>
<div class="page-header" style="margin-top:.5rem">
  <div>
    <h1 class="page-title">Onboarding Checklist</h1>
    <p class="page-subtitle"><?= e($emp['first_name'].' '.$emp['last_name']) ?> · starts <?= e(date('F j, Y', strtotime($onboarding['start_date']))) ?></p>
  </div>
  <span class="status s-<?= e($onboarding['status']) ?>"><?= e(str_replace('_', ' ', $onboarding['status'])) ?></span>
</div>
<div class="card" style="margin-bottom:1rem">
  <div class="card-body">
    <div style="display:flex;justify-content:space-between;margin-bottom:.5rem">
      <span style="color:var(--muted);font-size:.85rem"><?= (int) $onboarding['completed_count'] ?> of <?= (int) $onboarding['total_count'] ?> tasks complete</span>
      <span style="font-weight:700;font-size:1.1rem"><?= (int) $onboarding['progress_pct'] ?>%</span>
    </div>
    <div class="progress-line" style="height:.55rem"><div style="width:<?= (int) $onboarding['progress_pct'] ?>%"></div></div>
  </div>
</div>
<?php
$groups = ['in_progress' => [], 'pending' => [], 'completed' => []];
foreach ($onboarding['tasks'] as $t) $groups[$t['status']][] = $t;
$labels = ['in_progress' => 'In Progress', 'pending' => 'Pending', 'completed' => 'Completed'];
foreach ($groups as $status => $tasks):
  if (empty($tasks)) continue;
?>
<div class="card" style="margin-bottom:1rem">
  <div class="card-header">
    <span><?= e($labels[$status]) ?></span>
    <span class="status s-inactive"><?= count($tasks) ?></span>
  </div>
  <table>
    <thead><tr><th>Task</th><th>Assigned</th><th>Due</th><th>Mandatory</th><th>Remarks</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($tasks as $t): ?>
        <tr>
          <td style="font-weight:600"><?= e($t['name']) ?></td>
          <td style="color:var(--muted)"><?= e($t['assigned']) ?></td>
          <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($t['due_date']))) ?></td>
          <td><?= $t['mandatory'] ? '<span class="status s-probationary">Required</span>' : '—' ?></td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($t['remarks'] ?? '—') ?></td>
          <td style="text-align:right">
            <?php if ($t['status'] === 'completed'): ?>
              <span class="status s-completed">✓ Done</span>
            <?php else: ?>
              <button class="btn btn-sm btn-outline">Mark complete</button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endforeach; ?>