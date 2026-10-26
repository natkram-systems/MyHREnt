<?php
declare(strict_types=1);
namespace MyHR\Support;

final class DemoProvider implements DataProvider
{
    public function currentUser(): array { return DemoData::user(); }
    public function dashboardStats(): array { return DemoData::dashboardStats(); }
    public function recentHires(): array { return DemoData::recentHires(); }
    public function onboardingInProgress(): array { return DemoData::onboardingInProgress(); }

    public function employees(string $q = '', ?string $status = null): array
    {
        $rows = DemoData::employees();
        if ($q !== '') {
            $q = mb_strtolower($q);
            $rows = array_filter($rows, fn($r) =>
                str_contains(mb_strtolower($r['first_name'].' '.$r['last_name']), $q)
                || str_contains(mb_strtolower($r['employee_no']), $q));
        }
        if ($status) $rows = array_filter($rows, fn($r) => $r['employment_status'] === $status);
        return array_values($rows);
    }

    public function employee(int $id): ?array
    {
        foreach (DemoData::employees() as $e) if ($e['id'] === $id) return $e;
        return null;
    }

    public function employeeIdentifiers(int $id): array { return DemoData::employeeIdentifiers($id); }
    public function employeeHistory(int $id): array     { return DemoData::employeeHistory($id); }
    public function employeeOnboarding(int $id): ?array { return DemoData::employeeOnboarding($id); }
    public function departments(): array                { return DemoData::departments(); }
    public function positions(): array                  { return DemoData::positions(); }
    public function jobPostings(): array                { return DemoData::jobPostings(); }
    public function recruitmentPipeline(int $id): array { return DemoData::recruitmentPipeline($id); }
    public function timekeepingToday(): array           { return DemoData::timekeepingToday(); }
    public function dtrSummary(int $id, string $m): array { return DemoData::dtrSummary($id, $m); }
    public function attendanceDevices(): array          { return DemoData::attendanceDevices(); }
    public function leaveTypes(): array                 { return DemoData::leaveTypes(); }
    public function leaveBalances(): array              { return DemoData::leaveBalances(); }
    public function leaveRequests(): array              { return DemoData::leaveRequests(); }
    public function overtimeRequests(): array           { return DemoData::overtimeRequests(); }
    public function payrollPeriods(): array             { return DemoData::payrollPeriods(); }
    public function payrollRunDetail(int $id): array    { return DemoData::payrollRunDetail($id); }
    public function payslip(int $e, int $p): array      { return DemoData::payslip($e, $p); }
    public function contributionRuleSets(): array       { return DemoData::contributionRuleSets(); }
    public function loans(): array                      { return DemoData::loans(); }
    public function benefits(): array                   { return DemoData::benefits(); }
    public function assets(): array                     { return DemoData::assets(); }
    public function performanceReviews(): array         { return DemoData::performanceReviews(); }
    public function trainingRecords(): array            { return DemoData::trainingRecords(); }
    public function announcements(): array              { return DemoData::announcements(); }
    public function companySettings(): array            { return DemoData::companySettings(); }
    public function auditLogs(int $limit = 20): array   { return DemoData::auditLogs($limit); }
}