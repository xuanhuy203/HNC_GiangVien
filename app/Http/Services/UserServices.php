<?php

// app/Services/UserService.php
namespace App\Http\Services;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UserServices
{
    public function lecturerInfomation() 
    {
        // Lấy giảng viên hiện tại
        $user = Auth::user();
        $maGV = $user->MaGV;

        if (!$maGV) {
            return [];
        }
        $giangVien = DB::table("hoso_giangvien")
        ->select('Nganh_ID')
        ->where("MaGV", $maGV)->first();
        $nganhID = $giangVien->Nganh_ID;

        if (!$giangVien) {
            return [];
        }
        
        // Lấy thông tin giảng viên từ db (xảy ra vđ bảo m)
        $giangVien = User::with('tb_nganh')
            ->where('Nganh_ID', $nganhID)
            ->first()
            ->makeHidden(['password','remember_token']);

            // dd($giangVien);

        // dd($nganh);

        return $giangVien;
    }

    public function getNganh()
    {
        // Lấy giảng viên hiện tại
        $user = Auth::user();
        $maGV = $user->MaGV;

        if (!$maGV) {
            return [];
        }
        $giangVien = DB::table("hoso_giangvien")
        ->select('Nganh_ID')
        ->where("MaGV", $maGV)->first();
        $nganhID = $giangVien->Nganh_ID;

        $nganh = DB::table('tb_nganh')
        ->select('tb_nganh.*')
        ->where('id', $nganhID)
        ->first();

        // dd($nganh);
        return $nganh;
    }


    public function getDanToc()
    {
        
       // Lấy giảng viên hiện tại
       $user = Auth::user();
       $maGV = $user->MaGV;

       if (!$maGV) {
           return [];
       }

       $giangVien = DB::table("hoso_giangvien")
       ->select('DanToc_ID')
       ->where("MaGV", $maGV)->first();
       $danTocID = $giangVien->DanToc_ID;


       $danToc = DB::table('tb_dantoc')
       ->select('tb_dantoc.*')
       ->where('id', $danTocID)
       -> first();

        return $danToc;
    }

    public function getDanhsachNganh()
    {
        // Lấy danh sách ngành -> Column - key: 
        $danhsachNganh = DB::table('tb_nganh')->pluck('TenNganh', 'id');

        return $danhsachNganh;
    }

    public function getDanhsachDanToc()
    {
        // Lấy danh sách Dân Tộc -> Column - key: 
        $danhsachDanToc = DB::table('tb_dantoc')->pluck('TenDanToc', 'id');
        return $danhsachDanToc;
    }
}
