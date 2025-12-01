@extends('admin.layouts.app')

@section('title', 'Edit Anggota')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.village-official.member.index') }}">Anggota</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Anggota</li>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <form action="{{ route('admin.village-official.member.update', $data->id) }}" method="POST"
                enctype="multipart/form-data" class="card">
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
                                <label for="resident_id" class="form-label">Penduduk <span
                                        class="text-danger">*</span></label>
                                <select name="resident_id" id="resident_id" class="form-control select2"
                                    style="width: 100%;" required>
                                    <option value="" disabled selected>Pilih Penduduk</option>
                                    @foreach ($residents as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('resident_id', $data->resident_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->full_name }}({{ $item->national_id }}) |
                                            {{ $item->hamlet_village }}({{ $item->rt }}/{{ $item->rw }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="position" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="position" id="position" class="form-control"
                                    placeholder="Masukkan Jabatan" value="{{ old('position', $data->position) }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="image" class="form-label">Foto (<a href="{{ $data->image }}"
                                        target="_blank">Lihat <i class="ti ti-eye"></i></a>)</label>
                                <input type="file" accept="image/*" name="image" id="image" class="form-control">
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
