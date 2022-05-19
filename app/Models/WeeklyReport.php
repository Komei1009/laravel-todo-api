<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 週報に関するモデル
 *
 * @property int $id
 * @property string $reporter 報告者
 * @property string $report_week 報告週
 * @property string $activity_time 活動時間
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereActivityTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereReportWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereReporter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklyReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WeeklyReport extends Model
{
    use HasFactory;

    /**
     * 週報のコードからの代入可能カラム
     *
     * @var array<string>
     */
    protected $fillable = [
        'reporter',
        'report_week',
        'activity_time',
    ];
}
