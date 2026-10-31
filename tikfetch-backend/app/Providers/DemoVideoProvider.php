<?php
namespace App\Providers;
use App\Contracts\TikTokVideoProviderInterface;
use App\DTO\Video;
final class DemoVideoProvider implements TikTokVideoProviderInterface {
 public function profile(string $username):array {return ['username'=>$username,'sample'=>true];}
 public function videos(string $username,?string $cursor=null):array {
  if ($cursor!==null) return ['videos'=>[],'next_cursor'=>null];
  $items=[];for($i=1;$i<=8;$i++) $items[]=(new Video('sample-'.$i,$username,'https://www.tiktok.com/@'.$username.'/video/sample-'.$i,'Sample video '.$i.' — demonstration only',null,15+$i,null,false,true))->toArray();
  return ['videos'=>$items,'next_cursor'=>null];
 }
 public function downloadUrl(string $username,string $videoId):?string {return null;}
 public function health():array {return ['status'=>'demo','message'=>'Sample data only; downloads disabled'];}
}
