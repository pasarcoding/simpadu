@extends('admin.layouts.app')

@section('title', 'Edit Sejarah')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.village-official.history.index') }}">Sejarah</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Sejarah</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.village-official.history.update') }}" method="POST" class="card">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="history" class="form-label">Sejarah Desa <span
                                        class="text-danger">*</span></label>
                                <textarea name="history" id="history" class="form-control" placeholder="Masukkan Sejarah Desa" required>{{ old('history', $data->history) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('history', {
            height: 400,
            filebrowserImageBrowseUrl: '/ckfilemanager?type=Images',
            filebrowserImageUploadUrl: '/ckfilemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/ckfilemanager?type=Files',
            filebrowserUploadUrl: '/ckfilemanager/upload?type=Files&_token='
        });
    </script>
@endsection
