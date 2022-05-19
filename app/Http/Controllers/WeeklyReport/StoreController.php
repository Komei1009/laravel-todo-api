<?php

declare(strict_types=1);

namespace App\Http\Controllers\WeeklyReport;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeeklyReportResource;
use App\Services\WeeklyReportService;
use Illuminate\Http\Request;

/**
 * 週報の新規登録に関するコントローラ
 */
class StoreController extends Controller
{
    /**
     * 週報の登録
     *
     * @param Request $request
     * @param WeeklyReportService $service
     * @return WeeklyReportResource
     */
    public function __invoke(Request $request, WeeklyReportService $service): WeeklyReportResource
    {
        return new WeeklyReportResource(
            $service->create($request->only(['reporter', 'report_week', 'activity_time']))
        );
    }
}
