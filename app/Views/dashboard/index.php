<div class="page-header">
  <div>
    <h1 class="page-title">Good <?= date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') ?>, <?= e(explode(' ', $auth['display_name'] ?? '')[0]) ?></h1>
    <p class="page-subtitle"><?= date('l, F j, Y') ?></p>
  </div>
  <div>
    <a class="btn btn-outline">Export</a>
    <a class="btn btn-dark">+ New Hire</a>
  </div>
</div>
<div class="stat-grid">
  <div class="stat-card"><div class="stat-label">Total Employees</div><div class="stat-value"><?= (int) $stats['total_employees'] ?></div><div class="stat-delta"><span class="up">+3</span> this quarter</div></div>
  <div class="stat-card"><div class="stat-label">Active</div><div class="stat-value"><?= (int) $stats['active_employees'] ?></div><div class="stat-delta"><?= (int) $stats['probationary'] ?> on probation</div></div>
  <div class="stat-card"><div class="stat-label">Open Positions</div><div class="stat-value"><?= (int) $stats['open_positions'] ?></div><div class="stat-delta"><?= (int) $stats['pending_leave'] ?> pending leave</div></div>
  <div class="stat-card"><div class="stat-label">Pending Leave</div><div class="stat-value"><?= (int) $stats['pending_leave'] ?></div><div class="stat-delta">Awaiting review</div></div>
</div>
<div class="row">
  <div class="col-2" style="flex:1.4 1 480px">
    <div class="card">
      <div class="card-header"><span>Recent Hires</span><a href="<?= app_url('employees') ?>" style="font-size:.8rem;color:var(--muted)">View all →</a></div>
      <table>
        <thead><tr><th>Employee</th><th>Position</th><th>Hired</th></tr></thead>
        <tbody>
          <?php foreach ($recentHires as $h): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:.6rem">
                  <div class="avatar"><?= e(strtoupper(substr($h['name'], 0, 1))) ?></div>
                  <div>
                    <div style="font-weight:600;font-size:.875rem"><?= e($h['name']) ?></div>
                    <div style="color:var(--muted);font-size:.72rem"><?= e($h['employee_no']) ?></div>
                  </div>
                </div>
              </td>
              <td><?= e($h['position']) ?></td>
              <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($h['date_hired']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-2" style="flex:1 1 320px">
    <div class="card">
      <div class="card-header">Onboarding In Progress</div>
      <div class="card-body">
        <?php foreach ($onboarding as $o): ?>
          <a href="<?= app_url('employees/'.$o['employee_id'].'/onboarding') ?>" style="text-decoration:none;color:var(--text)">
            <div style="display:flex;justify-content:space-between;margin-bottom:.5rem">
              <div>
                <div style="font-weight:600"><?= e($o['name']) ?></div>
                <div style="color:var(--muted);font-size:.78rem"><?= e($o['employee_no']) ?> · starts <?= e(date('M j', strtotime($o['start_date']))) ?></div>
              </div>
              <span style="background:var(--navy);color:#fff;padding:.15rem .5rem;border-radius:1rem;font-size:.72rem;font-weight:600"><?= (int) $o['progress'] ?>%</span>
            </div>
            <div class="progress-line"><div style="width:<?= (int) $o['progress'] ?>%"></div></div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="card" style="margin-top:1rem">
      <div class="card-header">Quick Actions</div>
      <div class="card-body" style="display:flex;flex-wrap:wrap;gap:.5rem">
        <a class="btn btn-outline">+ Add Employee</a>
        <a class="btn btn-outline">+ Post Job</a>
        <a class="btn btn-outline">Approve Leave</a>
        <a class="btn btn-outline">Run Payroll</a>
      </div>
    </div>
  </div>
</div>