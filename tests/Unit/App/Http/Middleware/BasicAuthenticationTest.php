<?php

declare(strict_types=1);

namespace Tests\Unit\App\Http\Middleware;

use App\Http\Middleware\BasicAuthentication;
use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * ベーシック認証のテスト
 *
 * @see BasicAuthentication
 */
class BasicAuthenticationTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private Repository & MockInterface $config;
    private Request & MockInterface $request;
    private Response & MockInterface $response;
    private ResponseFactory & MockInterface $factory;
    private Closure $next;

    /**
     * テスト前に必ず実行する処理
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Repository&MockInterface $config 設定のモック */
        $config = Mockery::mock(Repository::class);
        $this->config = $config;

        /** @var Request&MockInterface $request リクエストのモック */
        $request = Mockery::mock(Request::class);
        $this->request = $request;

        /** @var Response&MockInterface $response 認証成功した場合のレスポンスのモック */
        $response = Mockery::mock(Response::class);
        $this->response = $response;

        $this->next = fn(): Response => $response;

        /** @var ResponseFactory&MockInterface $factory 認証失敗した場合のレスポンスファクトリのモック */
        $factory = Mockery::mock(ResponseFactory::class);
        $this->factory = $factory;
    }

    /**
     * 認証に成功した場合
     *
     * @return void
     */
    public function testHandleSuccess(): void
    {
        // ベーシック認証のユーザとパスワードを設定する
        $this->setBasicAuthCredentials('correct user', 'correct password');
        // リクエストから来るユーザとパスワードを設定する
        $this->setRequestedCredentials('correct user', 'correct password');

        // ミドルウェアの実行結果が、成功した場合のレスポンスであることを確認する
        $middleware = new BasicAuthentication($this->config, $this->factory);
        $this->assertSame($this->response, $middleware->handle($this->request, $this->next));
    }

    /**
     * 認証に失敗した場合
     *
     * @param string $correctUser
     * @param string $correctPassword
     * @param string|null $requestedUser
     * @param string|null $requestedPassword
     * @return void
     *
     * @dataProvider provideForHandleFailure ←のメソッドの返り値のパターンを全部チェックする
     */
    public function testHandleFailure(
        string $correctUser,
        string $correctPassword,
        ?string $requestedUser,
        ?string $requestedPassword
    ): void {
        // ベーシック認証のユーザとパスワードを設定する
        $this->setBasicAuthCredentials($correctUser, $correctPassword);
        // リクエストから来るユーザとパスワードを設定する
        $this->setRequestedCredentials($requestedUser, $requestedPassword);

        // 失敗した場合のレスポンスを生成する
        $failedResponse = Mockery::mock(JsonResponse::class);
        $this->factory->shouldReceive('json')->once()->andReturn($failedResponse);

        // ミドルウェアの実行結果が、失敗した場合のレスポンスであることを確認する
        $middleware = new BasicAuthentication($this->config, $this->factory);
        $this->assertSame($failedResponse, $middleware->handle($this->request, $this->next));
    }

    /**
     * 認証に失敗するパターン
     *
     * @return array<string, array<string, ?string>>
     */
    public function provideForHandleFailure(): array
    {
        $correctCredentials = [
            'correctUser' => 'correct user',
            'correctPassword' => 'correct password',
        ];

        return [
            'ユーザとパスワードが違う' => [
                ...$correctCredentials,
                'requestedUser' => 'invalid user',
                'requestedPassword' => 'invalid password'
            ],
            'ユーザだけ違う' => [
                ...$correctCredentials,
                'requestedUser' => 'correct user',
                'requestedPassword' => 'invalid password'
            ],
            'パスワードだけ違う' => [
                ...$correctCredentials,
                'requestedUser' => 'invalid user',
                'requestedPassword' => 'correct password'
            ],
            'ユーザやパスワードが null' => [
                ...$correctCredentials,
                'requestedUser' => null,
                'requestedPassword' => null
            ],
        ];
    }

    /**
     * ベーシック認証の認証情報を設定します。
     *
     * @param string $user
     * @param string $password
     * @return void
     */
    private function setBasicAuthCredentials(string $user, string $password): void
    {
        $this->config->shouldReceive('get')->with('auth.basic.user')->andReturn($user);
        $this->config->shouldReceive('get')->with('auth.basic.password')->andReturn($password);
    }

    /**
     * リクエストされる認証情報を設定します。
     *
     * @param string|null $user
     * @param string|null $password
     * @return void
     */
    private function setRequestedCredentials(?string $user, ?string $password): void
    {
        $this->request->shouldReceive('getUser')->andReturn($user);
        $this->request->shouldReceive('getPassword')->andReturn($password);
    }
}
