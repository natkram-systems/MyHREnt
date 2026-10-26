<?php
declare(strict_types=1);
namespace MyHR\Support;

use MyHR\Core\{Auth, Database};

final class DbProvider implements DataProvider
{
    private function org(): int
    {
        return Auth::orgId() ?? 1;
    }

    private function today(): string
    {
        return date('Y-m-d');
    }

    public function currentUser(): array
    {
        $u = Auth::user();
        return $u ?? DemoData::user();
    }

    public function dashboardStats(): array
    {
        $org = $this->org();
        return [
            'total_employees'   => (int) Database::scalar("SELECT COUNT(*) FROM employees WHERE organization_id = ? AND archived_at IS NULL", [$org]),
            'active_employees'  => (int) Database::scalar("SELECT COUNT(*) FROM employees WHERE organization_id = ? AND employment_status IN ('active','regular','probationary') AND archived_at IS NULL", [$org]),
            'probationary'      => (int) Database::scalar("SELECT COUNT(*) FROM employees WHERE organization_id = ? AND employment_status = 'probationary' AND archived_at IS NULL", [$org]),
            'onboarding_active' => (int) Database::scalar("SELECT COUNT(*) FROM onboarding_records WHERE organization_id = ? AND status IN ('pending','in_progress')", [$org]),
            'open_positions'    => (int) Database::scalar("SELECT COUNT(*) FROM job_postings WHERE organization_id = ? AND status = 'published'", [$org]),
            'pending_leave'     => (int) Database::scalar("SELECT COUNT(*) FROM leave_requests WHERE organization_id = ? AND status = 'pending'", [$org]),
        ];
    }

    public function recentHires(): array
    {
        return Database::select(
            "SELECT e.employee_no,
                    CONCAT(e.first_name, ' ', e.last_name, IF(e.suffix IS NOT NULL AND e.suffix <> '', CONCAT(' ', e.suffix), '')) AS name,
                    COALESCE(p.title, '—') AS position,
                    e.date_hired,
                    COALESCE(d.name, '—') AS department
               FROM employees e
          LEFT JOIN positions p ON p.id = e.position_id
          LEFT JOIN departments d ON d.id = e.department_id
              WHERE e.organization_id = ? AND e.archived_at IS NULL
           ORDER BY e.date_hired DESC, e.id DESC
              LIMIT 5",
            [$this->org()]
        );
    }

    public function onboardingInProgress(): array
    {
        $rows = Database::select(
            "SELECT e.id AS employee_id, e.employee_no,
                    CONCAT(e.first_name, ' ', e.last_name) AS name,
                    o.start_date,
                    (SELECT COUNT(*) FROM onboarding_tasks t WHERE t.onboarding_record_id = o.id) AS total,
                    (SELECT COUNT(*) FROM onboarding_tasks t WHERE t.onboarding_record_id = o.id AND t.status = 'completed') AS done
               FROM onboarding_records o
               JOIN employees e ON e.id = o.employee_id
              WHERE o.organization_id = ? AND o.status IN ('pending','in_progress')
           ORDER BY o.start_date DESC
              LIMIT 5",
            [$this->org()]
        );
        foreach ($rows as &$r) {
            $r['progress'] = $r['total'] > 0 ? (int) round(($r['done'] / $r['total']) * 100) : 0;
        }
        return $rows;
    }

