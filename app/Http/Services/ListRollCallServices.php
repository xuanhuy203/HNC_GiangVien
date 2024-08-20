<?php

namespace App\Http\Services;

use App\Models\DanhSachDiemDanh;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Lop;
use App\Models\KyHoc;
use App\Models\DanhSachMonHoc;
use App\Models\GiangVienMonHoc;
use App\Models\MonHocKy;

class ListRollCallServices
{
    public function getDataDiemDanh($monHocKyId)
    {
        // Lấy giảng viên hiện tại
        $user = Auth::user();
        $maGV = $user->MaGV;

        if (!$maGV) {
            return [];
        }

        // Eloquent Query Builder.
        // Truy vấn dữ liệu với điều kiện dựa trên monhoc_ky.id
        $danhSachDiemDanh = DanhSachDiemDanh::query()
            ->join('sinhvien', 'sinhvien.MaSV', '=', 'danhsach_diemdanh.MaSV')
            ->join('danhsach_monhoc', 'danhsach_monhoc.MaMonHoc', '=', 'danhsach_diemdanh.MaMonHoc')
            ->join('monhoc_ky', 'danhsach_monhoc.MaMonHoc', '=', 'monhoc_ky.MaMonHoc')
            ->join('tb_hoso', 'sinhvien.HoSo_ID', '=', 'tb_hoso.id')
            ->join('giangvien_monhoc', 'monhoc_ky.id', '=', 'giangvien_monhoc.MonHocKy_ID')
            ->join('lop', 'giangvien_monhoc.MaLop', '=', 'lop.MaLop')
            ->where('monhoc_ky.id', $monHocKyId)  // Điều kiện lọc dựa trên monhoc_ky.id
            ->select(
                'danhsach_monhoc.TenMon',
                'danhsach_diemdanh.id',
                'danhsach_diemdanh.TietBD',
                'danhsach_diemdanh.TietKT',
                'danhsach_diemdanh.Ca',
                'danhsach_diemdanh.SoTietDiMuon',
                'danhsach_diemdanh.NgayDiemDanh',
                'danhsach_diemdanh.GhiChu',
                'tb_hoso.HoDem',
                'tb_hoso.Ten',
                'sinhvien.MaSV',
                'lop.TenLop'
            )
            ->get();

        // dd($danhSachDiemDanh);

        return compact('danhSachDiemDanh');
    }
}