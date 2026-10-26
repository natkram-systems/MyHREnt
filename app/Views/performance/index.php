<div class="page-header">
  <div><h1 class="page-title">Performance Reviews</h1><p class="page-subtitle"><?= count($rows) ?> reviews</p></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Employee</th><th>Period</th><th>Rating</th><th>Reviewer</th><th>Due</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $p): ?>
        <tr>
          <td>
            <div style="font-weight:600;font-size:.875rem"><?= e($p['name']) ?></div>
            <div style="color:var(--muted);font-size:.72rem"><?= e($p['employee_no']) ?></div>
          </td>
          <td><?= e($p['period']) ?></td>
          <td><?= $p['rating'] ? $p['rating'] . ' / 5' : '—' ?></td>
          <td><?= e($p['reviewer']) ?></td>
          <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($p['date']))) ?></td>
          <td><span class="status s-<?= e($p['status']) ?>"><?= e(str_replace('_', ' ', $p['status'])) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>