<div class="page-header">
  <div><h1 class="page-title">Biometric Devices</h1><p class="page-subtitle"><?= count($rows) ?> configured</p></div>
  <a class="btn btn-dark">+ Add Device</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Name</th><th>Make/Model</th><th>Location</th><th>IP</th><th>Method</th><th>Last Sync</th><th>Imported</th><th>Rejected</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $d): ?>
        <tr>
          <td style="font-weight:600"><?= e($d['name']) ?></td>
          <td><?= e($d['manufacturer'].' '.$d['model']) ?></td>
          <td style="color:var(--muted)"><?= e($d['location']) ?></td>
          <td style="font-family:monospace;font-size:.78rem"><?= e($d['ip']) ?></td>
          <td><?= e($d['method']) ?></td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($d['last_sync']) ?></td>
          <td><?= (int) $d['imported'] ?></td>
          <td><?= (int) $d['rejected'] ?></td>
          <td><span class="status s-<?= e($d['status']) ?>"><?= e($d['status']) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>