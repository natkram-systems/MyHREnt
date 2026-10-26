<?php $s = $summary; ?>
<a class="back" href="<?= app_url('timekeeping') ?>">← Timekeeping</a>
<div class="page-header" style="margin-top:.5rem">
  <div><h1 class="page-title">DTR Summary</h1>
  <p class="page-subtitle"><?= e($s['employee']['name']) ?> · <?= e($s['employee']['employee_no']) ?> · <?= e(date('F Y', strtotime($s['month'].'-01'))) ?></p></div>
  <button class="btn btn-dark" onclick="window.print()">🖨 Print DTR</button>
</div>
<div class="stat-grid">
  <div class="stat-card"><div class="stat-label">Days Present</div><div class="stat-value"><?= (int) $s['totals']['days_present'] ?></div></div>
  <div class="stat-card"><div class="stat-label">Total Hours</div><div class="stat-value"><?= number_format($s['totals']['total_hours'], 1) ?></div></div>
  <div class="stat-card"><div class="stat-label">Late Minutes</div><div class="stat-value"><?= (int) $s['totals']['total_late_min'] ?></div></div>
  <div class="stat-card"><div class="stat-label">Overtime Hours</div><div class="stat-value"><?= number_format($s['totals']['total_ot_hours'], 1) ?></div></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Date</th><th>Day</th><th>Time In</th><th>Time Out</th><th>Hours</th><th>Late</th><th>OT</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($s['rows'] as $r): ?>
        <tr>
          <td><?= e(date('M j', strtotime($r['date']))) ?></td>
          <td style="color:var(--muted)"><?= e($r['day']) ?></td>
          <td><?= e($r['time_in']) ?></td>
          <td><?= e($r['time_out']) ?></td>
          <td><?= number_format($r['hours'], 1) ?></td>
          <td style="<?= $r['late_min'] ? 'color:#dc2626;font-weight:600' : 'color:var(--muted)' ?>"><?= $r['late_min'] ?: '—' ?></td>
          <td><?= $r['ot_hours'] ?: '—' ?></td>
          <td>
            <?php $cls = $r['status'] === 'late' ? 'probationary' : 'regular'; ?>
            <span class="status s-<?= $cls ?>"><?= e($r['status']) ?></span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>