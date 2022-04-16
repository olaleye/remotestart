<?php

namespace Core;

class Application
{
    private static string $ROOT_DIR;

    public function __construct(string $rootDir)
    {
        self::$ROOT_DIR = $rootDir;
    }

    public function run(): void
    {
        // TODO
    }
}