    public function employees(string $q = '', ?string $status = null): array
    {
        $sql = "SELECT e.id, e.employee_no, e.first_name, e.last_name, e.suffix,
                       e.employment_status, e.employment_type, e.date_hired, e.contact_email,
                       COALESCE(d.name, '—') AS department,
                       COALESCE(p.title, '—') AS position,
                       CASE WHEN m.id IS NULL THEN NULL ELSE CONCAT(m.first_name, ' ', m.last_name) END AS reporting_manager
                  FROM employees e
             LEFT JOIN departments d ON d.id = e.department_id
             LEFT JOIN positions p ON p.id = e.position_id
             LEFT JOIN employees m ON m.id = e.reporting_manager_id
                 WHERE e.organization_id = ? AND e.archived_at IS NULL";
        $params = [$this->org()];
        if ($q !== '') {
            $sql .= " AND (e.first_name LIKE ? OR e.last_name LIKE ? OR e.employee_no LIKE ?)";
            $like = '%' . $q . '%';
            array_push($params, $like, $like, $like);
        }
        if ($status) {
            $sql .= " AND e.employment_status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY e.id";
        return Database::select($sql, $params);
    }

    public function employee(int $id): ?array
    {
        return Database::first(
            "SELECT e.id, e.employee_no, e.first_name, e.middle_name, e.last_name, e.suffix,
                    e.employment_status, e.employment_type, e.date_hired, e.contact_email, e.contact_phone,
                    COALESCE(d.name, '—') AS department,
                    COALESCE(p.title, '—') AS position,
                    CASE WHEN m.id IS NULL THEN NULL ELSE CONCAT(m.first_name, ' ', m.last_name) END AS reporting_manager
               FROM employees e
          LEFT JOIN departments d ON d.id = e.department_id
          LEFT JOIN positions p ON p.id = e.position_id
          LEFT JOIN employees m ON m.id = e.reporting_manager_id
              WHERE e.id = ? AND e.organization_id = ?",
            [$id, $this->org()]
        );
    }

    public function employeeIdentifiers(int $id): array
    {
        $rows = Database::select(
            "SELECT id_type, last4 FROM employee_identifiers WHERE employee_id = ?",
            [$id]
        );
        $out = ['sss'=>null,'philhealth'=>null,'pagibig'=>null,'tin'=>null,'bank_account'=>null];
        foreach ($rows as $r) {
            $out[$r['id_type']] = '•••-' . $r['last4'];
        }
        return $out;
    }

    public function employeeHistory(int $id): array
    {
        return Database::select(
            "SELECT h.event_type, h.from_value, h.to_value, h.effective_date, h.notes,
                    COALESCE(u.display_name, 'System') AS recorded_by
               FROM employee_employment_history h
          LEFT JOIN users u ON u.id = h.recorded_by
              WHERE h.employee_id = ?
           ORDER BY h.effective_date DESC, h.id DESC",
            [$id]
        );
    }

    public function employeeOnboarding(int $id): ?array
    {
        $rec = Database::first(
            "SELECT * FROM onboarding_records WHERE employee_id = ?",
            [$id]
        );
        if (!$rec) return null;

        $tasks = Database::select(
            "SELECT t.id, t.name, t.due_date, t.status, t.is_mandatory AS mandatory,
                    COALESCE(u.display_name, '—') AS assigned,
                    t.remarks
               FROM onboarding_tasks t
          LEFT JOIN users u ON u.id = t.assigned_user_id
              WHERE t.onboarding_record_id = ?
           ORDER BY t.id",
            [$rec['id']]
        );

        $total = count($tasks);
        $done = count(array_filter($tasks, fn($t) => $t['status'] === 'completed'));

        return [
            'id' => (int) $rec['id'],
            'employee_id' => (int) $rec['employee_id'],
            'start_date' => $rec['start_date'],
            'status' => $rec['status'],
            'progress_pct' => $total > 0 ? (int) round(($done / $total) * 100) : 0,
            'completed_count' => $done,
            'total_count' => $total,
            'tasks' => array_map(fn($t) => [
                'id' => (int) $t['id'],
                'name' => $t['name'],
                'due_date' => $t['due_date'],
                'status' => $t['status'],
                'mandatory' => (bool) $t['mandatory'],
                'assigned' => $t['assigned'],
                'remarks' => $t['remarks'],
            ], $tasks),
        ];
    }

    public function departments(): array
    {
        return Database::select(
            "SELECT d.id, d.code, d.name,
                    COALESCE(CONCAT(e.first_name, ' ', e.last_name), '—') AS head,
                    (SELECT COUNT(*) FROM employees x WHERE x.department_id = d.id AND x.archived_at IS NULL) AS headcount,
                    d.status
               FROM departments d
          LEFT JOIN employees e ON e.id = d.head_employee_id
              WHERE d.organization_id = ?
           ORDER BY d.id",
            [$this->org()]
        );
    }

    public function positions(): array
    {
        return Database::select(
            "SELECT p.id, p.code, p.title, COALESCE(d.name, '—') AS department
               FROM positions p
          LEFT JOIN departments d ON d.id = p.department_id
              WHERE p.organization_id = ?
           ORDER BY p.id",
            [$this->org()]
        );
    }

    public function jobPostings(): array
    {
        return Database::select(
            "SELECT j.id, j.reference_no, j.title, j.employment_type, j.status,
                    j.published_at, j.expires_at,
                    COALESCE(d.name, '—') AS department,
                    (SELECT COUNT(*) FROM applications a WHERE a.job_posting_id = j.id) AS applications
               FROM job_postings j
          LEFT JOIN departments d ON d.id = j.department_id
              WHERE j.organization_id = ?
           ORDER BY j.id",
            [$this->org()]
        );
    }

    public function recruitmentPipeline(int $jobId): array
    {
        $stages = Database::select(
            "SELECT id, slug FROM recruitment_stages WHERE organization_id = ? AND status = 'active' ORDER BY sort_order",
            [$this->org()]
        );
        $out = [];
        foreach ($stages as $s) $out[$s['slug']] = [];

        $rows = Database::select(
            "SELECT a.id, a.stage_id, a.applied_at,
                    ap.first_name, ap.last_name, ap.email,
                    rs.slug AS stage_slug
               FROM applications a
               JOIN applicants ap ON ap.id = a.applicant_id
               JOIN recruitment_stages rs ON rs.id = a.stage_id
              WHERE a.organization_id = ? AND a.job_posting_id = ?
           ORDER BY a.applied_at DESC",
            [$this->org(), $jobId]
        );
        foreach ($rows as $r) {
            $slug = $r['stage_slug'];
            if (!isset($out[$slug])) $out[$slug] = [];
            $out[$slug][] = [
                'id' => (int) $r['id'],
                'name' => trim($r['first_name'] . ' ' . $r['last_name']),
                'email' => $r['email'],
                'applied_at' => $r['applied_at'],
            ];
        }
        return $out;
    }

    public function timekeepingToday(): array
    {
        $org = $this->org();
        $today = $this->today();

        $rows = Database::select(
            "SELECT e.id, e.employee_no, e.first_name, e.last_name,
                    d.time_in_am, d.time_out_pm, d.late_minutes, d.is_absent
               FROM employees e
          LEFT JOIN dtr_summaries d ON d.employee_id = e.id AND d.summary_date = ?
              WHERE e.organization_id = ?
                AND e.archived_at IS NULL
                AND e.employment_status IN ('active','regular','probationary')
           ORDER BY e.employee_no",
            [$today, $org]
        );

        $attendance = [];
        $present = $absent = $late = $missing = 0;
        foreach ($rows as $r) {
            $status = 'absent';
            if ($r['is_absent']) { $status = 'absent'; $absent++; }
            elseif (!$r['time_in_am']) { $status = 'absent'; $absent++; $missing++; }
            elseif ((int) $r['late_minutes'] > 0) { $status = 'late'; $late++; $present++; }
            else { $status = 'present'; $present++; }
            $attendance[] = [
                'employee_no' => $r['employee_no'],
                'name' => trim($r['first_name'] . ' ' . $r['last_name']),
                'time_in' => $r['time_in_am'],
                'time_out' => $r['time_out_pm'],
                'status' => $status,
                'late_min' => (int) $r['late_minutes'],
            ];
        }

        $devices = Database::select(
            "SELECT name, status, last_sync_at FROM attendance_devices WHERE organization_id = ?",
            [$org]
        );
        $devices = array_map(fn($d) => [
            'name' => $d['name'],
            'status' => $d['status'] === 'enabled' ? 'online' : 'offline',
            'last_sync' => $d['last_sync_at'] ? $this->humanizeAgo($d['last_sync_at']) : 'never',
        ], $devices);

        return [
            'date' => $today,
            'expected' => count($rows),
            'present' => $present,
            'absent' => $absent,
            'late' => $late,
            'missing_punches' => $missing,
            'devices' => $devices,
            'attendance' => $attendance,
        ];
    }

    private function humanizeAgo(string $ts): string
    {
        $diff = time() - strtotime($ts);
        if ($diff < 60) return $diff . ' seconds ago';
        if ($diff < 3600) return round($diff / 60) . ' minutes ago';
        if ($diff < 86400) return round($diff / 3600) . ' hours ago';
        return round($diff / 86400) . ' days ago';
    }

    public function dtrSummary(int $employeeId, string $month): array
    {
        $emp = Database::first(
            "SELECT id, employee_no, first_name, last_name FROM employees WHERE id = ?",
            [$employeeId]
        );
        $start = $month . '-01';
        $end = date('Y-m-t', strtotime($start));
        $rows = Database::select(
            "SELECT summary_date AS date, time_in_am AS time_in, time_out_pm AS time_out,
                    hours_worked, late_minutes, overtime_hours, is_absent
               FROM dtr_summaries
              WHERE employee_id = ? AND summary_date BETWEEN ? AND ?
           ORDER BY summary_date",
            [$employeeId, $start, $end]
        );
        $out = [];
        $totHours = $totLate = $totOt = 0;
        foreach ($rows as $r) {
            $status = $r['is_absent'] ? 'absent' : ((int) $r['late_minutes'] > 0 ? 'late' : 'present');
            $out[] = [
                'date' => $r['date'],
                'day' => date('D', strtotime($r['date'])),
                'time_in' => $r['time_in'],
                'time_out' => $r['time_out'],
                'hours' => (float) $r['hours_worked'],
                'late_min' => (int) $r['late_minutes'],
                'ot_hours' => (float) $r['overtime_hours'],
                'status' => $status,
            ];
            $totHours += (float) $r['hours_worked'];
            $totLate += (int) $r['late_minutes'];
            $totOt += (float) $r['overtime_hours'];
        }
        return [
            'employee' => [
                'id' => (int) ($emp['id'] ?? $employeeId),
                'name' => $emp ? trim($emp['first_name'] . ' ' . $emp['last_name']) : '—',
                'employee_no' => $emp['employee_no'] ?? '—',
            ],
            'month' => $month,
            'rows' => $out,
            'totals' => [
                'days_present' => count($out),
                'total_hours' => $totHours,
                'total_late_min' => $totLate,
                'total_ot_hours' => $totOt,
            ],
        ];
    }

    public function attendanceDevices(): array
    {
        return Database::select(
            "SELECT id, name, manufacturer, model, location, ip_address AS ip,
                    connection_method AS method, status, last_sync_at AS last_sync,
                    last_imported AS imported, last_rejected AS rejected
               FROM attendance_devices WHERE organization_id = ?",
            [$this->org()]
        );
    }

    public function leaveTypes(): array
    {
        return Database::select(
            "SELECT code, name, days_per_year AS days, is_paid AS paid, carryover_enabled AS carryover
               FROM leave_types WHERE organization_id = ? AND status = 'active' ORDER BY id",
            [$this->org()]
        );
    }

    public function leaveBalances(): array
    {
        $year = (int) date('Y');
        return Database::select(
            "SELECT e.employee_no, CONCAT(e.first_name, ' ', e.last_name) AS name,
                    COALESCE(SUM(CASE WHEN lt.code = 'VL' THEN lb.balance END), 0) AS vl,
                    COALESCE(SUM(CASE WHEN lt.code = 'SL' THEN lb.balance END), 0) AS sl,
                    COALESCE(SUM(CASE WHEN lt.code = 'EL' THEN lb.balance END), 0) AS el
               FROM employees e
          LEFT JOIN leave_balances lb ON lb.employee_id = e.id AND lb.year = ?
          LEFT JOIN leave_types lt ON lt.id = lb.leave_type_id
              WHERE e.organization_id = ? AND e.archived_at IS NULL
           GROUP BY e.id
           ORDER BY e.id",
            [$year, $this->org()]
        );
    }

    public function leaveRequests(): array
    {
        return Database::select(
            "SELECT lr.id, e.employee_no, CONCAT(e.first_name, ' ', e.last_name) AS name,
                    lt.name AS type, lr.date_from AS `from`, lr.date_to AS `to`,
                    lr.days, lr.status, lr.reason
               FROM leave_requests lr
               JOIN employees e ON e.id = lr.employee_id
               JOIN leave_types lt ON lt.id = lr.leave_type_id
              WHERE lr.organization_id = ?
           ORDER BY lr.created_at DESC",
            [$this->org()]
        );
    }

    public function overtimeRequests(): array
    {
        return Database::select(
            "SELECT o.id, e.employee_no, CONCAT(e.first_name, ' ', e.last_name) AS name,
                    o.ot_date AS `date`, o.hours, o.reason, o.status
               FROM overtime_requests o
               JOIN employees e ON e.id = o.employee_id
              WHERE o.organization_id = ?
           ORDER BY o.ot_date DESC",
            [$this->org()]
        );
    }

    public function payrollPeriods(): array
    {
        return Database::select(
            "SELECT pp.id, pp.name, pp.pay_date, pp.status,
                    COALESCE(pr.employee_count, 0) AS employees,
                    COALESCE(pr.total_gross, 0) AS gross,
                    COALESCE(pr.total_net, 0) AS net
               FROM payroll_periods pp
          LEFT JOIN payroll_runs pr ON pr.payroll_period_id = pp.id
              WHERE pp.organization_id = ?
           ORDER BY pp.period_start DESC",
            [$this->org()]
        );
    }

    public function payrollRunDetail(int $periodId): array
    {
        $period = Database::first(
            "SELECT * FROM payroll_periods WHERE id = ? AND organization_id = ?",
            [$periodId, $this->org()]
        );
        if (!$period) {
            return ['period' => ['id'=>$periodId,'name'=>'Unknown','pay_date'=>date('Y-m-d'),'status'=>'open'],
                    'totals' => ['gross'=>0,'total_deductions'=>0,'net'=>0,'sss_employee'=>0,'philhealth_employee'=>0,'pagibig_employee'=>0,'tax'=>0,'sss_employer'=>0,'philhealth_employer'=>0,'pagibig_employer'=>0,'total_employer'=>0],
                    'employees' => []];
        }
        $run = Database::first("SELECT * FROM payroll_runs WHERE payroll_period_id = ?", [$periodId]);

        $employees = [];
        $tGross = $tDed = $tNet = $tSssE = $tPhiE = $tPagE = $tTax = $tSssR = $tPhiR = $tPagR = 0;
        if ($run) {
            $rows = Database::select(
                "SELECT pre.id AS pre_id, e.employee_no,
                        CONCAT(e.first_name, ' ', e.last_name) AS name,
                        pre.basic_pay AS basic, pre.allowances AS allowance, pre.overtime_pay AS ot,
                        pre.gross_pay AS gross, pre.total_deductions AS total_deductions, pre.net_pay AS net
                   FROM payroll_run_employees pre
                   JOIN employees e ON e.id = pre.employee_id
                  WHERE pre.payroll_run_id = ?
               ORDER BY e.id",
                [$run['id']]
            );
            foreach ($rows as $r) {
                $contribs = Database::select(
                    "SELECT agency, amount FROM payroll_employee_contributions WHERE payroll_run_employee_id = ?",
                    [$r['pre_id']]
                );
                $map = array_column($contribs, 'amount', 'agency');

                $employer = Database::select(
                    "SELECT agency, amount FROM payroll_employer_contributions WHERE payroll_run_employee_id = ?",
                    [$r['pre_id']]
                );
                $empMap = array_column($employer, 'amount', 'agency');

                $other = (float) Database::scalar(
                    "SELECT COALESCE(SUM(amount), 0) FROM payroll_deductions WHERE payroll_run_employee_id = ?",
                    [$r['pre_id']]
                );

                $employees[] = [
                    'employee_no' => $r['employee_no'],
                    'name' => $r['name'],
                    'basic' => (float) $r['basic'],
                    'allowance' => (float) $r['allowance'],
                    'ot' => (float) $r['ot'],
                    'gross' => (float) $r['gross'],
                    'sss' => (float) ($map['sss'] ?? 0),
                    'phil' => (float) ($map['philhealth'] ?? 0),
                    'pagibig' => (float) ($map['pagibig'] ?? 0),
                    'tax' => (float) ($map['bir'] ?? 0),
                    'other' => $other,
                    'net' => (float) $r['net'],
                ];
                $tGross += (float) $r['gross'];
                $tDed += (float) $r['total_deductions'];
                $tNet += (float) $r['net'];
                $tSssE += (float) ($map['sss'] ?? 0);
                $tPhiE += (float) ($map['philhealth'] ?? 0);
                $tPagE += (float) ($map['pagibig'] ?? 0);
                $tTax += (float) ($map['bir'] ?? 0);
                $tSssR += (float) ($empMap['sss'] ?? 0);
                $tPhiR += (float) ($empMap['philhealth'] ?? 0);
                $tPagR += (float) ($empMap['pagibig'] ?? 0);
            }
        }

        return [
            'period' => ['id'=>(int)$period['id'],'name'=>$period['name'],'pay_date'=>$period['pay_date'],'status'=>$period['status']],
            'totals' => [
                'gross' => $tGross,
                'total_deductions' => $tDed,
                'net' => $tNet,
                'sss_employee' => $tSssE,
                'philhealth_employee' => $tPhiE,
                'pagibig_employee' => $tPagE,
                'tax' => $tTax,
                'sss_employer' => $tSssR,
                'philhealth_employer' => $tPhiR,
                'pagibig_employer' => $tPagR,
                'total_employer' => $tSssR + $tPhiR + $tPagR,
            ],
            'employees' => $employees,
        ];
    }

    public function payslip(int $employeeId, int $periodId): array
    {
        $period = Database::first("SELECT * FROM payroll_periods WHERE id = ?", [$periodId]);
        $run = Database::first("SELECT * FROM payroll_runs WHERE payroll_period_id = ?", [$periodId]);
        if (!$period || !$run) {
            return ['employee'=>['employee_no'=>'—','name'=>'—','department'=>'—','position'=>'—'],
                    'period'=>['name'=>'—','pay_date'=>date('Y-m-d'),'reference'=>'—'],
                    'earnings'=>[], 'deductions'=>[], 'gross'=>0,'total_deductions'=>0,'net'=>0];
        }
        $pre = Database::first(
            "SELECT * FROM payroll_run_employees WHERE payroll_run_id = ? AND employee_id = ?",
            [$run['id'], $employeeId]
        );
        if (!$pre) {
            return ['employee'=>['employee_no'=>'—','name'=>'—','department'=>'—','position'=>'—'],
                    'period'=>['name'=>$period['name'],'pay_date'=>$period['pay_date'],'reference'=>'—'],
                    'earnings'=>[], 'deductions'=>[], 'gross'=>0,'total_deductions'=>0,'net'=>0];
        }
        $emp = Database::first(
            "SELECT e.employee_no, e.first_name, e.last_name,
                    COALESCE(d.name,'—') AS department, COALESCE(p.title,'—') AS position
               FROM employees e
          LEFT JOIN departments d ON d.id = e.department_id
          LEFT JOIN positions p ON p.id = e.position_id
              WHERE e.id = ?",
            [$employeeId]
        );
        $contribs = Database::select(
            "SELECT agency, amount FROM payroll_employee_contributions WHERE payroll_run_employee_id = ?",
            [$pre['id']]
        );
        $cm = array_column($contribs, 'amount', 'agency');
        $employer = Database::select(
            "SELECT agency, amount FROM payroll_employer_contributions WHERE payroll_run_employee_id = ?",
            [$pre['id']]
        );
        $em = array_column($employer, 'amount', 'agency');
        $ps = Database::first(
            "SELECT reference_no FROM payslips WHERE payroll_run_employee_id = ?",
            [$pre['id']]
        );

        return [
            'employee' => [
                'employee_no' => $emp['employee_no'],
                'name' => trim($emp['first_name'] . ' ' . $emp['last_name']),
                'department' => $emp['department'],
                'position' => $emp['position'],
            ],
            'period' => [
                'name' => $period['name'],
                'pay_date' => $period['pay_date'],
                'reference' => $ps['reference_no'] ?? ('PAY-' . $periodId . '-' . $employeeId),
            ],
            'earnings' => [
                ['label' => 'Basic Salary', 'amount' => (float) $pre['basic_pay']],
                ['label' => 'Allowances', 'amount' => (float) $pre['allowances']],
                ['label' => 'Overtime', 'amount' => (float) $pre['overtime_pay']],
            ],
            'deductions' => [
                ['label' => 'SSS Contribution', 'amount' => (float) ($cm['sss'] ?? 0)],
                ['label' => 'PhilHealth', 'amount' => (float) ($cm['philhealth'] ?? 0)],
                ['label' => 'Pag-IBIG', 'amount' => (float) ($cm['pagibig'] ?? 0)],
                ['label' => 'Withholding Tax', 'amount' => (float) ($cm['bir'] ?? 0)],
            ],
            'gross' => (float) $pre['gross_pay'],
            'total_deductions' => (float) $pre['total_deductions'],
            'net' => (float) $pre['net_pay'],
            'employer' => [
                'sss' => (float) ($em['sss'] ?? 0),
                'philhealth' => (float) ($em['philhealth'] ?? 0),
                'pagibig' => (float) ($em['pagibig'] ?? 0),
                'total' => (float) (($em['sss'] ?? 0) + ($em['philhealth'] ?? 0) + ($em['pagibig'] ?? 0)),
            ],
        ];
    }

    public function contributionRuleSets(): array
    {
        return Database::select(
            "SELECT agency, effective_from, source_reference AS source, verified
               FROM contribution_rule_sets WHERE organization_id = ?
           ORDER BY agency, effective_from DESC",
            [$this->org()]
        );
    }

    public function loans(): array
    {
        return Database::select(
            "SELECT l.id, e.employee_no, CONCAT(e.first_name, ' ', e.last_name) AS name,
                    l.loan_type AS type, l.principal, l.total_paid AS paid, l.balance,
                    l.monthly_amortization AS monthly, l.start_date AS `start`, l.status
               FROM employee_loans l
               JOIN employees e ON e.id = l.employee_id
              WHERE l.organization_id = ?
           ORDER BY l.id",
            [$this->org()]
        );
    }

    public function benefits(): array
    {
        return Database::select(
            "SELECT id, name, provider, coverage, cost, frequency, status
               FROM benefits WHERE organization_id = ? ORDER BY id",
            [$this->org()]
        );
    }

    public function assets(): array
    {
        $org = $this->org();
        return Database::select(
            "SELECT a.id, a.asset_no AS asset_id, a.description, a.serial_number AS serial,
                    CASE WHEN aa.id IS NULL THEN NULL ELSE CONCAT(e.first_name, ' ', e.last_name) END AS assigned_to,
                    a.condition_state AS `condition`, aa.assigned_at,
                    CASE WHEN aa.id IS NULL THEN 'available' ELSE 'assigned' END AS status
               FROM assets a
          LEFT JOIN asset_assignments aa ON aa.asset_id = a.id AND aa.status = 'active'
          LEFT JOIN employees e ON e.id = aa.employee_id
              WHERE a.organization_id = ?
           ORDER BY a.id",
            [$org]
        );
    }

    public function performanceReviews(): array
    {
        return Database::select(
            "SELECT pr.id, e.employee_no, CONCAT(e.first_name, ' ', e.last_name) AS name,
                    pr.period, pr.overall_rating AS rating,
                    COALESCE(u.display_name, '—') AS reviewer,
                    pr.status, pr.scheduled_date AS `date`
               FROM performance_reviews pr
               JOIN employees e ON e.id = pr.employee_id
          LEFT JOIN users u ON u.id = pr.reviewer_id
              WHERE pr.organization_id = ?
           ORDER BY pr.id",
            [$this->org()]
        );
    }

    public function trainingRecords(): array
    {
        return Database::select(
            "SELECT t.id, e.employee_no, CONCAT(e.first_name, ' ', e.last_name) AS name,
                    t.course, t.provider, t.training_date AS `date`, t.score, t.status
               FROM training_records t
               JOIN employees e ON e.id = t.employee_id
              WHERE t.organization_id = ?
           ORDER BY t.id",
            [$this->org()]
        );
    }

    public function announcements(): array
    {
        return Database::select(
            "SELECT a.id, a.title, a.body, a.published_at, a.priority,
                    COALESCE(u.display_name, 'System') AS author
               FROM announcements a
          LEFT JOIN users u ON u.id = a.author_id
              WHERE a.organization_id = ? AND a.status = 'published'
           ORDER BY a.published_at DESC",
            [$this->org()]
        );
    }

    public function companySettings(): array
    {
        $rows = Database::select(
            "SELECT setting_key, setting_value FROM company_settings WHERE organization_id = ?",
            [$this->org()]
        );
        $map = array_column($rows, 'setting_value', 'setting_key');
        return [
            'company_name' => $map['company_name'] ?? 'Natkram-Systems Inc.',
            'company_address' => $map['company_address'] ?? '',
            'company_phone' => $map['company_phone'] ?? '',
            'company_email' => $map['company_email'] ?? '',
            'payroll_frequency' => $map['payroll_frequency'] ?? 'semi_monthly',
            'payroll_cutoff_1' => (int) ($map['payroll_cutoff_1'] ?? 15),
            'payroll_cutoff_2' => (int) ($map['payroll_cutoff_2'] ?? 31),
            'attendance_grace_minutes' => (int) ($map['attendance_grace_minutes'] ?? 5),
            'standard_work_hours' => (int) ($map['standard_work_hours'] ?? 8),
        ];
    }

    public function auditLogs(int $limit = 20): array
    {
        return Database::select(
            "SELECT a.id, a.action, a.module, a.record_id AS record,
                    COALESCE(u.display_name, 'System') AS `user`,
                    a.status, a.created_at
               FROM audit_logs a
          LEFT JOIN users u ON u.id = a.user_id
              WHERE a.organization_id = ?
           ORDER BY a.id DESC
              LIMIT " . (int) $limit,
            [$this->org()]
        );
    }
}