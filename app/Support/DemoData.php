<?php
declare(strict_types=1);
namespace MyHR\Support;

final class DemoData
{
    public static function user(): array
    {
        return ['id'=>1,'organization_id'=>1,'email'=>'hr.admin@natkram.local',
            'display_name'=>'Ana Reyes','status'=>'active','must_change_password'=>0,
            'org_name'=>'Natkram-Systems Inc.','timezone'=>'Asia/Manila'];
    }

    public static function departments(): array
    {
        return [
            ['id'=>1,'code'=>'ENG','name'=>'Engineering','head'=>'Maria Santos','headcount'=>12,'status'=>'active'],
            ['id'=>2,'code'=>'HR','name'=>'Human Resources','head'=>'Ana Reyes','headcount'=>4,'status'=>'active'],
            ['id'=>3,'code'=>'FIN','name'=>'Finance','head'=>'Jessica Cruz','headcount'=>5,'status'=>'active'],
            ['id'=>4,'code'=>'SAL','name'=>'Sales','head'=>'Miguel Tan','headcount'=>8,'status'=>'active'],
            ['id'=>5,'code'=>'OPS','name'=>'Operations','head'=>'Robert Go','headcount'=>6,'status'=>'active'],
            ['id'=>6,'code'=>'MKT','name'=>'Marketing','head'=>'Sofia Lim','headcount'=>3,'status'=>'active'],
        ];
    }

    public static function positions(): array
    {
        return [
            ['id'=>1,'code'=>'ENG-MGR','title'=>'Engineering Manager','department'=>'Engineering'],
            ['id'=>2,'code'=>'ENG-SR','title'=>'Senior Developer','department'=>'Engineering'],
            ['id'=>3,'code'=>'ENG-JR','title'=>'Junior Developer','department'=>'Engineering'],
            ['id'=>4,'code'=>'HR-OFF','title'=>'HR Officer','department'=>'Human Resources'],
            ['id'=>5,'code'=>'HR-PAY','title'=>'Payroll Specialist','department'=>'Human Resources'],
            ['id'=>6,'code'=>'SAL-EXE','title'=>'Sales Executive','department'=>'Sales'],
            ['id'=>7,'code'=>'OPS-SUP','title'=>'Operations Supervisor','department'=>'Operations'],
            ['id'=>8,'code'=>'MKT-LEAD','title'=>'Marketing Lead','department'=>'Marketing'],
        ];
    }

    public static function employees(): array
    {
        return [
            ['id'=>1,'employee_no'=>'EMP-2026-0001','first_name'=>'Maria','last_name'=>'Santos','department'=>'Engineering','position'=>'Engineering Manager','employment_status'=>'regular','employment_type'=>'regular','date_hired'=>'2022-03-15','contact_email'=>'maria.santos@natkram.local','reporting_manager'=>null],
            ['id'=>2,'employee_no'=>'EMP-2026-0002','first_name'=>'Juan','last_name'=>'Dela Cruz','department'=>'Engineering','position'=>'Senior Developer','employment_status'=>'probationary','employment_type'=>'probationary','date_hired'=>'2026-08-01','contact_email'=>'juan.delacruz@natkram.local','reporting_manager'=>'Maria Santos'],
            ['id'=>3,'employee_no'=>'EMP-2026-0003','first_name'=>'Ana','last_name'=>'Reyes','department'=>'Human Resources','position'=>'HR Officer','employment_status'=>'regular','employment_type'=>'regular','date_hired'=>'2021-07-12','contact_email'=>'ana.reyes@natkram.local','reporting_manager'=>null],
            ['id'=>4,'employee_no'=>'EMP-2026-0004','first_name'=>'Carlos','last_name'=>'Mendoza','department'=>'Human Resources','position'=>'Payroll Specialist','employment_status'=>'regular','employment_type'=>'regular','date_hired'=>'2023-01-09','contact_email'=>'carlos.mendoza@natkram.local','reporting_manager'=>'Ana Reyes'],
            ['id'=>5,'employee_no'=>'EMP-2026-0005','first_name'=>'Sofia','last_name'=>'Lim','department'=>'Marketing','position'=>'Marketing Lead','employment_status'=>'probationary','employment_type'=>'probationary','date_hired'=>'2026-06-15','contact_email'=>'sofia.lim@natkram.local','reporting_manager'=>null],
            ['id'=>6,'employee_no'=>'EMP-2026-0006','first_name'=>'Miguel','last_name'=>'Tan','department'=>'Sales','position'=>'Sales Executive','employment_status'=>'regular','employment_type'=>'regular','date_hired'=>'2020-11-04','contact_email'=>'miguel.tan@natkram.local','reporting_manager'=>null],
            ['id'=>7,'employee_no'=>'EMP-2026-0007','first_name'=>'Jessica','last_name'=>'Cruz','department'=>'Finance','position'=>'Finance Analyst','employment_status'=>'regular','employment_type'=>'regular','date_hired'=>'2022-09-20','contact_email'=>'jessica.cruz@natkram.local','reporting_manager'=>null],
            ['id'=>8,'employee_no'=>'EMP-2026-0008','first_name'=>'Robert','last_name'=>'Go','suffix'=>'Jr.','department'=>'Operations','position'=>'Operations Supervisor','employment_status'=>'probationary','employment_type'=>'probationary','date_hired'=>'2026-10-15','contact_email'=>'robert.go@natkram.local','reporting_manager'=>null],
        ];
    }

