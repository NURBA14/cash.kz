<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cost_Category extends Model
{
    use HasFactory;

    protected $table = 'cost_categories';

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, "cost_category_id");
    }
    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y:m:d H:i:s');
    }
}
