<?php

namespace App\Models;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perdin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'kota_asal_id',
        'kota_tujuan_id',
        'tgl_berangkat',
        'tgl_pulang',
        'durasi',
        'uangsaku',
        'keterangan',
        'konfirmasi',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function kota($id=null)
    {
        $result = Kota::whereid($id)->first();
        return $result;
    }

    public function durasi($tgl_mulai = null,$tgl_selesai = null) {
        $datetime1 = new DateTime($tgl_mulai);
        $datetime2 = new DateTime($tgl_selesai);
        $interval = $datetime1->diff($datetime2);
        $result = $interval->format('%a') + 1;
        return $result;
   }

   public function jarak($lat1, $long1, $lat2, $long2){
    $theta = $long1 - $long2;
    $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $result_miles = $miles * 60 * 1.1515;
    $result =rtrim(round($result_miles*1.609344));
    return $result;
  }

  public function status ($konfirmasi){
    if ($konfirmasi == 'p'){
        $result = ' <span class="rounded m-1 pl-3 pr-3 pb-1 pt-1 text-white bg-warning">Pending</span>';
    } else if ($konfirmasi == 'y'){
        $result = ' <span class="rounded m-1 pl-3 pr-3 pb-1 pt-1 text-white bg-success">Approved</span>';
    }else{
        $result =  '<span class="rounded m-1 pl-3 pr-3 pb-1 pt-1 text-white bg-danger">Rejected</span>';
    }
    return $result;
  }

  public function uangsaku($jarak_km,$kota_asal,$kota_tujuan){
    if ($kota_tujuan->luar_negeri !== 1) {
      if ($jarak_km<60 || $jarak_km == "NAN" ) {
         $result = 0;
      }else{
          if ($kota_asal->provinsi_id == $kota_tujuan->provinsi_id){
              $result = 200000;
          }else{
              if ($kota_asal->pulau_id == $kota_tujuan->pulau_id) {
                  $result = 250000;
              }else{
                  $result = 300000;
              }
          }
      }        
  }else{
       $result = 50 ;
  }

    return $result;
  }
  public function total_uang($uang, $durasi){
    $result = $uang * $durasi;
     return $result;
   }

  public function lebihkm($jarak){
    if($jarak<60||$jarak=="NAN")  
    {
        $result = "(jarak < 60km)";
    }else{
        $result = "(jarak > 60km)";
    }
    return $result;
  }

  

}
