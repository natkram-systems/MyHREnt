<div class="page-header">
  <div><h1 class="page-title">DTR Terminal</h1><p class="page-subtitle">Scan barcode · <span id="clock"></span></p></div>
  <a href="<?= app_url('timekeeping') ?>" class="btn btn-outline">← Dashboard</a>
</div>
<div class="row">
  <div class="col-2" style="flex:2 1 480px">
    <div class="card">
      <div class="card-body">
        <label style="font-weight:600;font-size:1rem">Scan employee barcode</label>
        <input id="barcode" class="terminal-input" style="margin-top:.75rem" placeholder="Scan or type employee ID, then Enter" autofocus autocomplete="off">
        <div id="scanResult" style="margin-top:1.5rem"></div>
        <div style="margin-top:1.5rem">
          <div style="color:var(--muted);font-size:.78rem;margin-bottom:.5rem">Or select action:</div>
          <?php foreach (['TIME IN AM', 'TIME OUT NOON', 'TIME IN PM', 'COFFEE OUT', 'COFFEE IN', 'TIME OUT PM', 'TIME IN OT', 'TIME OUT OT'] as $i => $a): ?>
            <button class="action-btn <?= $i === 0 ? 'active' : '' ?>" data-action="<?= e($a) ?>"><?= e($a) ?></button>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-2" style="flex:1 1 320px">
    <div class="card">
      <div class="card-header">Recent Scans</div>
      <table>
        <thead><tr><th>Time</th><th>Employee</th><th>Event</th></tr></thead>
        <tbody id="recentScans">
          <tr><td colspan="3" style="text-align:center;padding:2rem;color:var(--muted)">No scans yet</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
const employees = <?= json_encode(array_column(\MyHR\Support\DemoData::employees(), 'employee_no', 'id')) ?>;
const names = {};
<?php foreach (\MyHR\Support\DemoData::employees() as $emp): ?>
names[<?= json_encode($emp['employee_no']) ?>] = <?= json_encode($emp['first_name'].' '.$emp['last_name']) ?>;
<?php endforeach; ?>
const inp = document.getElementById('barcode');
const result = document.getElementById('scanResult');
const recent = document.getElementById('recentScans');
let scans = [];
let action = 'TIME IN AM';
document.querySelectorAll('.action-btn').forEach(b => b.addEventListener('click', () => {
  action = b.dataset.action;
  document.querySelectorAll('.action-btn').forEach(x => x.classList.remove('active'));
  b.classList.add('active');
  inp.focus();
}));
inp.addEventListener('keydown', e => {
  if (e.key !== 'Enter') return;
  e.preventDefault();
  const code = inp.value.trim().toUpperCase();
  if (!code) return;
  const name = names[code];
  const time = new Date().toLocaleTimeString('en-US', { hour12: false });
  if (name) {
    result.innerHTML = '<div style="background:#dcfce7;color:#166534;padding:1rem;border-radius:.5rem"><div style="font-weight:700">' + name + '</div><div style="font-size:.82rem">' + code + ' · <strong>' + action + '</strong> · ' + time + '</div></div>';
    scans.unshift({ time, name, action });
    scans = scans.slice(0, 8);
    recent.innerHTML = scans.map(s => '<tr><td style="color:var(--muted);font-family:monospace">' + s.time + '</td><td>' + s.name + '</td><td><span class="status s-active">' + s.action + '</span></td></tr>').join('');
  } else {
    result.innerHTML = '<div style="background:#fee2e2;color:#991b1b;padding:1rem;border-radius:.5rem"><strong>Unknown barcode</strong> — ' + code + '</div>';
  }
  inp.value = '';
  setTimeout(() => inp.focus(), 100);
});
inp.focus();
setInterval(() => {
  document.getElementById('clock').textContent = new Date().toLocaleTimeString('en-US', { hour12: false });
}, 1000);
</script>