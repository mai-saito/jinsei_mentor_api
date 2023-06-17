<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('life_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timeline_id')->constrained('timelines')->comment('年表ID');
            $table->string('title')->length(100)->comment('イベントタイトル');
            $table->text('description')->nullable()->comment('イベント説明');
            $table->string('slug')->length(20)->comment('グラフ表示タイトル');
            $table->integer('age')->length(2)->comment('年齢');
            $table->timestamps();
            $table->comment('年表イベントテーブル');
            $table->unique(['timeline_id', 'age']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('life_events_tables');
    }
};
