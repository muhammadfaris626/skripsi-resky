<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'target_id', 'achieved'];

    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function target(): BelongsTo {
        return $this->belongsTo(Target::class, 'target_id');
    }
}
