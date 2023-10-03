<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function booted()
    {
        static::creating(function (Location $location) {
            if (! $location->slug) {
                $location->slug = Str::slug($location->name);
            }
        });

        static::updating(function (Location $location) {
            $location->slug = Str::slug($location->name);
        });
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
