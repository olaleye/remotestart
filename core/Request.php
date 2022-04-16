<?php

namespace Core;

class Request
{
    public function getPath(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if($position === false){
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody(): array
    {
        $body = [];

        if($this->getMethod() === 'get'){

            foreach ($_GET as $key => $value){
                $body[$key] = $this->filter(INPUT_GET, $key);
            }
        }

        if($this->getMethod() === 'post'){

            foreach ($_POST as $key => $value){
                $body[$key] = $this->filter(INPUT_POST, $key);
            }
        }

        return $body;
    }

    private function filter(int $inputType, int|string $key): mixed
    {
        return filter_input($inputType, $key, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}