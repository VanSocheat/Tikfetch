<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\TikTokVideoService;
use App\Services\TikTokDownloadService;
use App\Models\DownloadHistory;
class DownloadController extends Controller {
 public function download(Request $request,TikTokVideoService $videos,TikTokDownloadService $downloads){
  $data=$request->validate(['username'=>'required|regex:/^[A-Za-z0-9._]{2,24}$/','video_id'=>'required|string|max:128']);
  $user=$request->user();abort_unless($user->status==='active',403);
  $quota=$user->daily_quota??config('tikfetch.daily_quota');
  $used=DownloadHistory::where('user_id',$user->id)->whereDate('requested_at',today())->count();
  if($used >= $quota) return back()->withErrors(['download'=>'Daily download quota reached.']);
  $video=$videos->find($data['username'],$data['video_id']);
  if(!$video) return back()->withErrors(['download'=>'Video not found in authorized provider results.']);
  $history=DownloadHistory::create(['user_id'=>$user->id,'video_id'=>$video['id'],'video_caption'=>$video['caption']??null,'original_video_url'=>$video['url'],'status'=>'failed','error_code'=>'UNAVAILABLE','requested_at'=>now()]);
  if(!($video['downloadable']??false) || ($video['sample']??false)) return back()->withErrors(['download'=>'Demo or view-only video: download unavailable.']);
  try {$url=$downloads->getUrl($data['username'],$data['video_id']);}
  catch(\Throwable $e){report($e);return back()->withErrors(['download'=>'Authorized media download is unavailable.']);}
  // No redirect to an external host: external signed URLs may open inline and cannot guarantee download completion.
  // This release deliberately fails closed until an audited bounded streaming adapter is implemented.
  $history->update(['error_code'=>'STREAMING_NOT_CONFIGURED']);
  return back()->withErrors(['download'=>'Streaming is not configured for this provider.']);
 }
}
