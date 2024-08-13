<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\View\View;

interface OpenGraphActionContract
{
    public function handle(HasOpenGraphImageContract $model): View;
}
