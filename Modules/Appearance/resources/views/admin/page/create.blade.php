@extends('admin.layouts.app')

@section('title', 'Tambah Halaman')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.appearance.page.index') }}">Halaman</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Halaman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.appearance.page.store') }}" method="POST" class="card">
                @csrf
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
                                <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Masukkan Judul" value="{{ old('title') }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                <textarea name="content" id="content" class="form-control" placeholder="Masukkan Konten" required>{{ old('content') }}</textarea>
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
        CKEDITOR.replace('content', {
            height: 400,
            filebrowserImageBrowseUrl: '/ckfilemanager?type=Images',
            filebrowserImageUploadUrl: '/ckfilemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/ckfilemanager?type=Files',
            filebrowserUploadUrl: '/ckfilemanager/upload?type=Files&_token='
        });
    </script>
@endsection
