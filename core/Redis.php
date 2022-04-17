<?php

namespace Core;

use Exception;
use Predis\Client;

class Redis
{
    private static Client $predis;
    private static object $redis;

    private function __construct(array $config)
    {
        $host = $config['host'] ?? '';
        $password = $config['password'] ?? null;
        $port = $config['port'] ?? '';
        $scheme = $config['scheme'] ?? 'tcp';

        try {
            self::$predis = new Client([
                'scheme' => $scheme,
                'host'=> $host,
                'port' => $port,
                'password' => $password
            ]);

        } catch (Exception $e) {
            echo __CLASS__ . " {$e->getMessage()}";
        }
    }

    public static function getConnection(array $config): object
    {
        if(! isset(self::$redis)){
            self::$redis = new Redis($config);
        }

        return self::$redis;
    }

    public static function getRedis(): Client
    {
        return self::$predis;
    }
}