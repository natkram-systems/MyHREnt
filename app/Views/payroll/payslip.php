<?php $s = $slip; ?>
<div class="page-header">
  <div><h1 class="page-title">Payslip</h1>
  <p class="page-subtitle"><?= e($s['employee']['name']) ?> · <?= e($s['employee']['employee_no']) ?></p></div>
  <button class="btn btn-dark" onclick="window.print()">🖨 Print</button>
</div>
<div class="card" style="max-width:800px;margin:0 auto">
  <div class="card-body">
    <div style="display:flex;justify-content:space-between;padding-bottom:1.5rem;border-bottom:2px solid var(--border);margin-bottom:1.5rem">
      <div>
        <div style="font-weight:700;font-size:1.4rem">MyHR</div>
        <div style="color:var(--muted);font-size:.82rem">Natkram-Systems Inc.</div>
      </div>
      <div style="text-align:right">
        <div style="color:var(--muted);font-size:.75rem">Payroll Ref</div>
        <div style="font-weight:600;font-family:monospace"><?= e($s['period']['reference']) ?></div>
      </div>
    </div>
    <div class="row" style="margin-bottom:1.5rem">
      <div class="col-2">
        <div style="color:var(--muted);font-size:.72rem;text-transform:uppercase">Employee</div>
        <div style="font-weight:700;font-size:1.1rem"><?= e($s['employee']['name']) ?></div>
        <div style="color:var(--muted);font-size:.82rem"><?= e($s['employee']['employee_no']) ?></div>
        <div style="font-size:.82rem"><?= e($s['employee']['position']) ?> · <?= e($s['employee']['department']) ?></div>
      </div>
      <div class="col-2" style="text-align:right">
        <div style="color:var(--muted);font-size:.72rem;text-transform:uppercase">Pay Period</div>
        <div style="font-weight:600"><?= e($s['period']['name']) ?></div>
        <div style="color:var(--muted);font-size:.82rem">Pay date: <?= e(date('M j, Y', strtotime($s['period']['pay_date']))) ?></div>
      </div>
    </div>
    <div class="row">
      <div class="col-2">
        <div style="font-weight:600;font-size:.75rem;color:var(--muted);text-transform:uppercase;margin-bottom:.5rem">Earnings</div>
        <?php foreach ($s['earnings'] as $e): ?>
          <div class="kv"><span class="k"><?= e($e['label']) ?></span><span class="v">₱<?= number_format($e['amount'], 2) ?></span></div>
        <?php endforeach; ?>
        <div class="kv" style="border-top:2px solid var(--border);font-weight:700"><span>Gross Pay</span><span>₱<?= number_format($s['gross'], 2) ?></span></div>
      </div>
      <div class="col-2">
        <div style="font-weight:600;font-size:.75rem;color:var(--muted);text-transform:uppercase;margin-bottom:.5rem">Deductions</div>
        <?php foreach ($s['deductions'] as $d): ?>
          <div class="kv"><span class="k"><?= e($d['label']) ?></span><span class="v" style="color:#dc2626">₱<?= number_format($d['amount'], 2) ?></span></div>
        <?php endforeach; ?>
        <div class="kv" style="border-top:2px solid var(--border);font-weight:700"><span>Total Deductions</span><span style="color:#dc2626">₱<?= number_format($s['total_deductions'], 2) ?></span></div>
      </div>
    </div>
    <div style="margin-top:1.5rem;padding:1rem;background:var(--bg);border-radius:.5rem;display:flex;justify-content:space-between;align-items:center">
      <span style="font-weight:600;text-transform:uppercase">Net Pay</span>
      <span style="font-weight:700;font-size:1.6rem">₱<?= number_format($s['net'], 2) ?></span>
    </div>
  </div>
</div>