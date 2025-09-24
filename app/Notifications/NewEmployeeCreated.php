<?php

namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewEmployeeCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Employee $employee) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Employee Assigned')
            ->greeting("Hello {$notifiable->name},")
            ->line("A new employee, {$this->employee->name}, has been added to the team.")
            ->line("Salary: {$this->employee->salary}")
            ->line("Position: {$this->employee->position->title}")
            ->action('View Employee', url("/employees/{$this->employee->id}"))
            ->line('Thank you for managing your team!');
    }
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
