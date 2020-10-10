<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\UserController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testSuccessfulLogin()
    {
        $authServiceMock = $this->createMock(AuthService::class);
        $authServiceMock->expects($this->once())
            ->method('login')
            ->willReturn('test-token');
        $loginRequestMock = $this->createMock(LoginRequest::class);
        $loginRequestMock->expects($this->once())
            ->method('only')
            ->with(['email', 'password'])
            ->willReturn([
                'email' => 'foo@bar.com',
                'password' => '123456'
            ]);

        $controller = new UserController($authServiceMock);
        $response = $controller->login($loginRequestMock);

        $content = $response->getContent();

        $this->assertEquals('{"token":"test-token"}', $content);
    }

    public function testFailedLogin()
    {
        $exceptionMock = $this->createMock(ValidationException::class);

        $authServiceMock = $this->createMock(AuthService::class);
        $authServiceMock->expects($this->once())
            ->method('login')
            ->willThrowException($exceptionMock);

        $loginRequestMock = $this->createMock(LoginRequest::class);
        $loginRequestMock->expects($this->once())
            ->method('only')
            ->with(['email', 'password'])
            ->willReturn([
                'email' => 'foo@bar.com',
                'password' => '123456'
            ]);

        $controller = new UserController($authServiceMock);
        $response = $controller->login($loginRequestMock);

        $this->assertSame(401, $response->getStatusCode());
        $this->assertEquals('{"message":"Invalid username or password"}', $response->getContent());
    }

    public function testSuccessfulRegister()
    {
        $authServiceMock = $this->createMock(AuthService::class);
        $authServiceMock->expects($this->once())
            ->method('register')
            ->willReturn([
                'email' => 'junia@gmail.com',
                'name' => 'api',
                'type' => 'owner'
            ]);

        $registerRequestMock = $this->createMock(RegisterRequest::class);
        $registerRequestMock->expects($this->once())
            ->method('only')
            ->with(['email', 'name', 'type', 'password'])
            ->willReturn([
                'email' => 'junia@gmail.com',
                'name' => 'api',
                'type' => 'owner',
                'password' => 123456
            ]);

        $controller = new UserController($authServiceMock);
        $response = $controller->register($registerRequestMock);

        $this->assertEquals('{"email":"junia@gmail.com","name":"api","type":"owner"}', $response->getContent());
    }

}
