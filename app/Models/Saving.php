<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        "sum", "saving_category_id", "comment"
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function saving_category(): BelongsTo
    {
        return $this->belongsTo(Saving_Category::class);
    }
    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y-m-d');
    }
}
