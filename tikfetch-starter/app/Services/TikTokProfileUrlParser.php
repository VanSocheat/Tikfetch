<?php

namespace App\Services;

use InvalidArgumentException;

class TikTokProfileUrlParser
{
    public function parse(string $input): string
    {
        $input = trim($input);

        if ($input === '' || strlen($input) > 500) {
            throw new InvalidArgumentException('Enter a valid TikTok profile URL.');
        }

        if (!filter_var($input, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Paste a complete URL, such as https://www.tiktok.com/@username.');
        }

        $parts = parse_url($input);
        $scheme = strtolower($parts['scheme'] ?? '');
        $host = strtolower($parts['host'] ?? '');

        if (!in_array($scheme, ['https'], true) ||
            !in_array($host, ['tiktok.com', 'www.tiktok.com', 'm.tiktok.com'], true) ||
            isset($parts['user']) || isset($parts['pass'])) {
            throw new InvalidArgumentException('Only HTTPS TikTok profile URLs are supported.');
        }

        $path = trim($parts['path'] ?? '', '/');
        if (!preg_match('/^@([A-Za-z0-9._]{2,24})$/', $path, $matches)) {
            throw new InvalidArgumentException('Use a profile URL like https://www.tiktok.com/@username (not a video URL).');
        }

        return $matches[1];
    }
}
