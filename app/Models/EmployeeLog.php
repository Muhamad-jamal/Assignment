<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeLog extends Model
{
    use HasFactory;

    protected $table = 'employee_logs';

    protected $fillable = [
        'employee_id',
        'changed_by',
        'old_data',
        'new_data',
        'action',
    ];


    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
