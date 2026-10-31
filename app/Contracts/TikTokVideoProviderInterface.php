<?php
namespace App\Contracts;
interface TikTokVideoProviderInterface {
 public function profile(string $username): array;
 /** @return array{videos:array,next_cursor:?string} */
 public function videos(string $username,?string $cursor=null): array;
 /** Returns an approved media URL, or null if download is unsupported. */
 public function downloadUrl(string $username,string $videoId): ?string;
 public function health(): array;
}
