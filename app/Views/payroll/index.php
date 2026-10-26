<div class="page-header">
  <div><h1 class="page-title">Payroll</h1><p class="page-subtitle">Semi-monthly · pay dates on 5th and 20th</p></div>
  <a class="btn btn-dark">+ New Period</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Period</th><th>Pay Date</th><th>Employees</th><th>Gross</th><th>Net</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($periods as $p): ?>
        <tr>
          <td style="font-weight:600"><?= e($p['name']) ?></td>
          <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($p['pay_date']))) ?></td>
          <td><?= (int) $p['employees'] ?></td>
          <td>₱<?= number_format($p['gross'], 2) ?></td>
          <td>₱<?= number_format($p['net'], 2) ?></td>
          <td>
            <?php $cls = $p['status'] === 'paid' ? 'completed' : ($p['status'] === 'open' ? 'pending' : 'probationary'); ?>
            <span class="status s-<?= $cls ?>"><?= e($p['status']) ?></span>
          </td>
          <td style="text-align:right"><a class="btn btn-sm btn-outline" href="<?= app_url('payroll/'.$p['id']) ?>">View</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>