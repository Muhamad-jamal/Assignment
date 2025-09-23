<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'position_id',
        'salary',
        'manager_id',
        'is_founder'
    ];
    protected $casts = [
        'salary' => 'decimal:2'
    ];
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function salaryHistories(): HasMany
    {
        return $this->hasMany(SalaryHistory::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(EmployeeLog::class);
    }
}
