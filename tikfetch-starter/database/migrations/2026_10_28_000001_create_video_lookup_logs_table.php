<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('video_lookup_logs', function (Blueprint $table) {
            $table->id();
            $table->string('normalized_profile_username', 24)->index();
            $table->string('provider', 80)->default('demo');
            $table->string('status', 30)->default('success');
            $table->string('error_code', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('download_history', function (Blueprint $table) {
            $table->id();
            $table->string('video_id', 160)->index();
            $table->string('video_caption', 500)->nullable();
            $table->text('original_video_url');
            $table->string('status', 30)->default('requested');
            $table->string('error_code', 100)->nullable();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('download_history');
        Schema::dropIfExists('video_lookup_logs');
    }
};
