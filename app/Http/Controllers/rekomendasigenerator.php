<?php

namespace App\Http\Controllers;

use App\Models\DataRekomendasi;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class Rekomendasigenerator extends Controller
{
    public function index($usercari)
    {
        $generatedata = $this->hitung($usercari);
        if($generatedata != []){
            DataRekomendasi::where('cust_uid',$usercari)->delete();
            DataRekomendasi::create([
                "cust_uid"=>$usercari,
                "menu_id"=>$generatedata[0]["idmenu"].",".$generatedata[1]["idmenu"].",".$generatedata[2]["idmenu"]
            ]);
        }
        return true;
    }
    public function hitung($usercari){
        $hasilrekomendasi = [];
        $listuser = [];
        $listmenu = Menu::select()->get();
        $listbelanja = [];
        //mengambil semua user yang telah belanja, karena guest maka digunakan uid yang disimpan pada cookie
        foreach(Order::select("cust_uid")->groupBy("cust_uid")->get() as $a){
            if($a["cust_uid"] != ""){
                array_push($listuser,$a["cust_uid"]);
            }
        }
        //membuat array untuk mencatat jumlah pembelian untuk masing-masing user dan menu
        foreach($listuser as $ab){
            $databaru = [$ab];
            foreach($listmenu as $a){
                $ambiljumlah = Order::where('cust_uid', $ab)
                ->whereHas('orderItems', function ($query) use ($a) {
                    $query->where('menu_id', $a["id"]);
                })
                ->with(['orderItems' => function ($query) use($a){
                    $query->where('menu_id', $a["id"]);
                }]) 
                ->get()
                ->pluck('orderItems')  // Ambil semua orderItems
                ->flatten()            // Gabungkan array nested menjadi satu level
                ->pluck('quantity'); ;
                $counterjumlah = 0;
                foreach($ambiljumlah as $c){
                    $counterjumlah += $c;
                }
                array_push($databaru,$counterjumlah);
            }
            array_push($listbelanja,$databaru);
        }
        // print_r($listbelanja);
        if(count($listuser) == 1){
            return $hasilrekomendasi;
        }
        // $listbelanja = [
        //     ['fffec9d5-a7f9-4e62-99b0-ee59a6626660', 2, 3, 0],
        //     ['fffec9d5-a7f9-4e62-99b0-ee59a6626661', 1, 0, 4],
        //     ['fffec9d5-a7f9-4e62-99b0-ee59a6626664', 2, 1, 2],
        // ];
        // $listmenu = [1,2,3];
        $similarity = [];
        for($i=1;$i<=count($listmenu);$i++){
            for($ii=$i+1;$ii<=count($listmenu);$ii++){
                $nama = $i."dan".$ii;
                $nama2 = $ii."dan".$i;
                $data1 = [];
                foreach($listbelanja as $a){
                    array_push($data1,$a[$i]);
                }
                $data2= [];
                foreach($listbelanja as $a){
                    array_push($data2,$a[$ii]);
                }
                $perhitunganatas = 0;
                for($z = 0;$z<count($data1);$z++){
                    $perhitunganatas += $data1[$z]*$data2[$z];
                }
                $perhitunganbawah1 = 0;
                for($z = 0;$z<count($data1);$z++){
                    $perhitunganbawah1 += pow($data1[$z],2);
                }
                $perhitunganbawah1 = sqrt($perhitunganbawah1);
                $perhitunganbawah2 = 0;
                for($z = 0;$z<count($data1);$z++){
                    $perhitunganbawah2 += pow($data2[$z],2);
                }
                $perhitunganbawah2 = sqrt($perhitunganbawah2);
                $perhitunganbawah = $perhitunganbawah1*$perhitunganbawah2;
                if($perhitunganbawah == 0){
                    $similarity[$nama] = 0;
                    $similarity[$nama2] = 0;
                }else{
                    $similarity[$nama] = $perhitunganatas/$perhitunganbawah;
                    $similarity[$nama2] = $perhitunganatas/$perhitunganbawah;
                }
            }
        }
        $prediksi = $listbelanja;
        $indexusercari = array_search($usercari, array_column($listbelanja, 0));
        for($i=1;$i<=count($listmenu);$i++){
            $perhitunganatas = 0;
            for($ii=1;$ii<=count($listmenu);$ii++){
                if($i != $ii){
                    $nama = $i."dan".$ii;
                    $perhitunganatas+= $similarity[$nama]*$listbelanja[$indexusercari][$ii];
                }
            }
            $perhitunganbawah = 0;
            for($ii=1;$ii<=count($listmenu);$ii++){
                if($i != $ii){
                    $nama = $i."dan".$ii;
                    $perhitunganbawah+= $similarity[$nama];
                }
            }
            if($perhitunganbawah == 0){
                $prediksi[$indexusercari][$i] = 0;
            }else{
                $prediksi[$indexusercari][$i] = $perhitunganatas/$perhitunganbawah;
            }
        }
        $hasil = [];
        for($i=1;$i<=count($listmenu);$i++){
            $arrpush = [];
            $arrpush["idmenu"] = $listmenu[$i-1]["id"];
            $arrpush["prediksi"] = $prediksi[$indexusercari][$i];
            array_push($hasil,$arrpush);
        };
        usort($hasil, function ($a, $b) {
            return $b['prediksi'] <=> $a['prediksi'];
        });
        $hasilrekomendasi = array_slice($hasil, 0, 3);
        return $hasilrekomendasi;
    }
}
