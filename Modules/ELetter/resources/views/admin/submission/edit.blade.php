@extends('admin.layouts.app')

@section('title', 'Edit Pengajuan Surat')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.e-letter.submission.index') }}">Pengajuan Surat</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Edit Pengajuan Surat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.e-letter.submission.update', $data->id) }}" method="POST"
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
                        @foreach (json_decode($data->e_letter_template->list_variables) as $item)
                            @php
                                $listVariableWithValue = collect(
                                    json_decode($data->list_variable_with_values),
                                )->firstWhere('name', $item->name);
                            @endphp

                            @if ($item->format == 'text')
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="form[{{ $item->name }}]" class="form-label">{{ $item->label }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="form[{{ $item->name }}]" id="form[{{ $item->name }}]"
                                            class="form-control" placeholder="Masukkan {{ $item->label }}"
                                            value="{{ old('form.' . $item->name, $listVariableWithValue->value ?? '') }}" required>
                                    </div>
                                </div>
                            @else
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="form[{{ $item->name }}]" class="form-label">{{ $item->label }}
                                            @if ($listVariableWithValue->value ?? null)
                                                (<a href="{{ Storage::disk('public')->url($listVariableWithValue->value) }}"
                                                    target="_blank">Lihat <i class="ti ti-eye"></i></a>)
                                            @else
                                                <span class="text-danger">*</span>
                                            @endif
                                        </label>
                                        <input type="file" accept="image/*" name="form[{{ $item->name }}]" id="form[{{ $item->name }}]"
                                            class="form-control" {{ !($listVariableWithValue->value ?? null) ? 'required' : '' }}>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control select2 w-100">
                                    @foreach (getSubmissionStatusList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('status', $data->status) == $k ? 'selected' : '' }}>{{ $v }}
                                        </option>
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
