<?php
declare(strict_types=1);

use MyHR\Controllers\{AuthController, DemoController};

// Auth
$router->get('/',           [AuthController::class, 'showLogin']);
$router->get('/login',      [AuthController::class, 'showLogin']);
$router->post('/login',     [AuthController::class, 'login'], ['csrf']);
$router->post('/logout',    [AuthController::class, 'logout']);

// Dashboard
$router->get('/dashboard',  [DemoController::class, 'dashboard']);

// People
$router->get('/employees',                   [DemoController::class, 'employees']);
$router->get('/employees/{id}',              [DemoController::class, 'employee']);
$router->get('/employees/{id}/onboarding',   [DemoController::class, 'onboarding']);
$router->get('/employees/{id}/dtr',          [DemoController::class, 'dtr']);
$router->get('/departments',                 [DemoController::class, 'departments']);
$router->get('/positions',                   [DemoController::class, 'positions']);

// Recruitment
$router->get('/jobs',                        [DemoController::class, 'jobs']);
$router->get('/jobs/{id}/pipeline',          [DemoController::class, 'pipeline']);
$router->get('/applicant/{id}',              [DemoController::class, 'applicant']);

// Careers Portal
$router->get('/careers',                     [DemoController::class, 'careers']);
$router->get('/careers/{slug}',              [DemoController::class, 'careersShow']);
$router->get('/careers/status',              [DemoController::class, 'careersStatus']);

// Timekeeping
$router->get('/timekeeping',                 [DemoController::class, 'timekeeping']);
$router->get('/timekeeping/terminal',        [DemoController::class, 'terminal']);
$router->get('/timekeeping/devices',         [DemoController::class, 'devices']);

// Leave
$router->get('/leave',                       [DemoController::class, 'leave']);
$router->get('/leave/types',                 [DemoController::class, 'leaveTypes']);
$router->get('/overtime',                    [DemoController::class, 'overtime']);

// Payroll
$router->get('/payroll',                     [DemoController::class, 'payroll']);
$router->get('/payroll/{id}',                [DemoController::class, 'payrollRun']);
$router->get('/payroll/{pid}/payslip/{eid}', [DemoController::class, 'payslip']);

// Other
$router->get('/loans',                       [DemoController::class, 'loans']);
$router->get('/benefits',                    [DemoController::class, 'benefits']);
$router->get('/assets',                      [DemoController::class, 'assets']);
$router->get('/performance',                 [DemoController::class, 'performance']);
$router->get('/training',                    [DemoController::class, 'training']);
$router->get('/announcements',               [DemoController::class, 'announcements']);
$router->get('/reports',                     [DemoController::class, 'reports']);
$router->get('/audit',                       [DemoController::class, 'audit']);
$router->get('/settings',                    [DemoController::class, 'settings']);