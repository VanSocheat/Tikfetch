<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\TikTokProfileUrlParser;
use App\Services\TikTokProfileService;
use App\Models\VideoLookupLog;
class ProfileController extends Controller {
 public function index(){return view('home');}
 public function lookup(Request $request,TikTokProfileUrlParser $parser,TikTokProfileService $service){
  $data=$request->validate(['profile_url'=>'required|string|max:2048','cursor'=>'nullable|string|max:256']);
  try {$username=$parser->parse($data['profile_url']);} catch(\InvalidArgumentException $e){return back()->withErrors(['profile_url'=>$e->getMessage()])->withInput();}
  try {$results=$service->lookup($username,$data['cursor']??null);$status='success';$error=null;}
  catch(\Throwable $e){report($e);$results=['videos'=>[],'next_cursor'=>null];$status='error';$error='Provider unavailable. Please retry later.';}
  VideoLookupLog::create(['user_id'=>auth()->id(),'normalized_profile_username'=>$username,'provider'=>config('tikfetch.provider'),'status'=>$status,'error_code'=>$error?'PROVIDER_UNAVAILABLE':null]);
  return view('gallery',compact('username','results','error'));
 }
}
