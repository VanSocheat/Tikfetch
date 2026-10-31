<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {
  Schema::create('video_lookup_logs',function(Blueprint $t){$t->id();$t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();$t->string('normalized_profile_username',24)->index();$t->string('provider',50);$t->string('status',30)->index();$t->string('error_code',80)->nullable();$t->timestamps();});
  Schema::create('download_history',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->string('video_id',128);$t->string('video_caption',500)->nullable();$t->string('original_video_url',2048);$t->string('status',30)->index();$t->string('error_code',80)->nullable();$t->timestamp('requested_at')->index();$t->timestamp('completed_at')->nullable();$t->timestamps();$t->index(['user_id','requested_at']);});
  Schema::create('app_settings',function(Blueprint $t){$t->id();$t->string('key')->unique();$t->text('value')->nullable();$t->timestamps();});
 }
 public function down():void {Schema::dropIfExists('app_settings');Schema::dropIfExists('download_history');Schema::dropIfExists('video_lookup_logs');}
};
