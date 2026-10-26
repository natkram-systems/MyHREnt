<div class="page-header">
  <div><h1 class="page-title">Positions</h1><p class="page-subtitle"><?= count($rows) ?> positions</p></div>
  <a class="btn btn-dark">+ New Position</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Code</th><th>Title</th><th>Department</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $p): ?>
        <tr>
          <td style="font-family:monospace;font-size:.82rem"><?= e($p['code']) ?></td>
          <td style="font-weight:600"><?= e($p['title']) ?></td>
          <td><?= e($p['department']) ?></td>
          <td style="text-align:right"><button class="btn btn-sm btn-outline">Edit</button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>