SET NAMES utf8mb4;
SET time_zone = '+08:00';

-- ═══════════════════════════════════════════════════════════════════
-- DEPARTMENTS (no head yet — filled after employees exist)
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO departments (id, organization_id, code, name) VALUES
  (1, 1, 'ENG', 'Engineering'),
  (2, 1, 'HR',  'Human Resources'),
  (3, 1, 'FIN', 'Finance'),
  (4, 1, 'SAL', 'Sales'),
  (5, 1, 'OPS', 'Operations'),
  (6, 1, 'MKT', 'Marketing');

-- ═══════════════════════════════════════════════════════════════════
-- POSITIONS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO positions (id, organization_id, department_id, code, title) VALUES
  (1, 1, 1, 'ENG-MGR',  'Engineering Manager'),
  (2, 1, 1, 'ENG-SR',   'Senior Developer'),
  (3, 1, 1, 'ENG-JR',   'Junior Developer'),
  (4, 1, 2, 'HR-OFF',   'HR Officer'),
  (5, 1, 2, 'HR-PAY',   'Payroll Specialist'),
  (6, 1, 4, 'SAL-EXE',  'Sales Executive'),
  (7, 1, 5, 'OPS-SUP',  'Operations Supervisor'),
  (8, 1, 6, 'MKT-LEAD', 'Marketing Lead');

-- ═══════════════════════════════════════════════════════════════════
-- EMPLOYEES
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO employees (id, organization_id, user_id, employee_no, first_name, last_name, suffix,
                       department_id, position_id, reporting_manager_id, employment_status, employment_type,
                       date_hired, contact_email) VALUES
  (1, 1, NULL, 'EMP-2026-0001', 'Maria',  'Santos',     NULL,  1, 1, NULL, 'regular',       'regular',       '2022-03-15', 'maria.santos@natkram.local'),
  (2, 1, NULL, 'EMP-2026-0002', 'Juan',   'Dela Cruz',  NULL,  1, 2, 1,    'probationary',  'probationary',  '2026-08-01', 'juan.delacruz@natkram.local'),
  (3, 1, 2,    'EMP-2026-0003', 'Ana',    'Reyes',      NULL,  2, 4, NULL, 'regular',       'regular',       '2021-07-12', 'ana.reyes@natkram.local'),
  (4, 1, NULL, 'EMP-2026-0004', 'Carlos', 'Mendoza',    NULL,  2, 5, 3,    'regular',       'regular',       '2023-01-09', 'carlos.mendoza@natkram.local'),
  (5, 1, NULL, 'EMP-2026-0005', 'Sofia',  'Lim',        NULL,  6, 8, NULL, 'probationary',  'probationary',  '2026-06-15', 'sofia.lim@natkram.local'),
  (6, 1, NULL, 'EMP-2026-0006', 'Miguel', 'Tan',        NULL,  4, 6, NULL, 'regular',       'regular',       '2020-11-04', 'miguel.tan@natkram.local'),
  (7, 1, NULL, 'EMP-2026-0007', 'Jessica','Cruz',       NULL,  3, 5, NULL, 'regular',       'regular',       '2022-09-20', 'jessica.cruz@natkram.local'),
  (8, 1, NULL, 'EMP-2026-0008', 'Robert', 'Go',         'Jr.', 5, 7, NULL, 'probationary',  'probationary',  '2026-10-15', 'robert.go@natkram.local');

UPDATE departments SET head_employee_id = 1 WHERE id = 1;
UPDATE departments SET head_employee_id = 3 WHERE id = 2;
UPDATE departments SET head_employee_id = 7 WHERE id = 3;
UPDATE departments SET head_employee_id = 6 WHERE id = 4;
UPDATE departments SET head_employee_id = 8 WHERE id = 5;
UPDATE departments SET head_employee_id = 5 WHERE id = 6;

