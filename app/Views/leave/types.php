<div class="page-header">
  <div><h1 class="page-title">Leave Types</h1><p class="page-subtitle"><?= count($rows) ?> configured</p></div>
  <a class="btn btn-dark">+ New Type</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Code</th><th>Name</th><th>Days / Year</th><th>Paid</th><th>Carryover</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $t): ?>
        <tr>
          <td style="font-family:monospace;font-size:.82rem"><?= e($t['code']) ?></td>
          <td style="font-weight:600"><?= e($t['name']) ?></td>
          <td><?= (int) $t['days'] ?></td>
          <td><?= $t['paid'] ? '<span class="status s-completed">Yes</span>' : '<span class="status s-inactive">No</span>' ?></td>
          <td><?= $t['carryover'] ? '<span class="status s-completed">Yes</span>' : '<span class="status s-inactive">No</span>' ?></td>
          <td style="text-align:right"><button class="btn btn-sm btn-outline">Edit</button></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>