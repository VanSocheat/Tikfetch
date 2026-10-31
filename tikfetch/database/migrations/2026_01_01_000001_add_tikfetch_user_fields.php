<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {Schema::table('users',function(Blueprint $t){$t->string('role')->default('user')->index();$t->string('status')->default('active')->index();$t->unsignedInteger('daily_quota')->nullable();});}
 public function down():void {Schema::table('users',fn(Blueprint $t)=>$t->dropColumn(['role','status','daily_quota']));}
};