-- ═══════════════════════════════════════════════════════════════════
-- EMPLOYEE IDENTIFIERS (masked; ciphertext is placeholder for demo)
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO employee_identifiers (employee_id, id_type, ciphertext, last4) VALUES
  (1, 'sss',        'demo', '4521'),
  (1, 'philhealth', 'demo', '8830'),
  (1, 'pagibig',    'demo', '1192'),
  (1, 'tin',        'demo', '7745'),
  (1, 'bank_account','demo','3301'),
  (2, 'sss',        'demo', '7703'),
  (2, 'philhealth', 'demo', '4428'),
  (2, 'pagibig',    'demo', '5561'),
  (2, 'tin',        'demo', '2219'),
  (2, 'bank_account','demo','8824');

-- ═══════════════════════════════════════════════════════════════════
-- EMPLOYMENT HISTORY
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO employee_employment_history (employee_id, event_type, from_value, to_value, effective_date, recorded_by, notes) VALUES
  (1, 'hired',       NULL,           'Probationary',       '2022-03-15', NULL, 'Initial hire'),
  (1, 'regularized', 'Probationary', 'Regular',            '2022-09-15', 2,    'Passed probation'),
  (1, 'promoted',    'Senior Developer', 'Engineering Manager', '2024-01-01', 2, 'Team growth'),
  (8, 'hired',       'Applicant',    'Probationary',       '2026-10-15', 2,    'Offer accepted');

-- ═══════════════════════════════════════════════════════════════════
-- ONBOARDING (only for employee 8 — Robert)
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO onboarding_records (id, organization_id, employee_id, start_date, status) VALUES
  (1, 1, 8, '2026-10-15', 'in_progress');

INSERT INTO onboarding_tasks (onboarding_record_id, template_id, name, is_mandatory, assigned_user_id, due_date, status, remarks) VALUES
  (1, 1, 'Employment Contract',               1, 2, '2026-10-15', 'completed',   'Signed 10/15'),
  (1, 2, 'Employee Information Form',         1, 2, '2026-10-16', 'completed',   'Complete'),
  (1, 3, 'Government IDs',                    1, 2, '2026-10-20', 'in_progress', 'SSS & TIN submitted, PhilHealth pending'),
  (1, 4, 'Bank Account Details',              1, 2, '2026-10-20', 'pending',     NULL),
  (1, 5, 'Company Policies Acknowledgment',   1, 2, '2026-10-18', 'pending',     NULL),
  (1, 6, 'IT Account Creation',               1, 1, '2026-10-15', 'completed',   'Email active'),
  (1, 7, 'Asset Assignment',                  1, 2, '2026-10-16', 'pending',     'Laptop scheduled Friday'),
  (1, 8, 'Department Orientation',            0, 2, '2026-10-18', 'pending',     NULL);

-- ═══════════════════════════════════════════════════════════════════
-- JOB POSTINGS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO job_postings (id, organization_id, department_id, position_id, reference_no, title, slug,
                          employment_type, description, status, published_at, expires_at, created_by) VALUES
  (1, 1, 1, 3, 'JOB-2026-A1B2C3', 'Junior Developer',      'junior-developer',      'regular',      'Junior PHP developer with 1-2 years experience.',        'published', '2026-10-10 09:00', '2026-12-31 23:59', 2),
  (2, 1, 4, 6, 'JOB-2026-D4E5F6', 'Sales Executive',       'sales-executive',       'regular',      'Sales executive for B2B corporate accounts.',            'published', '2026-10-08 09:00', '2026-12-01 23:59', 2),
  (3, 1, 2, 4, 'JOB-2026-G7H8I9', 'HR Assistant',          'hr-assistant',          'probationary', 'HR assistant for recruitment and onboarding support.',   'published', '2026-10-12 09:00', '2026-11-30 23:59', 2),
  (4, 1, 6, 8, 'JOB-2026-J1K2L3', 'Marketing Coordinator',  'marketing-coordinator', 'regular',      'Marketing coordinator for digital campaigns.',           'published', '2026-10-05 09:00', '2026-11-15 23:59', 2),
  (5, 1, 3, 5, 'JOB-2026-M4N5O6', 'Finance Analyst',       'finance-analyst',       'regular',      'Finance analyst for reporting and analysis.',           'draft',     NULL,                NULL,               2);

