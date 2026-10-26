<div class="page-header">
  <div><h1 class="page-title">Departments</h1><p class="page-subtitle"><?= count($rows) ?> departments</p></div>
  <a class="btn btn-dark">+ New Department</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Code</th><th>Name</th><th>Head</th><th>Headcount</th><th>Status</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $d): ?>
        <tr>
          <td style="font-family:monospace;font-size:.82rem"><?= e($d['code']) ?></td>
          <td style="font-weight:600"><?= e($d['name']) ?></td>
          <td><?= e($d['head']) ?></td>
          <td><?= (int) $d['headcount'] ?></td>
          <td><span class="status s-<?= e($d['status']) ?>"><?= e($d['status']) ?></span></td>
          <td style="text-align:right"><button class="btn btn-sm btn-outline">Edit</button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>