<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\WeeklyReport;

/**
 * 週報に関するサービス
 */
class WeeklyReportService
{
    /**
     * 週報を新規作成します。
     *
     * @param array<string> $contents 作成したい週報のコンテンツ
     * @return WeeklyReport 作成した週報データ
     */
    public function create(array $contents): WeeklyReport
    {
        $weeklyReport = new WeeklyReport();
        return $weeklyReport->create($contents);
    }
}
