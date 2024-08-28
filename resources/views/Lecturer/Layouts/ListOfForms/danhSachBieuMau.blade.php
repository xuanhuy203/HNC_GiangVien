@extends('Lecturer.DefaultLayout.main')

@section('content')
    <div class="grid container" id="scrollContainer">
        <div class="row">
            <div class="col l-12">
                <h3 style="text-align: center; text-transform: uppercase">{{ $title }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col l-12">
                <div class="animate__animated animate__fadeInUp flex justify-center" id="form-list">
                    <table class="table table--primary">
                        <thead class="table__heading heading--primary">
                            <tr>
                                <th style="color: #000">Tên biểu mẫu</th>
                                <th style="color: #000">File</th>
                                <th style="color: #000">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $item)
                                <tr class="table__row">
                                    <td>{{ $item->TenBieuMau }}</td>

                                    <td>
                                        <form action="{{ route('files.upload', ['id' => $item->id]) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <input type="file" name="file" required>

                                            <button type="submit" class="btn btn--primary form-table__btn">
                                                Lưu
                                            </button>
                                        </form>
                                    </td>

                                    <td class="flex justify-center content-center">
                                        <form action="{{ route('files.download', ['id' => $item->id]) }}" method="GET">
                                            @csrf

                                            <button class="btn btn--primary form-table__btn">Download</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
