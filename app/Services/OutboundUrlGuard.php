<?php
namespace App\Services;
use InvalidArgumentException;
final class OutboundUrlGuard {
 public function assertAllowed(string $url,array $hosts):void {
  $p=parse_url($url);
  if (!$p || ($p['scheme']??'')!=='https' || isset($p['user']) || isset($p['pass']) || isset($p['port'])) throw new InvalidArgumentException('Unapproved media URL.');
  $host=strtolower($p['host']??'');
  if (!in_array($host,$hosts,true) || filter_var($host,FILTER_VALIDATE_IP)) throw new InvalidArgumentException('Media host is not allowlisted.');
  $records=@dns_get_record($host,DNS_A|DNS_AAAA);
  if (!$records) throw new InvalidArgumentException('Media hostname cannot be resolved.');
  foreach($records as $r) {
   $ip=$r['ip']??$r['ipv6']??null;
   if (!$ip || !filter_var($ip,FILTER_VALIDATE_IP,FILTER_FLAG_NO_PRIV_RANGE|FILTER_FLAG_NO_RES_RANGE)) throw new InvalidArgumentException('Unsafe media IP address.');
  }
 }
}
