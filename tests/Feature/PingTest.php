<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * 接続確認用APIのテスト
 */
class PingTest extends TestCase
{
    use AuthHeader;

    /**
     * 正しい認証情報でアクセスできる。
     *
     * @return void
     */
    public function testPingWithValidUser(): void
    {
        $this->withHeaders($this->buildAuthHeader('repo_user', 'repo_user_password'))
            ->get('/api/ping')
            ->assertStatus(200)
            ->assertJson(['pong']);
    }

    /**
     * 不正な認証情報ではアクセスできない。
     *
     * @return void
     */
    public function testPingWithInvalidUser(): void
    {
        $this->withHeaders($this->buildAuthHeader('invalid_user', 'invalid_pass'))
            ->get('/api/ping')
            ->assertUnauthorized()
            ->assertHeader('WWW-Authenticate', 'Basic')
            ->assertJson(['message' => 'Unauthorized']);
    }

    /**
     * 認証ヘッダがない場合はアクセスできない。
     *
     * @return void
     */
    public function testPingWithoutAuthHeader(): void
    {
        $this->get('/api/ping')
            ->assertUnauthorized()
            ->assertHeader('WWW-Authenticate', 'Basic')
            ->assertJson(['message' => 'Unauthorized']);
    }
}
