<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * 週報のリソース
 *
 * @mixin \App\Models\WeeklyReport
 */
class WeeklyReportResource extends JsonResource
{
    /**
     * リソースを配列に変換
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed> レスポンスとして返す週報のコンテンツ
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'reporter' => $this->reporter,
            'report_week' => $this->report_week,
            'activity_time' => $this->activity_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
