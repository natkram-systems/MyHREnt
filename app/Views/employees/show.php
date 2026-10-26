<a class="back" href="<?= app_url('employees') ?>">← Back to employees</a>
<div class="page-header" style="margin-top:.5rem">
  <div>
    <h1 class="page-title"><?= e($emp['first_name'].' '.$emp['last_name']) ?></h1>
    <p class="page-subtitle"><?= e($emp['employee_no']) ?> · <?= e($emp['position']) ?> · <?= e($emp['department']) ?></p>
  </div>
  <div><a class="btn btn-outline">✎ Edit</a> <a class="btn btn-outline">📄 Documents</a></div>
</div>
<div class="card" style="margin-bottom:1rem">
  <div class="card-body" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
    <div class="avatar avatar-lg"><?= e(strtoupper(substr($emp['first_name'], 0, 1) . substr($emp['last_name'], 0, 1))) ?></div>
    <div style="flex:1">
      <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap">
        <span style="font-weight:600;font-size:1.1rem"><?= e($emp['first_name'].' '.$emp['last_name']) ?></span>
        <span class="status s-<?= e($emp['employment_status']) ?>"><?= e(str_replace('_', ' ', $emp['employment_status'])) ?></span>
      </div>
      <div style="color:var(--muted);font-size:.8rem;margin-top:.25rem">Hired <?= e(date('F j, Y', strtotime($emp['date_hired']))) ?> · <?= e($emp['employment_type']) ?></div>
    </div>
    <div style="text-align:right">
      <div style="color:var(--muted);font-size:.75rem">Reporting to</div>
      <div style="font-weight:600;font-size:.85rem"><?= e($emp['reporting_manager'] ?? '—') ?></div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-2">
    <div class="card">
      <div class="card-header">Employment Snapshot</div>
      <div class="card-body">
        <?php foreach ([
          ['Employee No.', $emp['employee_no']],
          ['Department', $emp['department']],
          ['Position', $emp['position']],
          ['Type', $emp['employment_type']],
          ['Date Hired', date('M j, Y', strtotime($emp['date_hired']))],
          ['Reporting To', $emp['reporting_manager'] ?? '—'],
        ] as [$k, $v]): ?>
          <div class="kv"><span class="k"><?= e($k) ?></span><span class="v"><?= e($v) ?></span></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="col-2">
    <div class="card">
      <div class="card-header">Government IDs</div>
      <div class="card-body">
        <?php foreach ([
          ['SSS', $identifiers['sss']],
          ['PhilHealth', $identifiers['philhealth']],
          ['Pag-IBIG', $identifiers['pagibig']],
          ['TIN', $identifiers['tin']],
          ['Bank', $identifiers['bank_account']],
        ] as [$k, $v]): ?>
          <div class="kv"><span class="k"><?= e($k) ?></span><span class="v" style="font-family:monospace"><?= e($v ?? '—') ?></span></div>
        <?php endforeach; ?>
        <p style="color:var(--muted);font-size:.78rem;margin-top:.75rem;margin-bottom:0">🔒 Encrypted · authorized HR only</p>
      </div>
    </div>
  </div>
</div>
<div class="row" style="margin-top:1rem">
  <?php if ($onboarding): ?>
    <div class="col-2">
      <div class="card">
        <div class="card-header">Onboarding</div>
        <div class="card-body">
          <div style="display:flex;justify-content:space-between;margin-bottom:.5rem;font-size:.85rem">
            <span style="color:var(--muted)"><?= (int) $onboarding['completed_count'] ?> of <?= (int) $onboarding['total_count'] ?> tasks complete</span>
            <span style="font-weight:600"><?= (int) $onboarding['progress_pct'] ?>%</span>
          </div>
          <div class="progress-line" style="margin-bottom:1rem"><div style="width:<?= (int) $onboarding['progress_pct'] ?>%"></div></div>
          <a class="btn btn-outline" style="width:100%;justify-content:center" href="<?= app_url('employees/'.$emp['id'].'/onboarding') ?>">View checklist →</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <div class="col-2">
    <div class="card">
      <div class="card-header">Employment History</div>
      <div class="card-body">
        <?php if (empty($history)): ?>
          <div class="empty" style="padding:1rem"><p style="margin:0">No history yet</p></div>
        <?php else: foreach ($history as $h): ?>
          <div class="kv">
            <span class="k"><?= e(date('M j, Y', strtotime($h['effective_date']))) ?> · <?= e($h['event_type']) ?></span>
            <span class="v"><?= e($h['to_value'] ?? '—') ?></span>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </div>
</div>