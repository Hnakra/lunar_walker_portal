<?php

namespace App\Filters;

use Closure;

interface Pipe{
    public function handle($content, Closure $next);
}
