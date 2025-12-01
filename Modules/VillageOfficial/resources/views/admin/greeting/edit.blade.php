@extends('admin.layouts.app')

@section('title', 'Edit Sambutan')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.village-official.greeting.index') }}">Sambutan</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Sambutan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.village-official.greeting.update') }}" method="POST" enctype="multipart/form-data"
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
                                <label for="name" class="form-label">Nama Pemimpin <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama Pemimpin" value="{{ old('name', $data->name) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                @if (!$data->exists())
                                    <label for="image" class="form-label">Foto Pemimpin <span class="text-danger">*</span></label>
                                @else
                                    <label for="image" class="form-label">Foto Pemimpin (<a href="{{ $data->image }}" target="_blank">Lihat
                                            <i class="ti ti-eye"></i></a>)</label>
                                @endif
                                <input type="file" accept="image/*" name="image" id="image" class="form-control"
                                    {{ !$data->exists() ? 'required' : '' }}>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                @if (!$data->exists())
                                    <label for="sign_image" class="form-label">Gambar Tanda Tangan <span class="text-danger">*</span></label>
                                @else
                                    <label for="sign_image" class="form-label">Gambar Tanda Tangan (<a href="{{ $data->sign_image }}"
                                            target="_blank">Lihat <i class="ti ti-eye"></i></a>)</label>
                                @endif
                                <input type="file" accept="image/*" name="sign_image" id="sign_image"
                                    class="form-control" {{ !$data->exists() ? 'required' : '' }}>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="content" class="form-label">Konten Sambutan <span class="text-danger">*</span></label>
                                <textarea name="content" id="content" class="form-control" placeholder="Masukkan Konten Sambutan" required>{{ old('content', $data->content) }}</textarea>
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