-- ═══════════════════════════════════════════════════════════════════
-- APPLICANTS + APPLICATIONS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO applicants (id, organization_id, email, password_hash, first_name, last_name) VALUES
  (1, 1, 'p.garcia@mail.com',  'demo', 'Paolo',   'Garcia'),
  (2, 1, 'r.torres@mail.com',  'demo', 'Rina',    'Torres'),
  (3, 1, 'd.reyes@mail.com',   'demo', 'Danilo',  'Reyes'),
  (4, 1, 'g.lim@mail.com',     'demo', 'Grace',   'Lim'),
  (5, 1, 'm.santos@mail.com',  'demo', 'Marco',   'Santos'),
  (6, 1, 'e.cruz@mail.com',    'demo', 'Erika',   'Cruz'),
  (7, 1, 'b.aquino@mail.com',  'demo', 'Ben',     'Aquino');

-- stage IDs from base seed: applied=1, screening=2, qualified=3, for_interview=4, interviewed=5, offered=9
INSERT INTO applications (id, organization_id, job_posting_id, applicant_id, stage_id, status, applied_at) VALUES
  (1, 1, 1, 1, 1, 'active', '2026-10-14 10:00'),
  (2, 1, 1, 2, 1, 'active', '2026-10-13 10:00'),
  (3, 1, 1, 3, 2, 'active', '2026-10-12 10:00'),
  (4, 1, 1, 4, 3, 'active', '2026-10-11 10:00'),
  (5, 1, 1, 5, 4, 'active', '2026-10-10 10:00'),
  (6, 1, 1, 6, 5, 'active', '2026-10-09 10:00'),
  (7, 1, 1, 7, 9, 'active', '2026-10-08 10:00');

INSERT INTO application_stage_history (application_id, from_stage_id, to_stage_id, moved_by, notes) VALUES
  (1, NULL, 1, NULL, 'Application submitted'),
  (2, NULL, 1, NULL, 'Application submitted'),
  (3, NULL, 1, NULL, 'Application submitted'),
  (3, 1, 2, 2, NULL),
  (4, NULL, 1, NULL, 'Application submitted'),
  (4, 1, 3, 2, NULL),
  (5, NULL, 1, NULL, 'Application submitted'),
  (5, 3, 4, 2, NULL),
  (6, NULL, 1, NULL, 'Application submitted'),
  (6, 4, 5, 2, NULL),
  (7, NULL, 1, NULL, 'Application submitted'),
  (7, 5, 9, 2, 'Offer extended');

-- ═══════════════════════════════════════════════════════════════════
-- ATTENDANCE DEVICES
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO attendance_devices (id, organization_id, name, manufacturer, model, location, ip_address,
                                connection_method, status, last_sync_at, last_result, last_imported, last_rejected) VALUES
  (1, 1, 'Main Entrance',  'ZKTeco',  'K40',           'HQ Lobby',        '192.168.1.51', 'tcpip', 'enabled', '2026-10-20 08:30', 'OK', 142, 0),
  (2, 1, 'Branch Office',  'ZKTeco',  'F18',           'Makati Branch',   '192.168.1.52', 'tcpip', 'enabled', '2026-10-20 08:25', 'OK', 68,  2),
  (3, 1, 'Warehouse',      'Suprema', 'BioStation 2',  'Valenzuela',      '192.168.1.53', 'csv',   'enabled', '2026-10-19 17:00', 'OK', 35,  0);

