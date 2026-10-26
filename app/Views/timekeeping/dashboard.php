<div class="page-header">
  <div><h1 class="page-title">Timekeeping</h1><p class="page-subtitle"><?= date('l, F j, Y') ?></p></div>
  <a href="<?= app_url('timekeeping/terminal') ?>" class="btn btn-dark">Open Terminal</a>
</div>
<div class="stat-grid">
  <div class="stat-card"><div class="stat-label">Present</div><div class="stat-value" style="color:#16a34a"><?= (int) $data['present'] ?></div><div class="stat-delta">of <?= (int) $data['expected'] ?> expected</div></div>
  <div class="stat-card"><div class="stat-label">Absent</div><div class="stat-value" style="color:#dc2626"><?= (int) $data['absent'] ?></div><div class="stat-delta">No time-in</div></div>
  <div class="stat-card"><div class="stat-label">Late</div><div class="stat-value" style="color:#f59e0b"><?= (int) $data['late'] ?></div><div class="stat-delta">Past grace period</div></div>
  <div class="stat-card"><div class="stat-label">Missing Punches</div><div class="stat-value"><?= (int) $data['missing_punches'] ?></div><div class="stat-delta">Needs review</div></div>
</div>
<div class="row">
  <div class="col-2" style="flex:2 1 480px">
    <div class="card">
      <div class="card-header">Today's Attendance</div>
      <table>
        <thead><tr><th>Employee</th><th>Time In</th><th>Time Out</th><th>Status</th><th>Late</th></tr></thead>
        <tbody>
          <?php foreach ($data['attendance'] as $a): ?>
            <tr>
              <td>
                <div style="font-weight:600;font-size:.875rem"><?= e($a['name']) ?></div>
                <div style="color:var(--muted);font-size:.72rem;font-family:monospace"><?= e($a['employee_no']) ?></div>
              </td>
              <td><?= e($a['time_in'] ?? '—') ?></td>
              <td><?= e($a['time_out'] ?? '—') ?></td>
              <td>
                <?php $cls = $a['status']==='absent' ? 'terminated' : ($a['status']==='late' ? 'probationary' : 'regular'); ?>
                <span class="status s-<?= $cls ?>"><?= e($a['status']) ?></span>
              </td>
              <td><?= $a['late_min'] ? (int) $a['late_min'] . ' min' : '—' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-2">
    <div class="card">
      <div class="card-header">Devices</div>
      <div class="card-body">
        <?php foreach ($data['devices'] as $d): ?>
          <div class="kv"><span class="k"><?= e($d['name']) ?></span><span class="v"><span class="status s-active"><?= e($d['status']) ?></span></span></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>