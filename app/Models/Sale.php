<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['sale_date', 'amount', 'target_amount', 'employee_id'];

    public function user(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function history(): HasMany {
        return $this->hasMany(History::class);
    }
}