-- ═══════════════════════════════════════════════════════════════════
-- DTR SUMMARIES (today + past workdays for employee 1)
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO dtr_summaries (organization_id, employee_id, summary_date, time_in_am, time_out_pm, hours_worked, late_minutes, overtime_hours, is_absent, approval_status) VALUES
  (1, 1, CURDATE(), '07:58', NULL, 0, 0,  0,   0, 'pending'),
  (1, 2, CURDATE(), '08:02', NULL, 0, 2,  0,   0, 'pending'),
  (1, 3, CURDATE(), '07:55', NULL, 0, 0,  0,   0, 'pending'),
  (1, 4, CURDATE(), '08:15', NULL, 0, 15, 0,   0, 'pending'),
  (1, 5, CURDATE(), '08:00', NULL, 0, 0,  0,   0, 'pending'),
  (1, 6, CURDATE(), NULL,    NULL, 0, 0,  0,   1, 'pending'),
  (1, 8, CURDATE(), '08:05', NULL, 0, 5,  0,   0, 'pending');

-- Historical rows for Maria Santos (employee 1) — last 15 workdays
INSERT INTO dtr_summaries (organization_id, employee_id, summary_date, time_in_am, time_out_pm, hours_worked, late_minutes, overtime_hours, is_absent, approval_status)
SELECT 1, 1, workday, '08:00', '17:00', 9.0, 0, IF(MOD(DAY(workday), 5) = 0, 1.5, 0), 0, 'approved'
FROM (
  SELECT DATE_SUB(CURDATE(), INTERVAL n DAY) AS workday
  FROM (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5
        UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10
        UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13 UNION ALL SELECT 14 UNION ALL SELECT 15
        UNION ALL SELECT 16 UNION ALL SELECT 17 UNION ALL SELECT 18 UNION ALL SELECT 19 UNION ALL SELECT 20) nums
) d
WHERE DAYOFWEEK(workday) BETWEEN 2 AND 6;

-- One late day for Maria
UPDATE dtr_summaries
   SET late_minutes = 12, approval_status = 'pending'
 WHERE employee_id = 1 AND summary_date = DATE_SUB(CURDATE(), INTERVAL 7 DAY);

-- ═══════════════════════════════════════════════════════════════════
-- LEAVE BALANCES + REQUESTS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO leave_balances (organization_id, employee_id, leave_type_id, year, entitlement, used, balance) VALUES
  (1, 1, 1, YEAR(CURDATE()), 15, 3, 12), (1, 1, 2, YEAR(CURDATE()), 15, 0, 15), (1, 1, 3, YEAR(CURDATE()), 5, 0, 5),
  (1, 2, 1, YEAR(CURDATE()), 15, 5, 5),  (1, 2, 2, YEAR(CURDATE()), 15, 0, 15), (1, 2, 3, YEAR(CURDATE()), 5, 0, 5),
  (1, 3, 1, YEAR(CURDATE()), 15, 7, 8),  (1, 3, 2, YEAR(CURDATE()), 15, 2, 13), (1, 3, 3, YEAR(CURDATE()), 5, 0, 5),
  (1, 4, 1, YEAR(CURDATE()), 15, 0, 15), (1, 4, 2, YEAR(CURDATE()), 15, 0, 15), (1, 4, 3, YEAR(CURDATE()), 5, 0, 5),
  (1, 5, 1, YEAR(CURDATE()), 15, 5, 5),  (1, 5, 2, YEAR(CURDATE()), 15, 0, 15), (1, 5, 3, YEAR(CURDATE()), 5, 0, 5);

INSERT INTO leave_requests (organization_id, employee_id, leave_type_id, request_no, date_from, date_to, days, reason, status, approved_by, approved_at) VALUES
  (1, 2, 1, 'LV-2026-0001', '2026-10-25', '2026-10-26', 2, 'Family trip',      'pending',  NULL, NULL),
  (1, 5, 2, 'LV-2026-0002', '2026-10-22', '2026-10-22', 1, 'Medical checkup',  'pending',  NULL, NULL),
  (1, 4, 1, 'LV-2026-0003', '2026-10-28', '2026-10-30', 3, 'Personal',         'approved', 2,    '2026-10-15 10:00:00'),
  (1, 6, 3, 'LV-2026-0004', '2026-10-10', '2026-10-11', 2, 'Family emergency', 'approved', 2,    '2026-10-09 09:00:00'),
  (1, 1, 1, 'LV-2026-0005', '2026-09-15', '2026-09-15', 1, 'Personal',         'rejected', 2,    '2026-09-10 11:00:00');

