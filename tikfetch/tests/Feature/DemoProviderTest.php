<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Providers\DemoVideoProvider;
class DemoProviderTest extends TestCase {
 public function test_samples_cannot_download():void {$provider=new DemoVideoProvider;$videos=$provider->videos('example')['videos'];$this->assertCount(8,$videos);foreach($videos as $v){$this->assertTrue($v['sample']);$this->assertFalse($v['downloadable']);$this->assertNull($provider->downloadUrl('example',$v['id']));}}
}
