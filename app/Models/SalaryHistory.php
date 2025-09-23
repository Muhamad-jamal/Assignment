<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryHistory extends Model
{
    use HasFactory;

    protected $table = 'salary_histories';

    protected $fillable = [
        'employee_id',
        'changed_by',
        'old_salary',
        'new_salary',
        'changed_at',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
        'old_salary' => 'decimal:2',
        'new_salary' => 'decimal:2',
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
