<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

/**
 * ベーシック認証を行うミドルウェア
 */
class BasicAuthentication
{
    /**
     * コンストラクタ
     *
     * @param Repository $config
     * @param ResponseFactory $factory
     */
    public function __construct(private readonly Repository $config, private readonly ResponseFactory $factory)
    {
    }

    /**
     * リクエストを処理します。
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse|JsonResponse) $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        // 認証成功の場合はリクエストを通す。
        if ($this->validate($request)) {
            return $next($request);
        }

        // 認証失敗の場合は認証を要求する。
        return $this->factory->json(
            ['message' => 'Unauthorized'],
            ResponseCode::HTTP_UNAUTHORIZED,
            ['WWW-Authenticate' => 'Basic']
        );
    }

    /**
     * ユーザとパスワードが正しいか確認します。
     *
     * @param Request $request
     * @return boolean
     */
    private function validate(Request $request): bool
    {
        return $request->getUser() === $this->config->get('auth.basic.user')
            && $request->getPassword() === $this->config->get('auth.basic.password');
    }
}
