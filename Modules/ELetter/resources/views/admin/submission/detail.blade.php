@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('header')
    <style>
        .footer-form-update {
            width: 100%;
        }

        @media screen and (min-width: 768px) {
            .footer-form-update {
                width: 100%;
            }
        }

        @media screen and (min-width: 1024px) {
            .footer-form-update {
                width: 50%;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.e-letter.submission.index') }}">Pengajuan Surat</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Detail Pengajuan Pengajuan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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

                    <h5 class="mb-3 text-primary"><i class="ti ti-file-text me-1"></i> Informasi Surat</h5>
                    <div class="row mb-4 border-bottom pb-3">

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Nomor Surat</strong>
                            <p class="fs-5 mb-0 text-success">{{ $data->letter_number }}</p>
                        </div>

                        @php
                            $statusColor = [
                                'submitted' => 'info',
                                'verification' => 'warning',
                                'signed' => 'primary',
                                'completed' => 'success',
                                'rejected' => 'danger',
                            ];
                        @endphp
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Status Pengajuan</strong>
                            <p class="mb-0">
                                <span
                                    class="badge bg-{{ $statusColor[$data->status] }} fs-6">{{ getSubmissionStatusList()[$data->status] }}</span>
                            </p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Jenis Surat</strong>
                            <p class="mb-0">{{ $data->e_letter_template->name }}</p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Nama Penduduk</strong>
                            @if ($data->resident)
                                <p class="mb-0">{{ $data->resident->full_name }}</p>
                            @else
                                <i class="text-danger">Bukan Penduduk</i>
                            @endif
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">NIK</strong>
                            <p class="mb-0">{{ $data->national_id }}</p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">No. WhatsApp</strong>
                            <p class="mb-0">{{ $data->whatsapp_number }}</p>
                        </div>

                    </div>

                    <h5 class="mb-3 text-primary"><i class="ti ti-list-details me-1"></i> Data Formulir</h5>
                    <div class="row mb-4">
                        @php
                            $formValues = json_decode($data->list_variable_with_values);
                        @endphp

                        @if ($formValues)
                            @foreach ($formValues as $item)
                                @php
                                    $value = $item->value ?? '-';
                                    $label = $item->label ?? $item->name;
                                @endphp

                                <div class="col-lg-6 col-md-12 mb-3">
                                    <strong class="text-muted d-block">{{ $label }}</strong>

                                    @if (isset($item->format) && $item->format == 'image')
                                        <img src="{{ Storage::url($value) }}" alt="File {{ $label }}"
                                            class="img-fluid rounded" style="max-height: 150px;">
                                    @else
                                        <p class="mb-0">{{ $value }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-muted">Tidak ada data formulir yang tersimpan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
