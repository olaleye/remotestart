<?php

namespace Tests\Unit\Core;

use Core\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private Request $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();
    }

    public function testGetPathReturnsAValidPath(): void
    {
        $this->setRequestURI('user?id=4');

        $path = $this->request->getPath();

        $this->assertSame('user', $path);
    }

    public function testGetPathReturnsTheHomePathWhenPathIsEmpty(): void
    {
        $this->setRequestURI();

        $path = $this->request->getPath();

        $this->assertSame('/', $path);
    }

    public function testGetMethodReturnsAValidMethod(): void
    {
        $this->setRequestMethod('POST');

        $this->assertSame('post', $this->request->getMethod());
    }

    public function testGetBodyReturnsAValidGetBody(): void
    {
        $this->setRequestURI('user?name=olaleye&title=remoteStar');
        $this->setRequestMethod();

        $body = $this->request->getBody();
        $this->assertSame($_GET, $body);
        $this->assertIsArray($body);
    }

    private function setRequestURI(?string $uri = null): void
    {
        $_SERVER['REQUEST_URI'] = $uri;
    }

    private function setRequestMethod(string $method = 'GET'): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
    }
}