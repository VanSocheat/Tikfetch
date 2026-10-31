<?php
namespace App\Services;
use App\Contracts\TikTokVideoProviderInterface;
use App\Exceptions\TikTokProviderException;
final class TikTokDownloadService {
 public function __construct(private TikTokVideoProviderInterface $provider,private OutboundUrlGuard $guard) {}
 public function getUrl(string $username,string $videoId):string {
  $url=$this->provider->downloadUrl($username,$videoId);
  if (!$url) throw new TikTokProviderException('This provider does not offer authorized video downloads.');
  $this->guard->assertAllowed($url,config('tikfetch.allowed_media_hosts',[]));
  return $url;
 }
 public function filename(string $username,string $id):string {
  return preg_replace('/[^A-Za-z0-9_-]/','_', $username).'_'.preg_replace('/[^A-Za-z0-9_-]/','_',$id).'.mp4';
 }
}
