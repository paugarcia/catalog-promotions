<?php

namespace Catalog\Shared\Application;

Interface CommandHandler
{
    public function handle(Command $command): void;
}