INSERT INTO overtime_requests (organization_id, employee_id, request_no, ot_date, hours, reason, status) VALUES
  (1, 1, 'OT-2026-0001', '2026-10-19', 2.0, 'Sprint deploy',  'pending'),
  (1, 2, 'OT-2026-0002', '2026-10-18', 1.5, 'Bug fix',        'approved'),
  (1, 4, 'OT-2026-0003', '2026-10-17', 3.0, 'Payroll close',  'approved');

-- ═══════════════════════════════════════════════════════════════════
-- PAYROLL PERIODS + RUN (only period 3 populated)
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO payroll_periods (id, organization_id, name, period_start, period_end, pay_date, frequency, status) VALUES
  (1, 1, 'Sep 1–15, 2026',  '2026-09-01', '2026-09-15', '2026-09-20', 'semi_monthly', 'paid'),
  (2, 1, 'Sep 16–30, 2026', '2026-09-16', '2026-09-30', '2026-10-05', 'semi_monthly', 'paid'),
  (3, 1, 'Oct 1–15, 2026',  '2026-10-01', '2026-10-15', '2026-10-20', 'semi_monthly', 'paid'),
  (4, 1, 'Oct 16–31, 2026', '2026-10-16', '2026-10-31', '2026-11-05', 'semi_monthly', 'open');

INSERT INTO payroll_runs (id, organization_id, payroll_period_id, reference_no, status,
                          employee_count, total_gross, total_employee_deductions, total_net,
                          total_employer_contributions, calculated_at, finalized_at, created_by) VALUES
  (3, 1, 3, 'PAY-2026-10-0003', 'paid', 8, 312450.00, 38622.50, 273827.50, 36850.00,
   '2026-10-16 10:00', '2026-10-17 09:00', 2);

-- payroll_run_employees (8 rows)
INSERT INTO payroll_run_employees (payroll_run_id, employee_id, basic_pay, allowances, overtime_pay, gross_pay, total_deductions, net_pay) VALUES
  (3, 1, 17500.00, 1500.00,    0.00, 19000.00, 2562.50, 16437.50),
  (3, 2, 14000.00, 1000.00,  375.00, 15375.00, 1565.63, 13809.37),
  (3, 3, 16000.00, 1250.00,    0.00, 17250.00, 2143.75, 15106.25),
  (3, 4, 12500.00,  750.00,  140.63, 13390.63, 2287.50, 11103.13),
  (3, 5, 13000.00, 1000.00,    0.00, 14000.00, 1237.50, 12762.50),
  (3, 6, 12000.00, 2500.00,    0.00, 14500.00, 1612.50, 12887.50),
  (3, 7, 13500.00, 1000.00,    0.00, 14500.00, 1481.25, 13018.75),
  (3, 8, 12500.00,  750.00,    0.00, 13250.00, 2667.50, 10582.50);

-- employee contributions (SSS, PhilHealth, Pag-IBIG, BIR per employee)
INSERT INTO payroll_employee_contributions (payroll_run_employee_id, agency, amount) VALUES
  (1,'sss',787.50),(1,'philhealth',356.25),(1,'pagibig',50.00),(1,'bir',1368.75),
  (2,'sss',625.00),(2,'philhealth',281.25),(2,'pagibig',50.00),(2,'bir',609.38),
  (3,'sss',725.00),(3,'philhealth',318.75),(3,'pagibig',50.00),(3,'bir',1050.00),
  (4,'sss',525.00),(4,'philhealth',243.75),(4,'pagibig',50.00),(4,'bir',468.75),
  (5,'sss',550.00),(5,'philhealth',262.50),(5,'pagibig',50.00),(5,'bir',375.00),
  (6,'sss',500.00),(6,'philhealth',243.75),(6,'pagibig',50.00),(6,'bir',818.75),
  (7,'sss',575.00),(7,'philhealth',262.50),(7,'pagibig',50.00),(7,'bir',593.75),
  (8,'sss',525.00),(8,'philhealth',243.75),(8,'pagibig',50.00),(8,'bir',450.00);

