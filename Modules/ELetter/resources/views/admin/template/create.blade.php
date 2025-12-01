@extends('admin.layouts.app')

@section('title', 'Tambah Template Surat')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.e-letter.template.index') }}">Template Surat</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Template Surat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.e-letter.template.store') }}" method="POST" enctype="multipart/form-data"
                class="card">
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
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Surat <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama Surat" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="last_sequence_number" class="form-label">Nomor Surat Terkahir <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="last_sequence_number" id="last_sequence_number"
                                    class="form-control" placeholder="Masukkan Nomor Surat Terakhir"
                                    value="{{ old('last_sequence_number') }}" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="file" class="form-label">File Template (docx) <span
                                        class="text-danger">*</span></label>
                                <input type="file"
                                    accept=".doc, .docx, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                    name="file" id="file" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach (getTemplateStatusList() as $k => $v)
                                        <option value="{{ $k }}" {{ old('status') == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
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
