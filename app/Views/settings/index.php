<div class="page-header">
  <div><h1 class="page-title">Settings</h1><p class="page-subtitle">System configuration</p></div>
</div>
<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-header">Company</div>
      <div class="card-body">
        <div class="kv"><span class="k">Name</span><span class="v"><?= e($company['company_name']) ?></span></div>
        <div class="kv"><span class="k">Address</span><span class="v"><?= e($company['company_address']) ?></span></div>
        <div class="kv"><span class="k">Phone</span><span class="v"><?= e($company['company_phone']) ?></span></div>
        <div class="kv"><span class="k">Email</span><span class="v"><?= e($company['company_email']) ?></span></div>
      </div>
    </div>
  </div>
  <div class="col-2">
    <div class="card">
      <div class="card-header">Payroll & Timekeeping</div>
      <div class="card-body">
        <div class="kv"><span class="k">Payroll Frequency</span><span class="v"><?= e($company['payroll_frequency']) ?></span></div>
        <div class="kv"><span class="k">Cut-offs</span><span class="v"><?= (int) $company['payroll_cutoff_1'] ?> & <?= (int) $company['payroll_cutoff_2'] ?></span></div>
        <div class="kv"><span class="k">Grace Period</span><span class="v"><?= (int) $company['attendance_grace_minutes'] ?> minutes</span></div>
        <div class="kv"><span class="k">Work Hours</span><span class="v"><?= (int) $company['standard_work_hours'] ?> / day</span></div>
      </div>
    </div>
  </div>
</div>
<div class="card" style="margin-top:1rem">
  <div class="card-header">Contribution Rule Sets</div>
  <table>
    <thead><tr><th>Agency</th><th>Effective From</th><th>Source</th><th>Verified</th></tr></thead>
    <tbody>
      <?php foreach ($contributions as $c): ?>
        <tr>
          <td style="font-weight:600"><?= e($c['agency']) ?></td>
          <td><?= e(date('M j, Y', strtotime($c['effective_from']))) ?></td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($c['source']) ?></td>
          <td><?= $c['verified'] ? '<span class="status s-completed">Verified</span>' : '<span class="status s-terminated">Unverified</span>' ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div style="margin-top:1rem;background:#fef3c7;color:#78350f;padding:1rem;border-radius:.5rem;font-size:.85rem">
  ⚠ Unverified rule sets will block payroll finalization until reviewed. See specification §13.
</div>