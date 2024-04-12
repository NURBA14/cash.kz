<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Income_Category extends Model
{
    use HasFactory;
    protected $table = 'income_categories';
    public function incomes(): HasMany
    {
        return $this->hasMany(Income::class, "income_category_id");
    }
    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y:m:d H:i:s');
    }
}
