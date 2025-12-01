@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.access.user.index') }}">Pengguna</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Pengguna</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.access.user.update', $data->id) }}" method="POST" class="card">
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

                        @if ($data->id != 1)
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="role" class="form-label">Peran Pengguna <span
                                            class="text-danger">*</span></label>
                                    <select name="role" id="role" class="form-control select2" required>
                                        <option value="" disabled selected>Pilih Peran Pengguna</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->name }}"
                                                {{ old('role', $data->getRoleNames()->first()) == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
