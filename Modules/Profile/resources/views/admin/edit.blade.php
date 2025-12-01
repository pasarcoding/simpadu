@extends('admin.layouts.app')

@section('title', 'Edit Profile')

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Edit Profile</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.profile.update', $data->id) }}" method="POST" class="card">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

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
                                <label for="name" class="form-label">Nama Pengguna <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama Pengguna" value="{{ old('name', $data->name) }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Masukkan Email" value="{{ old('email', $data->email) }}" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" name="password" id="password" class="form-control"
                                    placeholder="Masukkan Password" value="{{ old('password') }}">
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
