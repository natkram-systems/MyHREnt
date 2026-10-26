<div class="page-header">
  <div><h1 class="page-title">Job Postings</h1><p class="page-subtitle"><?= count($rows) ?> postings</p></div>
  <a class="btn btn-dark">+ New Job Posting</a>
</div>
<div class="card">
  <table>
    <thead><tr><th>Reference</th><th>Title</th><th>Dept</th><th>Type</th><th>Applications</th><th>Status</th><th>Expires</th><th></th></tr></thead>
    <tbody>
      <?php foreach ($rows as $j): ?>
        <tr>
          <td style="font-family:monospace;font-size:.78rem"><?= e($j['reference_no']) ?></td>
          <td style="font-weight:600"><?= e($j['title']) ?></td>
          <td><?= e($j['department']) ?></td>
          <td><?= e($j['employment_type']) ?></td>
          <td><strong><?= (int) $j['applications'] ?></strong></td>
          <td><span class="status s-<?= e($j['status']) ?>"><?= e($j['status']) ?></span></td>
          <td style="color:var(--muted)"><?= $j['expires_at'] ? e(date('M j, Y', strtotime($j['expires_at']))) : '—' ?></td>
          <td style="text-align:right"><a class="btn btn-sm btn-outline" href="<?= app_url('jobs/'.$j['id'].'/pipeline') ?>">Pipeline</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>