-- employer contributions
INSERT INTO payroll_employer_contributions (payroll_run_employee_id, agency, amount) VALUES
  (1,'sss',1587.50),(1,'philhealth',712.50),(1,'pagibig',100.00),
  (2,'sss',1250.00),(2,'philhealth',562.50),(2,'pagibig',100.00),
  (3,'sss',1450.00),(3,'philhealth',637.50),(3,'pagibig',100.00),
  (4,'sss',1050.00),(4,'philhealth',487.50),(4,'pagibig',100.00),
  (5,'sss',1100.00),(5,'philhealth',525.00),(5,'pagibig',100.00),
  (6,'sss',1000.00),(6,'philhealth',487.50),(6,'pagibig',100.00),
  (7,'sss',1150.00),(7,'philhealth',525.00),(7,'pagibig',100.00),
  (8,'sss',1050.00),(8,'philhealth',487.50),(8,'pagibig',100.00);

-- other deductions (loan repayments for Carlos)
INSERT INTO payroll_deductions (payroll_run_employee_id, deduction_type, description, amount) VALUES
  (4, 'cash_advance', 'Cash Advance Repayment', 1000.00),
  (8, 'emergency_loan', 'Emergency Loan Repayment', 1398.75);

-- payslips
INSERT INTO payslips (organization_id, payroll_run_id, payroll_run_employee_id, employee_id, reference_no) VALUES
  (1, 3, 1, 1, 'PAY-2026-10-0003-01'),
  (1, 3, 2, 2, 'PAY-2026-10-0003-02'),
  (1, 3, 3, 3, 'PAY-2026-10-0003-03'),
  (1, 3, 4, 4, 'PAY-2026-10-0003-04'),
  (1, 3, 5, 5, 'PAY-2026-10-0003-05'),
  (1, 3, 6, 6, 'PAY-2026-10-0003-06'),
  (1, 3, 7, 7, 'PAY-2026-10-0003-07'),
  (1, 3, 8, 8, 'PAY-2026-10-0003-08');

-- ═══════════════════════════════════════════════════════════════════
-- CONTRIBUTION RULE SETS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO contribution_rule_sets (organization_id, agency, effective_from, source_reference, verified, created_by) VALUES
  (1, 'sss',        '2025-01-01', 'SSS Circular 2024-001',       1, 1),
  (1, 'philhealth', '2024-01-01', 'PhilHealth Circular 2023-002',1, 1),
  (1, 'pagibig',    '2024-02-01', 'HDMF Circular 460',           1, 1),
  (1, 'bir',        '2023-01-01', 'RR 2-2023',                   0, 1);

-- ═══════════════════════════════════════════════════════════════════
-- LOANS / BENEFITS / ASSETS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO employee_loans (id, organization_id, employee_id, loan_type, principal, monthly_amortization, total_paid, balance, start_date, status) VALUES
  (1, 1, 4, 'cash_advance',   20000.00, 2000.00, 10000.00, 10000.00, '2026-07-01', 'active'),
  (2, 1, 7, 'sss_loan',       15000.00, 1250.00,  7500.00,  7500.00, '2026-04-01', 'active'),
  (3, 1, 6, 'emergency_loan', 10000.00, 1000.00, 10000.00,     0.00, '2026-01-01', 'paid');

INSERT INTO benefits (id, organization_id, code, name, provider, coverage, cost, frequency, status) VALUES
  (1, 1, 'HMO',     'Health Insurance (HMO)',   'Maxicare', 'Employee + 2 dependents', 25000.00, 'annual', 'active'),
  (2, 1, 'LIFE',    'Life Insurance',           'Sun Life', '3x annual salary',       12000.00, 'annual', 'active'),
  (3, 1, 'RICE',    'Rice Allowance',           'Internal', 'PHP 1,500/month',        18000.00, 'annual', 'active'),
  (4, 1, 'TRANS',   'Transportation Allowance', 'Internal', 'PHP 2,000/month',        24000.00, 'annual', 'active');

