<?php

declare(strict_types=1);

namespace Tests\Feature\WeeklyReport;

use Tests\Feature\AuthHeader;
use Tests\TestCase;

/**
 * 週報APIのテスト
 */
class StoreTest extends TestCase
{
    use AuthHeader;

    /**
     * 正しい情報で登録できる。
     *
     * @return void
     */
    public function testWithStoreWeeklyReport(): void
    {
        $postData = ['reporter' => 'テスト', 'report_week' => '4月第1週', 'activity_time' => '自学時間: 10時間、協同時間: 10時間'];
        $this->withHeaders($this->buildAuthHeader('repo_user', 'repo_user_password'))
            ->postJson('/api/weekly-reports', $postData)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'reporter',
                    'report_week',
                    'activity_time',
                    'created_at',
                    'updated_at'
                ],
            ]);
        $this->assertDatabaseHas('weekly_reports', $postData);
    }
}
