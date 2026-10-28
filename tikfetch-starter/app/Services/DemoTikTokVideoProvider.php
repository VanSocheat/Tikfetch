<?php

namespace App\Services;

use App\Contracts\TikTokVideoProviderInterface;

class DemoTikTokVideoProvider implements TikTokVideoProviderInterface
{
    public function listProfileVideos(string $username, ?string $cursor = null): array
    {
        // Clearly labeled local fixtures. This does NOT contact TikTok.
        return [
            'username' => $username,
            'videos' => [
                [
                    'id' => 'demo_video_001',
                    'caption' => 'Sample video 1 — demo data only',
                    'thumbnail_url' => null,
                    'created_at' => null,
                    'duration' => null,
                    'original_url' => 'https://www.tiktok.com/@' . rawurlencode($username),
                    'demo' => true,
                    'download_available' => false,
                ],
                [
                    'id' => 'demo_video_002',
                    'caption' => 'Sample video 2 — demo data only',
                    'thumbnail_url' => null,
                    'created_at' => null,
                    'duration' => null,
                    'original_url' => 'https://www.tiktok.com/@' . rawurlencode($username),
                    'demo' => true,
                    'download_available' => false,
                ],
                [
                    'id' => 'demo_video_003',
                    'caption' => 'Sample video 3 — demo data only',
                    'thumbnail_url' => null,
                    'created_at' => null,
                    'duration' => null,
                    'original_url' => 'https://www.tiktok.com/@' . rawurlencode($username),
                    'demo' => true,
                    'download_available' => false,
                ],
            ],
            'next_cursor' => null,
        ];
    }

    public function getDownloadUrl(string $videoId): ?string
    {
        return null;
    }
}