    public static function employeeIdentifiers(int $id): array
    {
        return match($id){
            1=>['sss'=>'•••-4521','philhealth'=>'•••-8830','pagibig'=>'•••-1192','tin'=>'•••-7745','bank_account'=>'•••-3301'],
            2=>['sss'=>'•••-7703','philhealth'=>'•••-4428','pagibig'=>'•••-5561','tin'=>'•••-2219','bank_account'=>'•••-8824'],
            default=>['sss'=>null,'philhealth'=>null,'pagibig'=>null,'tin'=>null,'bank_account'=>null],
        };
    }

    public static function employeeHistory(int $id): array
    {
        return match($id){
            1=>[
                ['event_type'=>'hired','from_value'=>null,'to_value'=>'Probationary','effective_date'=>'2022-03-15','notes'=>'Initial hire','recorded_by'=>'System'],
                ['event_type'=>'regularized','from_value'=>'Probationary','to_value'=>'Regular','effective_date'=>'2022-09-15','notes'=>'Passed probation','recorded_by'=>'Ana Reyes'],
                ['event_type'=>'promoted','from_value'=>'Senior Developer','to_value'=>'Engineering Manager','effective_date'=>'2024-01-01','notes'=>'Team growth','recorded_by'=>'Ana Reyes'],
            ],
            8=>[['event_type'=>'hired','from_value'=>'Applicant','to_value'=>'Probationary','effective_date'=>'2026-10-15','notes'=>'Offer accepted','recorded_by'=>'Ana Reyes']],
            default=>[],
        };
    }

    public static function employeeOnboarding(int $id): ?array
    {
        if ($id !== 8) return null;
        return [
            'id'=>1,'employee_id'=>8,'start_date'=>'2026-10-15','status'=>'in_progress',
            'progress_pct'=>38,'completed_count'=>3,'total_count'=>8,
            'tasks'=>[
                ['id'=>1,'name'=>'Employment Contract','due_date'=>'2026-10-15','status'=>'completed','mandatory'=>true,'assigned'=>'Ana Reyes','remarks'=>'Signed 10/15'],
                ['id'=>2,'name'=>'Employee Information Form','due_date'=>'2026-10-16','status'=>'completed','mandatory'=>true,'assigned'=>'Ana Reyes','remarks'=>'Complete'],
                ['id'=>3,'name'=>'Government IDs','due_date'=>'2026-10-20','status'=>'in_progress','mandatory'=>true,'assigned'=>'Ana Reyes','remarks'=>'SSS & TIN submitted, PhilHealth pending'],
                ['id'=>4,'name'=>'Bank Account Details','due_date'=>'2026-10-20','status'=>'pending','mandatory'=>true,'assigned'=>'Ana Reyes','remarks'=>null],
                ['id'=>5,'name'=>'Company Policies Acknowledgment','due_date'=>'2026-10-18','status'=>'pending','mandatory'=>true,'assigned'=>'Ana Reyes','remarks'=>null],
                ['id'=>6,'name'=>'IT Account Creation','due_date'=>'2026-10-15','status'=>'completed','mandatory'=>true,'assigned'=>'Super Admin','remarks'=>'Email active'],
                ['id'=>7,'name'=>'Asset Assignment','due_date'=>'2026-10-16','status'=>'pending','mandatory'=>true,'assigned'=>'Ana Reyes','remarks'=>'Laptop scheduled Friday'],
                ['id'=>8,'name'=>'Department Orientation','due_date'=>'2026-10-18','status'=>'pending','mandatory'=>false,'assigned'=>'Ana Reyes','remarks'=>null],
            ],
        ];
    }

