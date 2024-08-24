<?php
// app/Http/Controllers/LecturerController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nganh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\UserServices;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\UploadServices;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    protected $userServices, $uploadServices;

    // Constructor để inject UserServices và UploadServices
    public function __construct(UserServices $userServices, UploadServices $uploadServices)
    {
        $this->userServices = $userServices;
        $this->uploadServices = $uploadServices;
    }

    // Hàm để lấy thông tin giảng viên và trả về view
    public function index()
    {
        // Lấy thông tin giảng viên từ Service
        $giangVien = $this->userServices->lecturerInfomation();
        $nganh = $this->userServices->getNganh();
        $danToc = $this->userServices->getDanToc();
        $danhsachNganh = $this->userServices->getdanhsachNganh();
        $danhsachDanToc = $this->userServices->getdanhsachDanToc();
        
        // dd($giangVien);
        return view('profile.thongtinGiangvien', [
            'title' => 'Thông tin giảng viên',
            'giangVien' => $giangVien,
            'nganh' => $nganh,
            'dantoc' => $danToc,
            'danhsachNganh' => $danhsachNganh,
            'danhsachDanToc' => $danhsachDanToc
        ]);
    }

    // Hàm upload ảnh
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $giangVien = $this->userServices->lecturerInfomation();
        $imagePath = $this->uploadServices->store($request);

        if ($imagePath) {
            // Xóa ảnh cũ nếu có
            if ($giangVien->HinhAnh) {
                Storage::delete('public/storage' . $giangVien->HinhAnh);
            }

            // Cập nhật ảnh mới
            $giangVien->HinhAnh = $imagePath;
            $giangVien->save(); // Lưu thông tin vào bảng hoso_giangvien

            toastify()->success('Upload thành công!');
            return redirect()->back();
        }

        toastify()->success('Upload ảnh thất bại!');
        return redirect()->back();
    }

    // Hàm cập nhật dữ liệu vào database
    public function updateProfile(Request $request) 
    {
        // Xác thực dữ liệu
        // $request->validate([
        //     'HoDem' => 'required|string|max:255',
        //     'Ten' => 'required|string|max:255',
        //     'TenKhac' => 'required|string|max:255',
        //     'GioiTinh' => 'required|string|max:10',
        //     'DanToc_ID' => 'required|exists:danhsachdantoc,id', // kiểm tra tồn tại trong bảng dân tộc
        //     'NgaySinh' => 'required|date',
        //     'CCCD' => 'required|string|max:20',
        //     'NoiCapCCCD' => 'required|string|max:255',
        //     'NgayCapCCCD' => 'required|date',
        //     'SoDienThoai' => 'required|string|max:20',
        //     'Email' => 'required|email|max:255',
        //     'DiaChi' => 'required|string|max:255',
        // ]);

        // Lấy giảng viên hiện tại
        $user = Auth::user();
        $maGV = $user->MaGV;
        $info = User::with('tb_nganh', 'dantoc')->find($maGV);
        // dd($info);

        // Cập nhật thông tin giảng viên
        $info->update([
            'HoDem' => $request->input('HoDem', $info->HoDem),
            'Ten' => $request->input('Ten', $info->Ten),
            'TenKhac' => $request->input('TenKhac', $info->TenKhac),
            'DanToc_ID' => $request->input('DanToc_ID', $info->DanToc_ID), // Cập nhật ID của dân tộc
            'GioiTinh' => $request->input('GioiTinh', $info->GioiTinh),
            'NgaySinh' => $request->input('NgaySinh', $info->NgaySinh),
            'CCCD' => $request->input('CCCD', $info->CCCD),
            'Email' => $request->input('Email', $info->Email),
            'SDT' => $request->input('SDT', $info->SDT),
            'DiaChiThuongChu' => $request->input('DiaChiThuongChu', $info->DiaChiThuongChu),
            'ChoOHienNay' => $request->input('ChoOHienNay', $info->ChoOHienNay),
            'NoiSinh' => $request->input('NoiSinh', $info->NoiSinh),
            'QueQuan' => $request->input('QueQuan', $info->QueQuan),
            'NoiCapCCCD' => $request->input('NoiCapCCCD', $info->NoiCapCCCD),
            'NgayCapCCCD' => $request->input('NgayCapCCCD', $info->NgayCapCCCD),
            'SoBHXH' => $request->input('SoBHXH', $info->SoBHXH),
            'KinhNghiemLV' => $request->input('KinhNghiemLV', $info->KinhNghiemLV),
            'NgayTuyenDung' => $request->input('NgayTuyenDung', $info->NgayTuyenDung),
            'TenNganHang' => $request->input('TenNganHang', $info->TenNganHang),
            'SoTaiKhoanNganHang' => $request->input('SoTaiKhoanNganHang', $info->SoTaiKhoanNganHang),
        ]);

        // Hiển thị dữ liệu
        // dd($info);
        // dd($request->all());
        // Redirect, trả về thông báo thành công
        toastify()->success('Cập nhật thành công');
        return redirect()->route('profilegiangvien');
    }

}