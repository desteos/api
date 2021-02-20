<?php

namespace System\Contracts;

interface Middleware
{
    public function handle(): void;
}