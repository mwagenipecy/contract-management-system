<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Jobs\SendEmployeeNotification;
use App\Jobs\SendAdminNotification;
use Carbon\Carbon;

class EmployeeNotificationService
{
    /**
     * Send contract renewal reminders
     */
    public static function sendContractRenewalReminders()
    {
        $contracts = \App\Models\Contract::with('employee')
            ->where('status', 'active')
            ->whereNotNull('end_date')
            ->whereNotNull('renewal_notice_period')
            ->get();

        foreach ($contracts as $contract) {
            $daysUntilExpiry = Carbon::now()->diffInDays(Carbon::parse($contract->end_date), false);
            
            if ($daysUntilExpiry == $contract->renewal_notice_period) {
                dispatch(new SendEmployeeNotification(
                    $contract->employee,
                    'contract_renewal_reminder',
                    'Contract Renewal Reminder',
                    [
                        'contract' => $contract,
                        'days_until_expiry' => $daysUntilExpiry,
                    ]
                ));
            }
        }
    }

    /**
     * Send contract expiry notifications
     */
    public static function sendContractExpiryNotifications()
    {
        $expiredContracts = \App\Models\Contract::with('employee')
            ->where('status', 'active')
            ->where('end_date', Carbon::today()->toDateString())
            ->get();

        foreach ($expiredContracts as $contract) {
            // Notify employee
            dispatch(new SendEmployeeNotification(
                $contract->employee,
                'contract_expired',
                'Contract Expired',
                ['contract' => $contract]
            ));

            // Notify HR
            $hrUsers = User::where('role', 'hr')->get();
            foreach ($hrUsers as $hrUser) {
                dispatch(new SendAdminNotification(
                    $hrUser,
                    'contract_expired_admin',
                    'Employee Contract Expired',
                    [
                        'contract' => $contract,
                        'employee' => $contract->employee,
                    ]
                ));
            }

            // Update contract status
            $contract->update(['status' => 'expired']);
        }
    }

    /**
     * Send birthday notifications
     */
    public static function sendBirthdayNotifications()
    {
        $employees = Employee::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') = ?", [
            Carbon::today()->format('m-d')
        ])->get();

        foreach ($employees as $employee) {
            dispatch(new SendEmployeeNotification(
                $employee,
                'birthday_reminder',
                'Happy Birthday!',
                ['employee' => $employee]
            ));
        }
    }

    /**
     * Send work anniversary notifications
     */
    public static function sendWorkAnniversaryNotifications()
    {
        $employees = Employee::whereRaw("DATE_FORMAT(hire_date, '%m-%d') = ?", [
            Carbon::today()->format('m-d')
        ])->get();

        foreach ($employees as $employee) {
            $years = Carbon::parse($employee->hire_date)->diffInYears(Carbon::today());
            
            if ($years > 0) {
                dispatch(new SendEmployeeNotification(
                    $employee,
                    'work_anniversary',
                    'Work Anniversary Celebration',
                    [
                        'employee' => $employee,
                        'years' => $years,
                    ]
                ));
            }
        }
    }

    /**
     * Send leave request notifications
     */
    public static function sendLeaveNotification(Employee $employee, $leaveRequest, $status)
    {
        $notificationType = $status === 'approved' ? 'leave_approved' : 'leave_rejected';
        $subject = $status === 'approved' ? 'Leave Request Approved' : 'Leave Request Rejected';

        dispatch(new SendEmployeeNotification(
            $employee,
            $notificationType,
            $subject,
            [
                'leave_request' => $leaveRequest,
                'status' => $status,
            ]
        ));
    }

    /**
     * Send salary update notification
     */
    public static function sendSalaryUpdateNotification(Employee $employee, $oldSalary, $newSalary)
    {
        dispatch(new SendEmployeeNotification(
            $employee,
            'salary_updated',
            'Salary Update Notification',
            [
                'old_salary' => $oldSalary,
                'new_salary' => $newSalary,
                'effective_date' => Carbon::today()->toDateString(),
            ]
        ));
    }

    /**
     * Send performance review notification
     */
    public static function sendPerformanceReviewNotification(Employee $employee, $reviewData)
    {
        dispatch(new SendEmployeeNotification(
            $employee,
            'performance_review',
            'Performance Review Scheduled',
            [
                'review' => $reviewData,
                'scheduled_date' => $reviewData['scheduled_date'] ?? null,
            ]
        ));
    }

    /**
     * Send policy update notification to all employees
     */
    public static function sendPolicyUpdateNotification($policyTitle, $policyDescription)
    {
        $employees = Employee::where('status', 'active')->get();

        foreach ($employees as $employee) {
            dispatch(new SendEmployeeNotification(
                $employee,
                'policy_update',
                'Important Policy Update',
                [
                    'policy_title' => $policyTitle,
                    'policy_description' => $policyDescription,
                    'update_date' => Carbon::today()->toDateString(),
                ]
            ));
        }
    }

    /**
     * Send meeting reminder notification
     */
    public static function sendMeetingReminderNotification(Employee $employee, $meetingData)
    {
        dispatch(new SendEmployeeNotification(
            $employee,
            'meeting_reminder',
            'Meeting Reminder',
            [
                'meeting' => $meetingData,
                'meeting_time' => $meetingData['start_time'] ?? null,
                'meeting_title' => $meetingData['title'] ?? 'Scheduled Meeting',
            ]
        ));
    }

    /**
     * Send custom notification
     */
    public static function sendCustomNotification(
        Employee $employee, 
        $subject, 
        $message, 
        $additionalData = []
    ) {
        dispatch(new SendEmployeeNotification(
            $employee,
            'custom',
            $subject,
            array_merge($additionalData, [
                'custom_message' => $message,
            ])
        ));
    }
}