<?php

namespace App\Console\Services;

use Illuminate\Console\Command;

/**
 * Interface HHServiceInterface
 * @package App\Console\Services
 */
interface HHServiceInterface
{
    public function update(Command $command): void;
}