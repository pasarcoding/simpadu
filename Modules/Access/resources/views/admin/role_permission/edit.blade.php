@extends('admin.layouts.app')

@section('title', 'Edit Peran & Hak Akses')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.access.role-permission.index') }}">Peran & Hak Akses</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Peran & Hak Akses</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.access.role-permission.update', $data->id) }}" method="POST" class="card">
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
                                <label for="name" class="form-label">Nama Peran <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama Peran" value="{{ old('name', $data->name) }}" required>
                            </div>
                        </div>
                        <hr>
                        @foreach ($permissions as $moduleName => $permissionData)
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="form-group permission-group">
                                    <label class="text-danger fw-bold form-label">{{ getPermissionInfo($moduleName)['name'] }}</label>
                                    @foreach ($permissionData as $k => $v)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" name="permissions[]" id="{{ $k }}"
                                                class="form-check-input {{ getPermissionInfo($moduleName)['main'] == $k ? 'permission-main' : '' }}"
                                                value="{{ $k }}"
                                                {{ in_array($k, $rolePermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $k }}">{{ $v }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection
