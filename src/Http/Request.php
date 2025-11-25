<?php

namespace Coff\Framework\Http;

class Request
{
    public array $query;
    public array $request;
    public array $server;
    public array $headers;

    public function __construct()
    {
        $this->query = $_GET;
        $this->request = $_POST;
        $this->server = $_SERVER;
        $this->headers = $this->getAllHeaders();
    }

    public static function capture(): self
    {
        return new static();
    }

    public function get(string $key, $default = null)
    {
        return $this->query[$key] ?? $this->request[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->request);
    }
    
    public function getPath(): string
    {
        return parse_url($this->server['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    }
    
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    protected function getAllHeaders(): array
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }
        
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}

