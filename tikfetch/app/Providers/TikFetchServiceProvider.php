<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Contracts\TikTokVideoProviderInterface;
use App\Providers\DemoVideoProvider;
final class TikFetchServiceProvider extends ServiceProvider {
 public function register():void {
  $this->app->bind(TikTokVideoProviderInterface::class,function(){
   if(config('tikfetch.provider')!=='demo') throw new \RuntimeException('Live provider not configured: implement and authorize an adapter before enabling it.');
   return new DemoVideoProvider;
  });
 }
}
