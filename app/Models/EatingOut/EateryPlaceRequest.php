<?php

declare(strict_types=1);

namespace App\Models\EatingOut;

use Illuminate\Database\Eloquent\Model;

class EateryPlaceRequest extends Model
{
    protected $table = 'place_requests';

    protected $casts = [
        'completed' => 'bool',
    ];
}
