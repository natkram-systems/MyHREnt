<div class="page-header">
  <div><h1 class="page-title">Assets</h1><p class="page-subtitle"><?= count($rows) ?> assets</p></div>
  <a class="btn btn-dark">+ New Asset</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Asset ID</th><th>Description</th><th>Serial</th><th>Assigned To</th><th>Condition</th><th>Since</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $a): ?>
        <tr>
          <td style="font-family:monospace;font-size:.82rem"><?= e($a['asset_id']) ?></td>
          <td style="font-weight:600"><?= e($a['description']) ?></td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($a['serial']) ?></td>
          <td><?= e($a['assigned_to'] ?? '—') ?></td>
          <td><?= e($a['condition']) ?></td>
          <td style="color:var(--muted)"><?= $a['assigned_at'] ? e(date('M j, Y', strtotime($a['assigned_at']))) : '—' ?></td>
          <td><span class="status s-<?= e($a['status']) ?>"><?= e($a['status']) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>