<?php

declare(strict_types=1);

namespace Tests\Feature;

/**
 * 認証用トレイト
 */
trait AuthHeader
{
    /**
     * 認証ヘッダを組み立てます。
     *
     * @param string $user
     * @param string $password
     * @return array<string, string>
     */
    protected function buildAuthHeader(string $user, string $password): array
    {
        return ['Authorization' => 'Basic ' . base64_encode("{$user}:{$password}")];
    }
}
