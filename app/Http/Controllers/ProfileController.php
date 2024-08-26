<?php
// app/Http/Controllers/LecturerController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nganh;
use App\Helper\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\UserServices;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\UploadServices;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


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
            'danhsachDanToc' => $danhsachDanToc,

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
        $validator = Validator::make($request->all(), [
            'NgaySinh' => 'date', 
            'CCCD' => 'digits:12|string',
            'Email' => 'email|max:255',
            'SDT' => 'regex:/^\d{10,11}$/',
        ]);

         // Kiểm tra xem dữ liệu có hợp lệ không
        if ($validator->fails()) {
            toastify()->error('Có lỗi xảy ra xin vui lòng kiểm tra lại!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
            'DanToc_ID' => $request->input('DanToc_ID', $info->DanToc_ID),
            'GioiTinh' => $request->input('GioiTinh', $info->GioiTinh),
            'NgaySinh' => $request->input('NgaySinh', $info->NgaySinh),
            'CCCD' => $request->input('CCCD', $info->CCCD),
            'NoiCapCCCD' => $request->input('NoiCapCCCD', $info->NoiCapCCCD),
            'NgayCapCCCD' => $request->input('NgayCapCCCD', $info->NgayCapCCCD),
            'SDT' => $request->input('SDT', $info->SDT),
            'Email' => $request->input('Email', $info->Email),
            'NoiSinh' => $request->input('NoiSinh', $info->NoiSinh),
            'QueQuan' => $request->input('QueQuan', $info->QueQuan),
            'DiaChiThuongChu' => $request->input('DiaChiThuongChu', $info->DiaChiThuongChu),
            'ChoOHienNay' => $request->input('ChoOHienNay', $info->ChoOHienNay),
            'SoBHXH' => $request->input('SoBHXH', $info->SoBHXH),
            'NgayTuyenDung' => $request->input('NgayTuyenDung', $info->NgayTuyenDung),
            'TenNganHang' => $request->input('TenNganHang', $info->TenNganHang),
            'SoTaiKhoanNganHang' => $request->input('SoTaiKhoanNganHang', $info->SoTaiKhoanNganHang),
            'TrinhDo' => $request->input('TrinhDo', $info->TrinhDo),
            'TrinhDoGiaoDucPhoThong' => $request->input('TrinhDoGiaoDucPhoThong', $info->TrinhDoGiaoDucPhoThong),
            'TrinhDoNgoaiNgu' => $request->input('TrinhDoNgoaiNgu', $info->TrinhDoNgoaiNgu),
            'ChungChiKyNangNghe' => $request->input('ChungChiKyNangNghe', $info->ChungChiKyNangNghe),
            'ChuyenNganhHoc' => $request->input('ChuyenNganhHoc', $info->ChuyenNganhHoc),
            'CoSoDaoTao' => $request->input('CoSoDaoTao', $info->CoSoDaoTao),
            'Nganh_ID' => $request->input('Nganh_ID', $info->Nganh_ID),
            'ChungChiNghiepVuSuPham' => $request->input('ChungChiNghiepVuSuPham', $info->ChungChiNghiepVuSuPham),
            'KinhNghiemLamViec' => $request->input('KinhNghiemLamViec', $info->KinhNghiemLamViec),
        ]);

        // Hiển thị dữ liệu
        // dd($info);
        // dd($request->all());
        // Redirect, trả về thông báo thành công
        toastify()->success('Cập nhật thành công');
        return redirect()->route('profilegiangvien');
    }
}