<div class="page-header">
  <div><h1 class="page-title">Overtime Requests</h1><p class="page-subtitle"><?= count($rows) ?> requests</p></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Employee</th><th>Date</th><th>Hours</th><th>Reason</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td>
            <div style="font-weight:600;font-size:.875rem"><?= e($r['name']) ?></div>
            <div style="color:var(--muted);font-size:.72rem"><?= e($r['employee_no']) ?></div>
          </td>
          <td><?= e(date('M j, Y', strtotime($r['date']))) ?></td>
          <td><?= number_format($r['hours'], 1) ?> h</td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($r['reason']) ?></td>
          <td>
            <?php $cls = $r['status'] === 'approved' ? 'completed' : ($r['status'] === 'pending' ? 'pending' : 'terminated'); ?>
            <span class="status s-<?= $cls ?>"><?= e($r['status']) ?></span>
          </td>
          <td style="text-align:right">
            <?php if ($r['status'] === 'pending'): ?>
              <button class="btn btn-sm btn-success">Approve</button>
              <button class="btn btn-sm btn-outline">Reject</button>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>