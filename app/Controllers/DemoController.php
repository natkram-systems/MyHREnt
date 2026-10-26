<?php
declare(strict_types=1);
namespace MyHR\Controllers;

use MyHR\Core\{Request, View};
use MyHR\Support\DataFactory;

final class DemoController
{
    private function p() { return DataFactory::make(); }

    public function dashboard(Request $req): string
    {
        return View::render('dashboard/index', [
            'title' => 'Dashboard',
            'stats' => $this->p()->dashboardStats(),
            'recentHires' => $this->p()->recentHires(),
            'onboarding' => $this->p()->onboardingInProgress(),
        ]);
    }

    public function employees(Request $req): string
    {
        return View::render('employees/index', [
            'title' => 'Employees',
            'rows' => $this->p()->employees($req->str('q'), $req->str('status') ?: null),
            'q' => $req->str('q'), 'status' => $req->str('status'),
        ]);
    }

    public function employee(Request $req, array $p): string
    {
        $emp = $this->p()->employee((int) $p['id']);
        if (!$emp) { http_response_code(404); return View::render('errors/404', [], null); }
        return View::render('employees/show', [
            'title' => $emp['first_name'].' '.$emp['last_name'], 'emp' => $emp,
            'identifiers' => $this->p()->employeeIdentifiers((int) $emp['id']),
            'history' => $this->p()->employeeHistory((int) $emp['id']),
            'onboarding' => $this->p()->employeeOnboarding((int) $emp['id']),
        ]);
    }

    public function onboarding(Request $req, array $p): string
    {
        $emp = $this->p()->employee((int) $p['id']);
        $onb = $this->p()->employeeOnboarding((int) $p['id']);
        if (!$emp || !$onb) { http_response_code(404); return View::render('errors/404', [], null); }
        return View::render('onboarding/show', ['title' => 'Onboarding', 'emp' => $emp, 'onboarding' => $onb]);
    }

    public function departments(Request $req): string
    {
        return View::render('departments/index', ['title' => 'Departments', 'rows' => $this->p()->departments()]);
    }

    public function positions(Request $req): string
    {
        return View::render('positions/index', ['title' => 'Positions', 'rows' => $this->p()->positions()]);
    }

    public function jobs(Request $req): string
    {
        return View::render('jobs/index', ['title' => 'Job Postings', 'rows' => $this->p()->jobPostings()]);
    }

    public function pipeline(Request $req, array $p): string
    {
        $jobId = (int) ($p['id'] ?? 1);
        return View::render('jobs/pipeline', [
            'title' => 'Recruitment Pipeline',
            'pipeline' => $this->p()->recruitmentPipeline($jobId),
            'jobId' => $jobId,
        ]);
    }

    public function applicant(Request $req, array $p): string
    {
        return View::render('applicants/show', ['title' => 'Applicant']);
    }

    public function careers(Request $req): string
    {
        return View::render('careers/index', [
            'title' => 'Careers',
            'jobs' => array_filter($this->p()->jobPostings(), fn($j) => $j['status'] === 'published'),
            'q' => $req->str('q'),
        ], 'layouts/public');
    }

    public function careersShow(Request $req, array $p): string
    {
        return View::render('careers/show', ['title' => 'Job Detail'], 'layouts/public');
    }

    public function careersStatus(Request $req): string
    {
        return View::render('careers/status', ['title' => 'Application Status'], 'layouts/public');
    }

    public function timekeeping(Request $req): string
    {
        return View::render('timekeeping/dashboard', ['title' => 'Timekeeping', 'data' => $this->p()->timekeepingToday()]);
    }

    public function terminal(Request $req): string
    {
        return View::render('timekeeping/terminal', ['title' => 'DTR Terminal']);
    }

    public function dtr(Request $req, array $p): string
    {
        $month = $req->str('month') ?: date('Y-m');
        return View::render('timekeeping/dtr-summary', [
            'title' => 'DTR Summary',
            'summary' => $this->p()->dtrSummary((int) ($p['id'] ?? 1), $month),
        ]);
    }

    public function devices(Request $req): string
    {
        return View::render('timekeeping/devices', ['title' => 'Devices', 'rows' => $this->p()->attendanceDevices()]);
    }

    public function leave(Request $req): string
    {
        return View::render('leave/index', [
            'title' => 'Leave',
            'requests' => $this->p()->leaveRequests(),
            'balances' => $this->p()->leaveBalances(),
        ]);
    }

    public function leaveTypes(Request $req): string
    {
        return View::render('leave/types', ['title' => 'Leave Types', 'rows' => $this->p()->leaveTypes()]);
    }

    public function overtime(Request $req): string
    {
        return View::render('overtime/index', ['title' => 'Overtime', 'rows' => $this->p()->overtimeRequests()]);
    }

    public function payroll(Request $req): string
    {
        return View::render('payroll/index', ['title' => 'Payroll', 'periods' => $this->p()->payrollPeriods()]);
    }

    public function payrollRun(Request $req, array $p): string
    {
        return View::render('payroll/run-detail', [
            'title' => 'Payroll Run',
            'detail' => $this->p()->payrollRunDetail((int) $p['id']),
        ]);
    }

    public function payslip(Request $req, array $p): string
    {
        return View::render('payroll/payslip', [
            'title' => 'Payslip',
            'slip' => $this->p()->payslip((int) ($p['eid'] ?? 1), (int) ($p['pid'] ?? 3)),
        ]);
    }

    public function loans(Request $req): string
    {
        return View::render('loans/index', ['title' => 'Loans', 'rows' => $this->p()->loans()]);
    }

    public function benefits(Request $req): string
    {
        return View::render('benefits/index', ['title' => 'Benefits', 'rows' => $this->p()->benefits()]);
    }

    public function assets(Request $req): string
    {
        return View::render('assets/index', ['title' => 'Assets', 'rows' => $this->p()->assets()]);
    }

    public function performance(Request $req): string
    {
        return View::render('performance/index', ['title' => 'Performance', 'rows' => $this->p()->performanceReviews()]);
    }

    public function training(Request $req): string
    {
        return View::render('training/index', ['title' => 'Training', 'rows' => $this->p()->trainingRecords()]);
    }

    public function announcements(Request $req): string
    {
        return View::render('announcements/index', ['title' => 'Announcements', 'rows' => $this->p()->announcements()]);
    }

    public function reports(Request $req): string
    {
        return View::render('reports/index', ['title' => 'Reports']);
    }

    public function audit(Request $req): string
    {
        return View::render('audit/index', ['title' => 'Audit Trail', 'rows' => $this->p()->auditLogs()]);
    }

    public function settings(Request $req): string
    {
        return View::render('settings/index', [
            'title' => 'Settings',
            'company' => $this->p()->companySettings(),
            'contributions' => $this->p()->contributionRuleSets(),
        ]);
    }
}