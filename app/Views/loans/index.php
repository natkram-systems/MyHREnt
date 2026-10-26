<div class="page-header">
  <div><h1 class="page-title">Loans & Advances</h1><p class="page-subtitle"><?= count($rows) ?> active records</p></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Employee</th><th>Type</th><th>Principal</th><th>Paid</th><th>Balance</th><th>Monthly</th><th>Start</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $l): ?>
        <tr>
          <td>
            <div style="font-weight:600;font-size:.875rem"><?= e($l['name']) ?></div>
            <div style="color:var(--muted);font-size:.72rem"><?= e($l['employee_no']) ?></div>
          </td>
          <td><?= e($l['type']) ?></td>
          <td>₱<?= number_format($l['principal'], 2) ?></td>
          <td>₱<?= number_format($l['paid'], 2) ?></td>
          <td style="font-weight:600">₱<?= number_format($l['balance'], 2) ?></td>
          <td>₱<?= number_format($l['monthly'], 2) ?></td>
          <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($l['start']))) ?></td>
          <td>
            <?php $cls = $l['status'] === 'active' ? 'active' : 'completed'; ?>
            <span class="status s-<?= $cls ?>"><?= e($l['status']) ?></span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>