    public static function dashboardStats(): array
    {
        return ['total_employees'=>8,'active_employees'=>7,'probationary'=>3,'onboarding_active'=>1,'open_positions'=>4,'pending_leave'=>2];
    }

    public static function recentHires(): array
    {
        return [
            ['employee_no'=>'EMP-2026-0008','name'=>'Robert Go Jr.','position'=>'Operations Supervisor','date_hired'=>'2026-10-15','department'=>'Operations'],
            ['employee_no'=>'EMP-2026-0005','name'=>'Sofia Lim','position'=>'Marketing Lead','date_hired'=>'2026-06-15','department'=>'Marketing'],
            ['employee_no'=>'EMP-2026-0002','name'=>'Juan Dela Cruz','position'=>'Senior Developer','date_hired'=>'2026-08-01','department'=>'Engineering'],
        ];
    }

    public static function onboardingInProgress(): array
    {
        return [['employee_no'=>'EMP-2026-0008','name'=>'Robert Go Jr.','start_date'=>'2026-10-15','progress'=>38,'employee_id'=>8]];
    }

    public static function jobPostings(): array
    {
        return [
            ['id'=>1,'reference_no'=>'JOB-2026-A1B2C3','title'=>'Junior Developer','department'=>'Engineering','employment_type'=>'regular','status'=>'published','published_at'=>'2026-10-10','expires_at'=>'2026-12-31','applications'=>7],
            ['id'=>2,'reference_no'=>'JOB-2026-D4E5F6','title'=>'Sales Executive','department'=>'Sales','employment_type'=>'regular','status'=>'published','published_at'=>'2026-10-08','expires_at'=>'2026-12-01','applications'=>4],
            ['id'=>3,'reference_no'=>'JOB-2026-G7H8I9','title'=>'HR Assistant','department'=>'Human Resources','employment_type'=>'probationary','status'=>'published','published_at'=>'2026-10-12','expires_at'=>'2026-11-30','applications'=>3],
            ['id'=>4,'reference_no'=>'JOB-2026-J1K2L3','title'=>'Marketing Coordinator','department'=>'Marketing','employment_type'=>'regular','status'=>'published','published_at'=>'2026-10-05','expires_at'=>'2026-11-15','applications'=>5],
            ['id'=>5,'reference_no'=>'JOB-2026-M4N5O6','title'=>'Finance Analyst','department'=>'Finance','employment_type'=>'regular','status'=>'draft','published_at'=>null,'expires_at'=>null,'applications'=>0],
        ];
    }

    public static function recruitmentPipeline(int $jobId): array
    {
        $all = [
            ['id'=>101,'name'=>'Paolo Garcia','email'=>'p.garcia@mail.com','stage'=>'applied','applied_at'=>'2026-10-14'],
            ['id'=>102,'name'=>'Rina Torres','email'=>'r.torres@mail.com','stage'=>'applied','applied_at'=>'2026-10-13'],
            ['id'=>103,'name'=>'Danilo Reyes','email'=>'d.reyes@mail.com','stage'=>'screening','applied_at'=>'2026-10-12'],
            ['id'=>104,'name'=>'Grace Lim','email'=>'g.lim@mail.com','stage'=>'qualified','applied_at'=>'2026-10-11'],
            ['id'=>105,'name'=>'Marco Santos','email'=>'m.santos@mail.com','stage'=>'for_interview','applied_at'=>'2026-10-10'],
            ['id'=>106,'name'=>'Erika Cruz','email'=>'e.cruz@mail.com','stage'=>'interviewed','applied_at'=>'2026-10-09'],
            ['id'=>107,'name'=>'Ben Aquino','email'=>'b.aquino@mail.com','stage'=>'offered','applied_at'=>'2026-10-08'],
        ];
        $out = [];
        foreach (['applied','screening','qualified','for_interview','interviewed','offered'] as $s) {
            $out[$s] = array_values(array_filter($all, fn($a) => $a['stage'] === $s));
        }
        return $out;
    }

