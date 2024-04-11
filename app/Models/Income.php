<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function income_category(): BelongsTo
    {
        return $this->belongsTo(Income_Category::class);
    }
    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y-m-d');
    }
}