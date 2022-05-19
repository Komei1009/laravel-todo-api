<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * ヘルスチェック用APIのテスト
 */
class HealthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHealth(): void
    {
        $this->get('/api/health')
            ->assertStatus(200);
    }
}
