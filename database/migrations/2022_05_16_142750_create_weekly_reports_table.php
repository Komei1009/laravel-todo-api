<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('weekly_reports', function (Blueprint $table): void {
            $table->id();
            $table->string('reporter')->comment('報告者');
            $table->string('report_week')->comment('報告週');
            $table->text('activity_time')->comment('活動時間');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
