@extends('admin.layouts.app')

@section('title', 'Edit Pengumuman')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.information.index') }}">Pengumuman</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Pengumuman</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.information.update', $data->id) }}" method="POST" enctype="multipart/form-data"
                class="card">
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
                                <label for="title" class="form-label">Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Masukkan Judul" value="{{ old('title', $data->title) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status Publikasi <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach (getPusblishStatusList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('status', $data->status) == $k ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="thumbnail" class="form-label">Thumbnail (<a href="{{ $data->thumbnail }}" target="_blank">Lihat <i
                                            class="ti ti-eye"></i></a>)</label>
                                <input type="file" accept="image/*" name="thumbnail" id="thumbnail" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="content" class="form-label">Konten <span class="text-danger">*</span></label>
                                <textarea name="content" id="content" class="form-control" placeholder="Masukkan Konten" required>{{ old('content', $data->content) }}</textarea>
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