    public static function timekeepingToday(): array
    {
        return [
            'date' => date('Y-m-d'),
            'expected' => 7, 'present' => 5, 'absent' => 2, 'late' => 1,
            'missing_punches' => 1,
            'devices' => [
                ['name'=>'Main Entrance','status'=>'online','last_sync'=>'2 minutes ago'],
                ['name'=>'Branch Office','status'=>'online','last_sync'=>'5 minutes ago'],
            ],
            'attendance' => [
                ['employee_no'=>'EMP-2026-0001','name'=>'Maria Santos','time_in'=>'07:58','time_out'=>null,'status'=>'present','late_min'=>0],
                ['employee_no'=>'EMP-2026-0002','name'=>'Juan Dela Cruz','time_in'=>'08:02','time_out'=>null,'status'=>'present','late_min'=>2],
                ['employee_no'=>'EMP-2026-0003','name'=>'Ana Reyes','time_in'=>'07:55','time_out'=>null,'status'=>'present','late_min'=>0],
                ['employee_no'=>'EMP-2026-0004','name'=>'Carlos Mendoza','time_in'=>'08:15','time_out'=>null,'status'=>'late','late_min'=>15],
                ['employee_no'=>'EMP-2026-0005','name'=>'Sofia Lim','time_in'=>'08:00','time_out'=>null,'status'=>'present','late_min'=>0],
                ['employee_no'=>'EMP-2026-0006','name'=>'Miguel Tan','time_in'=>null,'time_out'=>null,'status'=>'absent','late_min'=>0],
                ['employee_no'=>'EMP-2026-0008','name'=>'Robert Go Jr.','time_in'=>'08:05','time_out'=>null,'status'=>'present','late_min'=>5],
            ],
        ];
    }

    public static function dtrSummary(int $employeeId, string $month): array
    {
        $rows = [];
        $start = new \DateTime($month . '-01');
        $end = (clone $start)->modify('last day of this month');
        $i = 0;
        for ($d = clone $start; $d <= $end; $d->modify('+1 day')) {
            if (in_array((int)$d->format('N'), [6,7], true)) continue;
            $i++;
            $status = $i === 5 ? 'late' : 'present';
            $rows[] = [
                'date' => $d->format('Y-m-d'), 'day' => $d->format('D'),
                'time_in' => '08:0' . ($i % 3), 'time_out' => '17:' . str_pad((string)($i % 10), 2, '0', STR_PAD_LEFT),
                'hours' => 9.0, 'late_min' => $i === 5 ? 12 : 0,
                'ot_hours' => $i === 8 ? 1.5 : 0, 'status' => $status,
            ];
        }
        return [
            'employee' => ['id'=>$employeeId,'name'=>'Maria Santos','employee_no'=>'EMP-2026-0001'],
            'month' => $month, 'rows' => $rows,
            'totals' => ['days_present'=>count($rows),'total_hours'=>count($rows)*9.0,'total_late_min'=>12,'total_ot_hours'=>1.5],
        ];
    }

    public static function attendanceDevices(): array
    {
        return [
            ['id'=>1,'name'=>'Main Entrance','manufacturer'=>'ZKTeco','model'=>'K40','location'=>'HQ Lobby','ip'=>'192.168.1.51','method'=>'TCP/IP','status'=>'enabled','last_sync'=>'2026-10-20 08:30','imported'=>142,'rejected'=>0],
            ['id'=>2,'name'=>'Branch Office','manufacturer'=>'ZKTeco','model'=>'F18','location'=>'Makati Branch','ip'=>'192.168.1.52','method'=>'TCP/IP','status'=>'enabled','last_sync'=>'2026-10-20 08:25','imported'=>68,'rejected'=>2],
            ['id'=>3,'name'=>'Warehouse','manufacturer'=>'Suprema','model'=>'BioStation 2','location'=>'Valenzuela','ip'=>'192.168.1.53','method'=>'CSV Import','status'=>'enabled','last_sync'=>'2026-10-19 17:00','imported'=>35,'rejected'=>0],
        ];
    }