INSERT INTO assets (id, organization_id, asset_no, description, serial_number, condition_state, status) VALUES
  (1, 1, 'AST-0001', 'MacBook Pro 14"',    'MBP14-2024-0001', 'good', 'assigned'),
  (2, 1, 'AST-0002', 'Dell Latitude 5430', 'DL5430-2024-0002','good', 'assigned'),
  (3, 1, 'AST-0003', 'iPhone 14 Pro',      'IP14-2024-0003',  'good', 'assigned'),
  (4, 1, 'AST-0004', 'Office Chair',       'CHAIR-2024-0004', 'good', 'assigned'),
  (5, 1, 'AST-0005', 'Laptop Bag',         'BAG-2026-0005',   'new',  'available');

INSERT INTO asset_assignments (asset_id, employee_id, assigned_at, condition_out, status) VALUES
  (1, 1, '2024-03-15', 'good', 'active'),
  (2, 2, '2026-08-01', 'good', 'active'),
  (3, 6, '2024-05-12', 'good', 'active'),
  (4, 3, '2024-02-01', 'good', 'active');

-- ═══════════════════════════════════════════════════════════════════
-- PERFORMANCE / TRAINING / ANNOUNCEMENTS
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO performance_reviews (id, organization_id, employee_id, reviewer_id, period, overall_rating, status, scheduled_date, completed_at) VALUES
  (1, 1, 1, 2,    'H1 2026',          4.50, 'completed',   '2026-07-15', '2026-07-15 16:00'),
  (2, 1, 2, NULL, 'Probation Review', 4.00, 'in_progress', '2026-10-20', NULL),
  (3, 1, 5, 2,    'Probation Review', NULL, 'pending',     '2026-10-25', NULL);

INSERT INTO training_records (id, organization_id, employee_id, course, provider, training_date, score, status) VALUES
  (1, 1, 1, 'Leadership Essentials',  'ATD',       '2026-03-15', 92.00, 'completed'),
  (2, 1, 3, 'HR Analytics',           'Coursera',  '2026-05-20', 88.00, 'completed'),
  (3, 1, 4, 'Payroll Compliance',     'BIR',       '2026-09-10', 95.00, 'completed'),
  (4, 1, 8, 'New Hire Orientation',   'Internal',  '2026-10-16', NULL,  'in_progress');

INSERT INTO announcements (id, organization_id, title, body, priority, author_id, published_at, status) VALUES
  (1, 1, 'Q4 2026 Company Townhall',      'Join us on Oct 30 at 3PM in the main auditorium.',           'high',   2, '2026-10-19 09:00', 'published'),
  (2, 1, 'System Maintenance — Oct 27',   'MyHR will be unavailable from 10PM–12MN.',                   'normal', 1, '2026-10-18 09:00', 'published'),
  (3, 1, 'New Health Insurance Provider', 'Effective Nov 1, our HMO is now Maxicare.',                  'normal', 2, '2026-10-15 09:00', 'published');

-- ═══════════════════════════════════════════════════════════════════
-- AUDIT LOGS (5 sample entries)
-- ═══════════════════════════════════════════════════════════════════
INSERT INTO audit_logs (organization_id, user_id, action, module, record_id, status, created_at) VALUES
  (1, 2,    'auth.login',              'auth',      NULL, 'success', '2026-10-20 08:00:00'),
  (1, 2,    'employee.status_changed', 'employees', 8,    'success', '2026-10-20 08:05:00'),
  (1, 2,    'leave.approved',          'leave',     4,    'success', '2026-10-20 09:15:00'),
  (1, 2,    'payroll.finalized',       'payroll',   3,    'success', '2026-10-20 10:00:00'),
  (1, NULL, 'auth.login_failed',       'auth',      NULL, 'failure', '2026-10-20 10:30:00');