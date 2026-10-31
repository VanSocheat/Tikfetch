<?php
namespace App\Http\Controllers;
use App\Models\DownloadHistory;
class DashboardController extends Controller {
 public function index(){ $user=auth()->user();$history=DownloadHistory::where('user_id',$user->id)->latest('requested_at')->paginate(15);$used=DownloadHistory::where('user_id',$user->id)->whereDate('requested_at',today())->count();return view('dashboard.index',compact('user','history','used')); }
}