    public static function leaveTypes(): array
    {
        return [
            ['code'=>'VL','name'=>'Vacation Leave','days'=>15,'paid'=>true,'carryover'=>true],
            ['code'=>'SL','name'=>'Sick Leave','days'=>15,'paid'=>true,'carryover'=>false],
            ['code'=>'EL','name'=>'Emergency Leave','days'=>5,'paid'=>true,'carryover'=>false],
            ['code'=>'ML','name'=>'Maternity Leave','days'=>105,'paid'=>true,'carryover'=>false],
            ['code'=>'PL','name'=>'Paternity Leave','days'=>7,'paid'=>true,'carryover'=>false],
            ['code'=>'SPL','name'=>'Solo Parent Leave','days'=>7,'paid'=>true,'carryover'=>false],
            ['code'=>'BL','name'=>'Bereavement Leave','days'=>3,'paid'=>true,'carryover'=>false],
        ];
    }

    public static function leaveBalances(): array
    {
        return [
            ['name'=>'Maria Santos','employee_no'=>'EMP-2026-0001','vl'=>12,'sl'=>15,'el'=>5],
            ['name'=>'Juan Dela Cruz','employee_no'=>'EMP-2026-0002','vl'=>5,'sl'=>15,'el'=>5],
            ['name'=>'Ana Reyes','employee_no'=>'EMP-2026-0003','vl'=>8,'sl'=>13,'el'=>5],
            ['name'=>'Carlos Mendoza','employee_no'=>'EMP-2026-0004','vl'=>15,'sl'=>15,'el'=>5],
            ['name'=>'Sofia Lim','employee_no'=>'EMP-2026-0005','vl'=>5,'sl'=>15,'el'=>5],
        ];
    }

    public static function leaveRequests(): array
    {
        return [
            ['id'=>1,'name'=>'Juan Dela Cruz','employee_no'=>'EMP-2026-0002','type'=>'Vacation Leave','from'=>'2026-10-25','to'=>'2026-10-26','days'=>2,'status'=>'pending','reason'=>'Family trip'],
            ['id'=>2,'name'=>'Sofia Lim','employee_no'=>'EMP-2026-0005','type'=>'Sick Leave','from'=>'2026-10-22','to'=>'2026-10-22','days'=>1,'status'=>'pending','reason'=>'Medical checkup'],
            ['id'=>3,'name'=>'Carlos Mendoza','employee_no'=>'EMP-2026-0004','type'=>'Vacation Leave','from'=>'2026-10-28','to'=>'2026-10-30','days'=>3,'status'=>'approved','reason'=>'Personal'],
            ['id'=>4,'name'=>'Miguel Tan','employee_no'=>'EMP-2026-0006','type'=>'Emergency Leave','from'=>'2026-10-10','to'=>'2026-10-11','days'=>2,'status'=>'approved','reason'=>'Family emergency'],
            ['id'=>5,'name'=>'Maria Santos','employee_no'=>'EMP-2026-0001','type'=>'Vacation Leave','from'=>'2026-09-15','to'=>'2026-09-15','days'=>1,'status'=>'rejected','reason'=>'Personal'],
        ];
    }

    public static function overtimeRequests(): array
    {
        return [
            ['id'=>1,'name'=>'Maria Santos','employee_no'=>'EMP-2026-0001','date'=>'2026-10-19','hours'=>2.0,'reason'=>'Sprint deploy','status'=>'pending'],
            ['id'=>2,'name'=>'Juan Dela Cruz','employee_no'=>'EMP-2026-0002','date'=>'2026-10-18','hours'=>1.5,'reason'=>'Bug fix','status'=>'approved'],
            ['id'=>3,'name'=>'Carlos Mendoza','employee_no'=>'EMP-2026-0004','date'=>'2026-10-17','hours'=>3.0,'reason'=>'Payroll close','status'=>'approved'],
        ];
    }

