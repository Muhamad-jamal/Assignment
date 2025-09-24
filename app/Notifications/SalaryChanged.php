<?php

namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SalaryChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Employee $employee,
        private float $oldSalary,
        private string $recipientType // 'employee' or 'manager'
    ) {}

    public function via($notifiable): array
    {
    return ['mail', 'broadcast'];
    }

    public function toMail($notifiable): MailMessage
    {
        $subject = $this->recipientType === 'employee'
            ? 'Your Salary Has Been Updated'
            : 'Employee Salary Updated';

        $line = $this->recipientType === 'employee'
            ? "Hello {$notifiable->name}, your salary has changed from {$this->oldSalary} to {$this->employee->salary}."
            : "Hello {$notifiable->name}, the salary of {$this->employee->name} has changed from {$this->oldSalary} to {$this->employee->salary}.";

        return (new MailMessage)
            ->subject($subject)
            ->line($line);
    }

    public function toBroadcast($notifiable)
{
    return new \Illuminate\Notifications\Messages\BroadcastMessage([
        'employee_id' => $this->employee->id,
        'old_salary'  => $this->oldSalary,
        'new_salary'  => $this->employee->salary,
        'recipient'   => $this->recipientType,
    ]);
}
}
