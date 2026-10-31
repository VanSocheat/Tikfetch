<?php
namespace App\Services;
use App\Contracts\TikTokVideoProviderInterface;
use Illuminate\Support\Facades\Cache;
final class TikTokProfileService {
 public function __construct(private TikTokVideoProviderInterface $provider) {}
 public function lookup(string $username,?string $cursor=null):array {
  return Cache::remember('tikfetch:'.hash('sha256',$username.'|'.($cursor??'')),now()->addMinutes(5),fn()=> $this->provider->videos($username,$cursor));
 }
}