    public static function payrollPeriods(): array
    {
        return [
            ['id'=>4,'name'=>'Oct 16–31, 2026','pay_date'=>'2026-11-05','status'=>'open','employees'=>8,'gross'=>0,'net'=>0],
            ['id'=>3,'name'=>'Oct 1–15, 2026','pay_date'=>'2026-10-20','status'=>'paid','employees'=>8,'gross'=>312450,'net'=>273827.50],
            ['id'=>2,'name'=>'Sep 16–30, 2026','pay_date'=>'2026-10-05','status'=>'paid','employees'=>8,'gross'=>312450,'net'=>273900],
            ['id'=>1,'name'=>'Sep 1–15, 2026','pay_date'=>'2026-09-20','status'=>'paid','employees'=>7,'gross'=>287000,'net'=>242118],
        ];
    }

    public static function payrollRunDetail(int $periodId): array
    {
        return [
            'period' => ['id'=>$periodId,'name'=>'Oct 1–15, 2026','pay_date'=>'2026-10-20','status'=>'paid'],
            'totals' => ['gross'=>312450,'total_deductions'=>38622.50,'net'=>273827.50,
                'sss_employee'=>11975,'philhealth_employee'=>4687.50,'pagibig_employee'=>1200,'tax'=>15962.50,
                'sss_employer'=>26275,'philhealth_employer'=>9375,'pagibig_employer'=>1200,'total_employer'=>36850],
            'employees' => [
                ['employee_no'=>'EMP-2026-0001','name'=>'Maria Santos','basic'=>17500,'allowance'=>1500,'ot'=>0,'gross'=>19000,'sss'=>787.50,'phil'=>356.25,'pagibig'=>50,'tax'=>1368.75,'other'=>0,'net'=>16437.50],
                ['employee_no'=>'EMP-2026-0002','name'=>'Juan Dela Cruz','basic'=>14000,'allowance'=>1000,'ot'=>375,'gross'=>15375,'sss'=>625,'phil'=>281.25,'pagibig'=>50,'tax'=>609.38,'other'=>0,'net'=>13809.37],
                ['employee_no'=>'EMP-2026-0003','name'=>'Ana Reyes','basic'=>16000,'allowance'=>1250,'ot'=>0,'gross'=>17250,'sss'=>725,'phil'=>318.75,'pagibig'=>50,'tax'=>1050,'other'=>0,'net'=>15106.25],
                ['employee_no'=>'EMP-2026-0004','name'=>'Carlos Mendoza','basic'=>12500,'allowance'=>750,'ot'=>140.63,'gross'=>13390.63,'sss'=>525,'phil'=>243.75,'pagibig'=>50,'tax'=>468.75,'other'=>1000,'net'=>11103.13],
                ['employee_no'=>'EMP-2026-0005','name'=>'Sofia Lim','basic'=>13000,'allowance'=>1000,'ot'=>0,'gross'=>14000,'sss'=>550,'phil'=>262.50,'pagibig'=>50,'tax'=>375,'other'=>0,'net'=>12762.50],
                ['employee_no'=>'EMP-2026-0006','name'=>'Miguel Tan','basic'=>12000,'allowance'=>2500,'ot'=>0,'gross'=>14500,'sss'=>500,'phil'=>243.75,'pagibig'=>50,'tax'=>818.75,'other'=>0,'net'=>12887.50],
                ['employee_no'=>'EMP-2026-0007','name'=>'Jessica Cruz','basic'=>13500,'allowance'=>1000,'ot'=>0,'gross'=>14500,'sss'=>575,'phil'=>262.50,'pagibig'=>50,'tax'=>593.75,'other'=>0,'net'=>13018.75],
                ['employee_no'=>'EMP-2026-0008','name'=>'Robert Go Jr.','basic'=>12500,'allowance'=>750,'ot'=>0,'gross'=>13250,'sss'=>525,'phil'=>243.75,'pagibig'=>50,'tax'=>450,'other'=>1398.75,'net'=>10582.50],
            ],
        ];
    }

