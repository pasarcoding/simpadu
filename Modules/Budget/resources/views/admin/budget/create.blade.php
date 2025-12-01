@extends('admin.layouts.app')

@section('title', 'Tambah Anggaran')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.budget.index') }}">Transparasi Anggaran</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Anggaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.budget.store') }}" method="POST" class="card">
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
                                <label for="title" class="form-label">Nama Anggaran <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control"
                                    placeholder="Masukkan Nama Anggaran" value="{{ old('title') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="account_name" class="form-label">Nama Akun Bank <span class="text-danger">*</span></label>
                                <input type="text" name="account_name" id="account_name" class="form-control"
                                    placeholder="Masukkan Nama Akun Bank" value="{{ old('account_name') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="bank_name" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                                <select name="bank_name" id="bank_name" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Bank</option>
                                    @foreach (getBankList() as $k => $v)
                                        <option value="{{ $k }}" {{ old('bank_name') == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="bank_number" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" name="bank_number" id="bank_number" class="form-control"
                                    placeholder="Masukkan Nomor Rekening" value="{{ old('bank_number') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="type" class="form-label">Tipe Tampilan <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Tipe Tampilan</option>
                                    @foreach (getBudgetTypeList() as $k => $v)
                                        <option value="{{ $k }}" {{ old('type') == $k ? 'selected' : '' }}>
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
