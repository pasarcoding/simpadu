@extends('admin.layouts.app')

@section('title', 'Import Data Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.resident.index') }}">Data Penduduk</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Import Data Penduduk</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.resident.store-import') }}" method="POST" enctype="multipart/form-data"
                class="card">
                @csrf
                <div class="card-header d-flex justify-content-end">
                    <a href="{{ route('admin.resident.export-template') }}" class="btn btn-sm btn-warning text-nowrap">Template <i class="ti ti-file-download"></i></a>
                </div>
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
                                <label for="file" class="form-label">Excel Penduduk <span
                                        class="text-danger">*</span></label>
                                <input type="file"
                                    accept=".xlsx, .xls, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                    name="file" id="file" class="form-control" required>
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
