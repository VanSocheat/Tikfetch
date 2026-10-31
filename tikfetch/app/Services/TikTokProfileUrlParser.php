<?php
namespace App\Services;
use InvalidArgumentException;
final class TikTokProfileUrlParser {
 public function parse(string $input): string {
  if (strlen($input)>2048 || preg_match('/[\x00-\x20\x7f]/',$input)) throw new InvalidArgumentException('Invalid profile URL.');
  $parts=parse_url($input);
  if (!$parts || strtolower($parts['scheme']??'')!=='https' || isset($parts['user'],$parts['pass']) || isset($parts['user']) || isset($parts['port']) || isset($parts['query']) || isset($parts['fragment'])) throw new InvalidArgumentException('Use a public HTTPS TikTok profile URL.');
  $host=strtolower($parts['host']??'');
  if (!in_array($host,['www.tiktok.com','tiktok.com'],true)) throw new InvalidArgumentException('Only tiktok.com profiles are supported.');
  $path=$parts['path']??'';
  if (preg_match('/%2f|%5c|%25|%00/i',$path)) throw new InvalidArgumentException('Invalid encoded profile path.');
  $path=rawurldecode($path);
  if (!preg_match('~^/@([A-Za-z0-9._]{2,24})/?$~D',$path,$m)) throw new InvalidArgumentException('Invalid TikTok username or profile path.');
  return $m[1];
 }
}