    public static function payslip(int $employeeId, int $periodId): array
    {
        return [
            'employee' => ['employee_no'=>'EMP-2026-0001','name'=>'Maria Santos','department'=>'Engineering','position'=>'Engineering Manager'],
            'period' => ['name'=>'Oct 1–15, 2026','pay_date'=>'2026-10-20','reference'=>'PAY-2026-10-0003'],
            'earnings' => [
                ['label'=>'Basic Salary','amount'=>17500],
                ['label'=>'Allowances','amount'=>1500],
                ['label'=>'Overtime','amount'=>0],
            ],
            'deductions' => [
                ['label'=>'SSS Contribution','amount'=>787.50],
                ['label'=>'PhilHealth','amount'=>356.25],
                ['label'=>'Pag-IBIG','amount'=>50],
                ['label'=>'Withholding Tax','amount'=>1368.75],
            ],
            'gross' => 19000, 'total_deductions' => 2562.50, 'net' => 16437.50,
        ];
    }

    public static function contributionRuleSets(): array
    {
        return [
            ['agency'=>'SSS','effective_from'=>'2025-01-01','source'=>'SSS Circular 2024-001','verified'=>true],
            ['agency'=>'PhilHealth','effective_from'=>'2024-01-01','source'=>'PhilHealth Circular 2023-002','verified'=>true],
            ['agency'=>'Pag-IBIG','effective_from'=>'2024-02-01','source'=>'HDMF Circular 460','verified'=>true],
            ['agency'=>'BIR Withholding Tax','effective_from'=>'2023-01-01','source'=>'RR 2-2023','verified'=>false],
        ];
    }

    public static function loans(): array
    {
        return [
            ['id'=>1,'employee_no'=>'EMP-2026-0004','name'=>'Carlos Mendoza','type'=>'Cash Advance','principal'=>20000,'paid'=>10000,'balance'=>10000,'monthly'=>2000,'start'=>'2026-07-01','status'=>'active'],
            ['id'=>2,'employee_no'=>'EMP-2026-0007','name'=>'Jessica Cruz','type'=>'SSS Salary Loan','principal'=>15000,'paid'=>7500,'balance'=>7500,'monthly'=>1250,'start'=>'2026-04-01','status'=>'active'],
            ['id'=>3,'employee_no'=>'EMP-2026-0006','name'=>'Miguel Tan','type'=>'Emergency Loan','principal'=>10000,'paid'=>10000,'balance'=>0,'monthly'=>1000,'start'=>'2026-01-01','status'=>'completed'],
        ];
    }

    public static function benefits(): array
    {
        return [
            ['id'=>1,'name'=>'Health Insurance (HMO)','provider'=>'Maxicare','coverage'=>'Employee + 2 dependents','cost'=>25000,'frequency'=>'annual','status'=>'active'],
            ['id'=>2,'name'=>'Life Insurance','provider'=>'Sun Life','coverage'=>'3x annual salary','cost'=>12000,'frequency'=>'annual','status'=>'active'],
            ['id'=>3,'name'=>'Rice Allowance','provider'=>'Internal','coverage'=>'PHP 1,500/month','cost'=>18000,'frequency'=>'annual','status'=>'active'],
            ['id'=>4,'name'=>'Transportation Allowance','provider'=>'Internal','coverage'=>'PHP 2,000/month','cost'=>24000,'frequency'=>'annual','status'=>'active'],
        ];
    }

    public static function assets(): array
    {
        return [
            ['id'=>1,'asset_id'=>'AST-0001','description'=>'MacBook Pro 14"','serial'=>'MBP14-2024-0001','assigned_to'=>'Maria Santos','condition'=>'good','assigned_at'=>'2024-03-15','status'=>'assigned'],
            ['id'=>2,'asset_id'=>'AST-0002','description'=>'Dell Latitude 5430','serial'=>'DL5430-2024-0002','assigned_to'=>'Juan Dela Cruz','condition'=>'good','assigned_at'=>'2026-08-01','status'=>'assigned'],
            ['id'=>3,'asset_id'=>'AST-0003','description'=>'iPhone 14 Pro','serial'=>'IP14-2024-0003','assigned_to'=>'Miguel Tan','condition'=>'good','assigned_at'=>'2024-05-12','status'=>'assigned'],
            ['id'=>4,'asset_id'=>'AST-0004','description'=>'Office Chair','serial'=>'CHAIR-2024-0004','assigned_to'=>'Ana Reyes','condition'=>'good','assigned_at'=>'2024-02-01','status'=>'assigned'],
            ['id'=>5,'asset_id'=>'AST-0005','description'=>'Laptop Bag','serial'=>'BAG-2026-0005','assigned_to'=>null,'condition'=>'new','assigned_at'=>null,'status'=>'available'],
        ];
    }

