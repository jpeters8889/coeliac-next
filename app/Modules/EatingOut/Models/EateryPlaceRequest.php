<?php

declare(strict_types=1);

namespace App\Modules\EatingOut\Models;

use Illuminate\Database\Eloquent\Model;

class EateryPlaceRequest extends Model
{
    protected $casts = [
        'completed' => 'bool',
    ];
}
