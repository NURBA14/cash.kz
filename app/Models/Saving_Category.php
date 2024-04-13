<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Saving_Category extends Model
{
    use HasFactory;
    protected $table = 'saving_categories';
    protected $fillable = [
        "name", "description"
    ];

    public function savings(): HasMany
    {
        return $this->hasMany(Saving::class, "saving_category_id", "id");
    }
    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);        
        return $createdAt->format('Y:m:d H:i:s');
    }
}
