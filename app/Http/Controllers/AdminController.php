<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DownloadHistory;
use App\Models\VideoLookupLog;
class AdminController extends Controller {
 private function guard():void {abort_unless(auth()->user()?->isAdmin(),403);}
 public function index(){ $this->guard();return view('admin.index',['users'=>User::count(),'downloads'=>DownloadHistory::count(),'success'=>DownloadHistory::where('status','success')->count(),'failed'=>DownloadHistory::where('status','failed')->count(),'providerErrors'=>VideoLookupLog::where('status','error')->count(),'members'=>User::latest()->paginate(20)]);}
 public function updateUser(Request $r,User $user){$this->guard();$d=$r->validate(['status'=>'required|in:active,suspended','daily_quota'=>'nullable|integer|min:0|max:10000']);abort_if($user->id===auth()->id() && $d['status']==='suspended',422);$user->update($d);return back()->with('message','User updated.');}
}
