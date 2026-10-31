<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Services\TikTokProfileUrlParser;
class ProfileParserTest extends TestCase {
 public function test_valid_profile():void {$this->assertSame('example',(new TikTokProfileUrlParser)->parse('https://www.tiktok.com/@example'));}
 public function test_rejects_unsafe_urls():void {foreach(['http://www.tiktok.com/@example','https://evil.com/@example','https://www.tiktok.com.evil.com/@example','https://user:pass@www.tiktok.com/@example','https://www.tiktok.com/@a%2Fb','https://www.tiktok.com/@example/video/123'] as $url){try{(new TikTokProfileUrlParser)->parse($url);$this->fail($url);}catch(\InvalidArgumentException $e){$this->assertNotEmpty($e->getMessage());}}}
}
