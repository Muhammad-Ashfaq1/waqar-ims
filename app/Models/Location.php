<?php

namespace App\Models;

use App\Enums\LocationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'location_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'location_type' => LocationType::class,
        ];
    }

    public const LOCATION_TYPE_TOWN = 'town';

    public const LOCATION_TYPE_WORKSHOP = 'workshop';

    public const LOCATION_TYPE_OFFICE = 'office';

    public const LOCATION_TYPE_YARD = 'yard';

    public const IS_ACTIVE = 1;

    public const IS_INACTIVE = 0;

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function issuances(): HasMany
    {
        return $this->hasMany(Issuance::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return $this->location_type instanceof LocationType
            ? $this->location_type->label()
            : LocationType::tryFrom((string) $this->location_type)?->label() ?? '—';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', self::IS_ACTIVE);
    }
}
