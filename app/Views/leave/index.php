<div class="page-header">
  <div><h1 class="page-title">Leave Management</h1><p class="page-subtitle"><?= count($requests) ?> requests · <?= count($balances) ?> balances</p></div>
  <a href="<?= app_url('leave/types') ?>" class="btn btn-outline">Manage Types</a>
</div>
<div class="card" style="margin-bottom:1rem">
  <div class="card-header">Requests</div>
  <table>
    <thead><tr><th>Employee</th><th>Type</th><th>Dates</th><th>Days</th><th>Reason</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($requests as $r): ?>
        <tr>
          <td>
            <div style="font-weight:600;font-size:.875rem"><?= e($r['name']) ?></div>
            <div style="color:var(--muted);font-size:.72rem"><?= e($r['employee_no']) ?></div>
          </td>
          <td><?= e($r['type']) ?></td>
          <td style="font-size:.82rem"><?= e(date('M j', strtotime($r['from']))) ?>–<?= e(date('M j', strtotime($r['to']))) ?></td>
          <td><?= (int) $r['days'] ?></td>
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
<div class="card">
  <div class="card-header">Leave Balances</div>
  <table>
    <thead><tr><th>Employee</th><th>Vacation</th><th>Sick</th><th>Emergency</th></tr></thead>
    <tbody>
      <?php foreach ($balances as $b): ?>
        <tr>
          <td>
            <div style="font-weight:600;font-size:.875rem"><?= e($b['name']) ?></div>
            <div style="color:var(--muted);font-size:.72rem"><?= e($b['employee_no']) ?></div>
          </td>
          <td><span class="status s-pending"><?= (int) $b['vl'] ?> days</span></td>
          <td><span class="status s-active"><?= (int) $b['sl'] ?> days</span></td>
          <td><span class="status s-probationary"><?= (int) $b['el'] ?> days</span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>