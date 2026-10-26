<?php $r = $detail; $t = $r['totals']; ?>
<a class="back" href="<?= app_url('payroll') ?>">← Payroll</a>
<div class="page-header" style="margin-top:.5rem">
  <div><h1 class="page-title"><?= e($r['period']['name']) ?></h1>
  <p class="page-subtitle">Pay date <?= e(date('M j, Y', strtotime($r['period']['pay_date']))) ?> · <span class="status s-completed"><?= e($r['period']['status']) ?></span></p></div>
  <div><a class="btn btn-outline">Export Excel</a> <a class="btn btn-outline">Export PDF</a></div>
</div>
<div class="stat-grid">
  <div class="stat-card"><div class="stat-label">Gross</div><div class="stat-value">₱<?= number_format($t['gross'], 2) ?></div></div>
  <div class="stat-card"><div class="stat-label">Deductions</div><div class="stat-value">₱<?= number_format($t['total_deductions'], 2) ?></div></div>
  <div class="stat-card"><div class="stat-label">Net Pay</div><div class="stat-value">₱<?= number_format($t['net'], 2) ?></div></div>
  <div class="stat-card"><div class="stat-label">Employer Contrib.</div><div class="stat-value">₱<?= number_format($t['total_employer'], 2) ?></div></div>
</div>
<div class="card" style="margin-bottom:1rem">
  <div class="card-header">Employee Details</div>
  <table style="font-size:.82rem">
    <thead><tr><th>Employee</th><th>Basic</th><th>Allow.</th><th>OT</th><th>Gross</th><th>SSS</th><th>PhilHealth</th><th>Pag-IBIG</th><th>Tax</th><th>Other</th><th>Net</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($r['employees'] as $e): ?>
        <tr>
          <td>
            <div style="font-weight:600"><?= e($e['name']) ?></div>
            <div style="color:var(--muted);font-size:.7rem"><?= e($e['employee_no']) ?></div>
          </td>
          <td><?= number_format($e['basic']) ?></td>
          <td><?= number_format($e['allowance']) ?></td>
          <td><?= number_format($e['ot']) ?></td>
          <td style="font-weight:600"><?= number_format($e['gross']) ?></td>
          <td style="color:#dc2626"><?= number_format($e['sss'], 2) ?></td>
          <td style="color:#dc2626"><?= number_format($e['phil'], 2) ?></td>
          <td style="color:#dc2626"><?= number_format($e['pagibig'], 2) ?></td>
          <td style="color:#dc2626"><?= number_format($e['tax'], 2) ?></td>
          <td style="color:#dc2626"><?= number_format($e['other'], 2) ?></td>
          <td style="font-weight:700"><?= number_format($e['net'], 2) ?></td>
          <td><a class="btn btn-sm btn-outline" href="<?= app_url('payroll/'.$r['period']['id'].'/payslip/1') ?>">Payslip</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-header">Employee Contributions</div>
      <div class="card-body">
        <div class="kv"><span class="k">SSS</span><span class="v">₱<?= number_format($t['sss_employee'], 2) ?></span></div>
        <div class="kv"><span class="k">PhilHealth</span><span class="v">₱<?= number_format($t['philhealth_employee'], 2) ?></span></div>
        <div class="kv"><span class="k">Pag-IBIG</span><span class="v">₱<?= number_format($t['pagibig_employee'], 2) ?></span></div>
        <div class="kv"><span class="k">Withholding Tax</span><span class="v">₱<?= number_format($t['tax'], 2) ?></span></div>
      </div>
    </div>
  </div>
  <div class="col-2">
    <div class="card">
      <div class="card-header">Employer Contributions</div>
      <div class="card-body">
        <div class="kv"><span class="k">SSS</span><span class="v">₱<?= number_format($t['sss_employer'], 2) ?></span></div>
        <div class="kv"><span class="k">PhilHealth</span><span class="v">₱<?= number_format($t['philhealth_employer'], 2) ?></span></div>
        <div class="kv"><span class="k">Pag-IBIG</span><span class="v">₱<?= number_format($t['pagibig_employer'], 2) ?></span></div>
        <div class="kv" style="border-top:2px solid var(--border);font-weight:700"><span class="k">TOTAL</span><span class="v">₱<?= number_format($t['total_employer'], 2) ?></span></div>
      </div>
    </div>
  </div>
</div>