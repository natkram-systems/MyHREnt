<div class="page-header">
  <div><h1 class="page-title">Training Records</h1><p class="page-subtitle"><?= count($rows) ?> records</p></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Employee</th><th>Course</th><th>Provider</th><th>Date</th><th>Score</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $t): ?>
        <tr>
          <td>
            <div style="font-weight:600;font-size:.875rem"><?= e($t['name']) ?></div>
            <div style="color:var(--muted);font-size:.72rem"><?= e($t['employee_no']) ?></div>
          </td>
          <td><?= e($t['course']) ?></td>
          <td><?= e($t['provider']) ?></td>
          <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($t['date']))) ?></td>
          <td><?= $t['score'] ?? '—' ?></td>
          <td><span class="status s-<?= e($t['status']) ?>"><?= e(str_replace('_', ' ', $t['status'])) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>