    public static function performanceReviews(): array
    {
        return [
            ['id'=>1,'employee_no'=>'EMP-2026-0001','name'=>'Maria Santos','period'=>'H1 2026','rating'=>4.5,'reviewer'=>'Ana Reyes','status'=>'completed','date'=>'2026-07-15'],
            ['id'=>2,'employee_no'=>'EMP-2026-0002','name'=>'Juan Dela Cruz','period'=>'Probation Review','rating'=>4.0,'reviewer'=>'Maria Santos','status'=>'in_progress','date'=>'2026-10-20'],
            ['id'=>3,'employee_no'=>'EMP-2026-0005','name'=>'Sofia Lim','period'=>'Probation Review','rating'=>null,'reviewer'=>'Ana Reyes','status'=>'pending','date'=>'2026-10-25'],
        ];
    }

    public static function trainingRecords(): array
    {
        return [
            ['id'=>1,'employee_no'=>'EMP-2026-0001','name'=>'Maria Santos','course'=>'Leadership Essentials','provider'=>'ATD','date'=>'2026-03-15','score'=>92,'status'=>'completed'],
            ['id'=>2,'employee_no'=>'EMP-2026-0003','name'=>'Ana Reyes','course'=>'HR Analytics','provider'=>'Coursera','date'=>'2026-05-20','score'=>88,'status'=>'completed'],
            ['id'=>3,'employee_no'=>'EMP-2026-0004','name'=>'Carlos Mendoza','course'=>'Payroll Compliance','provider'=>'BIR','date'=>'2026-09-10','score'=>95,'status'=>'completed'],
            ['id'=>4,'employee_no'=>'EMP-2026-0008','name'=>'Robert Go Jr.','course'=>'New Hire Orientation','provider'=>'Internal','date'=>'2026-10-16','score'=>null,'status'=>'in_progress'],
        ];
    }

    public static function announcements(): array
    {
        return [
            ['id'=>1,'title'=>'Q4 2026 Company Townhall','body'=>'Join us on Oct 30 at 3PM in the main auditorium.','author'=>'Ana Reyes','published_at'=>'2026-10-19','priority'=>'high'],
            ['id'=>2,'title'=>'System Maintenance — Oct 27','body'=>'MyHR will be unavailable from 10PM–12MN.','author'=>'Super Admin','published_at'=>'2026-10-18','priority'=>'normal'],
            ['id'=>3,'title'=>'New Health Insurance Provider','body'=>'Effective Nov 1, our HMO is now Maxicare.','author'=>'Ana Reyes','published_at'=>'2026-10-15','priority'=>'normal'],
        ];
    }

    public static function companySettings(): array
    {
        return [
            'company_name'=>'Natkram-Systems Inc.',
            'company_address'=>'123 Ayala Ave, Makati City',
            'company_phone'=>'+63 2 8888 0000',
            'company_email'=>'info@natkram.local',
            'payroll_frequency'=>'semi_monthly',
            'payroll_cutoff_1'=>15, 'payroll_cutoff_2'=>31,
            'attendance_grace_minutes'=>5, 'standard_work_hours'=>8,
        ];
    }

    public static function auditLogs(int $limit = 20): array
    {
        return [
            ['id'=>1,'action'=>'auth.login','module'=>'auth','user'=>'Ana Reyes','record'=>null,'status'=>'success','created_at'=>'2026-10-20 08:00'],
            ['id'=>2,'action'=>'employee.status_changed','module'=>'employees','user'=>'Ana Reyes','record'=>8,'status'=>'success','created_at'=>'2026-10-20 08:05'],
            ['id'=>3,'action'=>'leave.approved','module'=>'leave','user'=>'Ana Reyes','record'=>4,'status'=>'success','created_at'=>'2026-10-20 09:15'],
            ['id'=>4,'action'=>'payroll.finalized','module'=>'payroll','user'=>'Carlos Mendoza','record'=>3,'status'=>'success','created_at'=>'2026-10-20 10:00'],
            ['id'=>5,'action'=>'auth.login_failed','module'=>'auth','user'=>'unknown','record'=>null,'status'=>'failure','created_at'=>'2026-10-20 10:30'],
        ];
    }
}