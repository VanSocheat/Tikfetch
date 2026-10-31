<?php
namespace App\Services;
use App\Contracts\TikTokVideoProviderInterface;
final class TikTokVideoService {
 public function __construct(private TikTokVideoProviderInterface $provider) {}
 public function find(string $username,string $id):?array {
  $cursor=null;
  for($page=0;$page<3;$page++) {
   $result=$this->provider->videos($username,$cursor);
   foreach($result['videos'] as $video) if($video['id']===$id && $video['author']===$username) return $video;
   $cursor=$result['next_cursor']??null;if(!$cursor) break;
  }
  return null;
 }
}
