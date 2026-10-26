<div class="page-header">
  <div><h1 class="page-title">Benefits & Compensation</h1><p class="page-subtitle"><?= count($rows) ?> active benefits</p></div>
</div>
<div class="card">
  <table>
    <thead><tr><th>Name</th><th>Provider</th><th>Coverage</th><th>Cost</th><th>Frequency</th><th>Status</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $b): ?>
        <tr>
          <td style="font-weight:600"><?= e($b['name']) ?></td>
          <td><?= e($b['provider']) ?></td>
          <td style="color:var(--muted)"><?= e($b['coverage']) ?></td>
          <td>₱<?= number_format($b['cost'], 2) ?></td>
          <td><?= e($b['frequency']) ?></td>
          <td><span class="status s-<?= e($b['status']) ?>"><?= e($b['status']) ?></span></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>