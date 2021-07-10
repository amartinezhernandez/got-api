<?php


namespace App\Infrastructure\Slim\Setting;


class ConfigLoader
{
    protected $config = null;

    public function __construct(string $configPath)
    {
        if (!file_exists($configPath)) {
            throw new \InvalidArgumentException('El archivo "' . $configPath . '" no existe.');
        }

        $this->config = json_decode(
            file_get_contents($configPath),
            true
        );
    }

    public function get(string $key, string $default = ''): string
    {
        return $this->config[$key] ?? $default;
    }
}
