<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    protected $fillable = ['destination', 'departure_date'];

    protected function casts(): array
    {
        return ['departure_date' => 'date:Y-m-d'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(ChecklistItem::class)->orderBy('id');
    }
}
