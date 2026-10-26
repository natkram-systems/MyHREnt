<?php
declare(strict_types=1);
namespace MyHR\Support;

interface DataProvider
{
    public function currentUser(): array;
    public function dashboardStats(): array;
    public function recentHires(): array;
    public function onboardingInProgress(): array;
    public function employees(string $q = '', ?string $status = null): array;
    public function employee(int $id): ?array;
    public function employeeIdentifiers(int $id): array;
    public function employeeHistory(int $id): array;
    public function employeeOnboarding(int $id): ?array;
    public function departments(): array;
    public function positions(): array;
    public function jobPostings(): array;
    public function recruitmentPipeline(int $jobId): array;
    public function timekeepingToday(): array;
    public function dtrSummary(int $employeeId, string $month): array;
    public function attendanceDevices(): array;
    public function leaveTypes(): array;
    public function leaveBalances(): array;
    public function leaveRequests(): array;
    public function overtimeRequests(): array;
    public function payrollPeriods(): array;
    public function payrollRunDetail(int $periodId): array;
    public function payslip(int $employeeId, int $periodId): array;
    public function contributionRuleSets(): array;
    public function loans(): array;
    public function benefits(): array;
    public function assets(): array;
    public function performanceReviews(): array;
    public function trainingRecords(): array;
    public function announcements(): array;
    public function companySettings(): array;
    public function auditLogs(int $limit = 20): array;
}