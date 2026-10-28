<?php

namespace Tests\Feature;

use App\Services\TikTokProfileUrlParser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProfileUrlParserTest extends TestCase
{
    public function test_parses_supported_profile_url(): void
    {
        $parser = new TikTokProfileUrlParser();
        $this->assertSame('example_user', $parser->parse('https://www.tiktok.com/@example_user'));
    }

    public function test_rejects_untrusted_host(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TikTokProfileUrlParser())->parse('https://evil.example/@example_user');
    }

    public function test_rejects_video_url_when_profile_expected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TikTokProfileUrlParser())->parse('https://www.tiktok.com/@example/video/123456');
    }
}
