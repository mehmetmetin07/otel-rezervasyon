<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    /**
     * Doldurulabilir alanlar
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Bu rol ile ilişkili kullanıcılar
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
