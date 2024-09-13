@extends('Lecturer.DefaultLayout.main')
<link rel="stylesheet" href="{{ asset('asset/css/nhapdiemthanhphan.css') }}">

@section('content')
    <div class="grid">
        <div class="container" style="margin: 0 auto;">
            <div class="row">
                <div class="col l-12">
                    <h2 class="title">NHẬP ĐIỂM THÀNH PHẦN</h2>
                    <div style="text-align: center; margin-top: -22px;">
                        @if ($getComponentPoints)
                            <label class="title-label">Tên môn: {{ $getComponentPoints['diemThanhPhan']->TenMon }}</label>
                            <label class="title-label">- Lớp: {{ $getComponentPoints['diemThanhPhan']->TenLop }}</label>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row" style="padding: 40px 0;">
                <div class="col l-12">

                    <form action="{{ route('save.update') }}" method="POST">
                        @csrf
                        <table class="table">
                            <thead class="table_th" style="font-weight: 600">
                                <tr>
                                    <td rowspan="2">STT</td>
                                    <td rowspan="2">Mã sinh viên</td>
                                    <td rowspan="2">Họ và tên</td>
                                    <td rowspan="2">Ngày sinh</td>
                                    <td colspan="4">Điểm kiểm tra, điểm đánh giá thường xuyên</td>
                                    <td rowspan="2" style="width: 8%">Điểm thi</td>
                                    <td rowspan="2" style="width: 10%">Điểm TBCHP</td>
                                    <td rowspan="2" style="width: 20%">Ghi chú</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle; padding: 4px 10px; width: 8%">TX1</td>
                                    <td style="vertical-align: middle; padding: 4px 10px; width: 8%">ĐK1</td>
                                    <td style="vertical-align: middle; padding: 4px 10px; width: 8%">TX2</td>
                                    <td style="vertical-align: middle; padding: 4px 10px; width: 8%">ĐK2</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getComponentPoints['dataDiemThanhPhan'] as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->MaSV }}</td>
                                        <td>{{ $item->HoDem }} {{ $item->Ten }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->NgayThangNamSinh)->format('d/m/Y') }}</td>
                                        <td>
                                            {{-- Đoạn mã này tạo ra một input ẩn chứa mã số sinh viên (MaSV) và gửi nó cùng với các dữ liệu khác khi form được submit. 
                                            Điều này giúp biết được dữ liệu điểm số nào thuộc về sinh viên nào mà không cần phải hiển thị MaSV ra giao diện người dùng. --}}
                                            <input type="hidden" name="diem[{{ $index }}][MaSV]"
                                                value="{{ $item->MaSV }}">

                                            <input type="hidden" name="diem[{{ $index }}][MaMonHoc]"
                                                value="{{ $item->MaMonHoc }}">
                                            <input class="input" type="number" step="0.01" placeholder="Nhập DiemTX1"
                                                name="diem[{{ $index }}][DiemTX1]" value="{{ $item->DiemTX1 }}"
                                                onchange="calculateDiemTB({{ $index }})"
                                                id="DiemTX1_{{ $index }}" required>
                                        </td>

                                        <td>
                                            <input class="input" type="number" step="0.01" placeholder="Nhập Điểm"
                                                name="diem[{{ $index }}][DiemDK1]" value="{{ $item->DiemDK1 }}"
                                                onchange="calculateDiemTB({{ $index }})"
                                                id="DiemDK1_{{ $index }}" required>
                                        </td>

                                        <td>
                                            <input class="input" type="number" step="0.01" placeholder="Nhập Điểm"
                                                name="diem[{{ $index }}][DiemTX2]" value="{{ $item->DiemTX2 }}"
                                                onchange="calculateDiemTB({{ $index }})"
                                                id="DiemTX2_{{ $index }}" required>
                                        </td>

                                        <td>
                                            <input class="input" type="number" step="0.01" placeholder="Nhập Điểm"
                                                name="diem[{{ $index }}][DiemDK2]" value="{{ $item->DiemDK2 }}"
                                                onchange="calculateDiemTB({{ $index }})"
                                                id="DiemDK2_{{ $index }}" required>
                                        </td>

                                        <td>
                                            <input class="input" type="number" step="0.01" placeholder="Nhập Điểm"
                                                name="diem[{{ $index }}][DiemThi]" value="{{ $item->DiemThi }}"
                                                onchange="calculateDiemTB({{ $index }})"
                                                id="DiemThi_{{ $index }}" required>
                                        </td>

                                        <td>
                                            <input class="input" type="number" step="0.01"
                                                name="diem[{{ $index }}][DiemTB]" value="{{ $item->DiemTB }}"
                                                readonly id="DiemTB_{{ $index }}">
                                        </td>

                                        <td>
                                            <input class="input" type="text" placeholder="Ghi chú"
                                                name="diem[{{ $index }}][GhiChu]" value="{{ $item->GhiChu }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="flex justify-end content-center" style="margin-top:20px;">
                            <button class="btn btn--primary btn--search">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function calculateDiemTB(index) {
    // Lấy giá trị từ các ô nhập điểm
    let DiemTX1 = parseFloat(document.getElementById('DiemTX1_' + index).value) || null;
    let DiemDK1 = parseFloat(document.getElementById('DiemDK1_' + index).value) || null;
    let DiemTX2 = parseFloat(document.getElementById('DiemTX2_' + index).value) || null;
    let DiemDK2 = parseFloat(document.getElementById('DiemDK2_' + index).value) || null;
    let DiemThi = parseFloat(document.getElementById('DiemThi_' + index).value) || null;

    // Kiểm tra xem tất cả các giá trị đều không phải null
    if (DiemTX1 !== null && DiemDK1 !== null && DiemTX2 !== null && DiemDK2 !== null && DiemThi !== null) {
        // Tính điểm trung bình nếu tất cả các điểm đều đã được nhập
        let DiemTB = (((DiemTX1 + DiemTX2 + (DiemDK1 * 2) + (DiemDK2 * 2)) / 6) * 0.4) + (DiemThi * 0.6);
        document.getElementById('DiemTB_' + index).value = DiemTB.toFixed(2);
    } else {
        // Nếu có một hoặc nhiều ô điểm chưa được nhập, xóa giá trị điểm trung bình
        document.getElementById('DiemTB_' + index).value = '';
    }
}
</script>
