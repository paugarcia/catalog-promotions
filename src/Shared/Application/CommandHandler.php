<?php

namespace App\Shared\Application;

Interface CommandHandler
{
    public function handle(Command $command): void;
}