@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.product.index') }}">Produk</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.product.update', $data->id) }}" method="POST" enctype="multipart/form-data"
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
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Produk <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama Produk" value="{{ old('name', $data->name) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="image" class="form-label">Gambar (<a href="{{ $data->image }}"
                                        target="_blank">Lihat <i class="ti ti-eye"></i></a>)</label>
                                <input type="file" accept="image/*" name="image" id="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="price" class="form-label">Harga <span class="text-danger">*</span></label>
                                <input type="text" name="price" id="price" class="form-control"
                                    placeholder="Masukkan Harga" value="{{ old('price', $data->price) }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="whatsapp_number" class="form-label">No. Whatsapp <span
                                        class="text-danger">*</span></label>
                                <input type="tel" name="whatsapp_number" id="whatsapp_number"
                                    pattern="^(\+62|0)8[0-9]{8,12}$" class="form-control" placeholder="Masukkan Harga"
                                    value="{{ old('whatsapp_number', $data->whatsapp_number) }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Deskripsi <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" placeholder="Masukkan Deskripsi" required>{{ old('description', $data->description) }}</textarea>
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
        CKEDITOR.replace('description', {
            height: 400,
            filebrowserImageBrowseUrl: '/ckfilemanager?type=Images',
            filebrowserImageUploadUrl: '/ckfilemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/ckfilemanager?type=Files',
            filebrowserUploadUrl: '/ckfilemanager/upload?type=Files&_token='
        });
    </script>
@endsection
