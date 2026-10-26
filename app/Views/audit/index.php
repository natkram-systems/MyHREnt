<div class="page-header">
  <div><h1 class="page-title">Audit Trail</h1><p class="page-subtitle"><?= count($rows) ?> recent events</p></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Time</th><th>User</th><th>Action</th><th>Module</th><th>Record</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $a): ?>
        <tr>
          <td style="font-family:monospace;font-size:.78rem;color:var(--muted)"><?= e($a['created_at']) ?></td>
          <td style="font-size:.85rem"><?= e($a['user']) ?></td>
          <td><code style="font-size:.78rem"><?= e($a['action']) ?></code></td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($a['module']) ?></td>
          <td style="color:var(--muted);font-size:.82rem"><?= e($a['record'] ?? '—') ?></td>
          <td>
            <?php $cls = $a['status'] === 'success' ? 'active' : 'terminated'; ?>
            <span class="status s-<?= $cls ?>"><?= e($a['status']) ?></span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>