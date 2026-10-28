<?php

namespace App\Contracts;

interface TikTokVideoProviderInterface
{
    /**
     * Return normalized metadata for a public profile.
     *
     * @return array{username:string, videos:array<int, array<string, mixed>>, next_cursor:?string}
     */
    public function listProfileVideos(string $username, ?string $cursor = null): array;

    /**
     * Return an authorized media download URL for a known video, or null when
     * the provider cannot offer a downloadable file.
     */
    public function getDownloadUrl(string $videoId): ?string;
}
