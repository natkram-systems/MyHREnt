<div class="page-header">
  <div><h1 class="page-title">Employees</h1><p class="page-subtitle"><?= count($rows) ?> employee<?= count($rows) === 1 ? '' : 's' ?></p></div>
  <a class="btn btn-dark">+ Add Employee</a>
</div>
<div class="card" style="padding:1rem;margin-bottom:1rem">
  <form method="get">
    <input type="search" name="q" value="<?= e($q) ?>" placeholder="Search by name or employee number…" style="width:100%;padding:.5rem .75rem;border:1px solid var(--border);border-radius:.5rem;background:var(--bg);color:var(--text)">
  </form>
</div>
<div class="card">
  <?php if (empty($rows)): ?>
    <div class="empty"><h3>No results</h3></div>
  <?php else: ?>
    <table>
      <thead><tr><th>Employee</th><th>Employee No.</th><th>Department</th><th>Position</th><th>Status</th><th>Date Hired</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:.6rem">
                <div class="avatar"><?= e(strtoupper(substr($r['first_name'], 0, 1) . substr($r['last_name'], 0, 1))) ?></div>
                <div>
                  <div style="font-weight:600;font-size:.875rem"><?= e($r['first_name'].' '.$r['last_name']) ?></div>
                  <div style="color:var(--muted);font-size:.72rem"><?= e($r['contact_email']) ?></div>
                </div>
              </div>
            </td>
            <td style="color:var(--muted);font-family:monospace;font-size:.82rem"><?= e($r['employee_no']) ?></td>
            <td><?= e($r['department']) ?></td>
            <td><?= e($r['position']) ?></td>
            <td><span class="status s-<?= e($r['employment_status']) ?>"><?= e(str_replace('_', ' ', $r['employment_status'])) ?></span></td>
            <td style="color:var(--muted)"><?= e(date('M j, Y', strtotime($r['date_hired']))) ?></td>
            <td style="text-align:right"><a class="btn btn-sm btn-outline" href="<?= app_url('employees/'.$r['id']) ?>">View</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>