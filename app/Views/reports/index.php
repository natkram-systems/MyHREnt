<div class="page-header">
  <div><h1 class="page-title">Reports</h1><p class="page-subtitle">Export and print authorized reports</p></div>
</div>
<div class="row">
  <?php
  $reports = [
    ['Employee Master File', 'Complete employee list'],
    ['DTR Summary', 'Daily time record per employee'],
    ['Payroll Register', 'Full payroll with earnings and deductions'],
    ['SSS Report', 'SSS contribution summary'],
    ['PhilHealth Report', 'PhilHealth contribution summary'],
    ['Pag-IBIG Report', 'Pag-IBIG contribution summary'],
    ['Withholding Tax', 'BIR tax withheld per employee'],
    ['Loan Deduction', 'Active loans and deductions'],
    ['Attendance Deductions', 'Late, absence, undertime'],
    ['Headcount', 'By department, position, type'],
  ];
  foreach ($reports as [$name, $desc]):
  ?>
    <div class="col-2" style="flex:1 1 calc(33.33% - .7rem);min-width:240px">
      <div class="card" style="height:100%">
        <div class="card-body">
          <div style="font-weight:600;margin-bottom:.5rem"><?= e($name) ?></div>
          <p style="color:var(--muted);font-size:.82rem;margin-bottom:1rem"><?= e($desc) ?></p>
          <div style="display:flex;gap:.4rem">
            <a class="btn btn-sm btn-outline">PDF</a>
            <a class="btn btn-sm btn-outline">Excel</a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>