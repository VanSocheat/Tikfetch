<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DownloadHistory extends Model {
 protected $table='download_history';
 protected $guarded=[];
 protected $casts=['requested_at'=>'datetime','completed_at'=>'datetime'];
}
