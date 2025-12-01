@extends('admin.layouts.app')

@section('title', 'Detail Data Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.resident.index') }}">Data Penduduk</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Detail Data Penduduk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="card-title mb-0">Informasi Lengkap Penduduk</h4>
                </div>
                <div class="card-body">

                    <h5 class="mb-3 text-primary"><i class="ti ti-user me-1"></i> Data Pribadi</h5>
                    <div class="row mb-4 border-bottom pb-3">
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">NIK</strong>
                            <p class="fs-5 mb-0">{{ $data->national_id }}</p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Nama Lengkap</strong>
                            <p class="fs-5 mb-0">{{ $data->full_name }}</p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Tempat, Tanggal Lahir</strong>
                            <p class="mb-0">{{ $data->birth_place }},
                                {{ \Carbon\Carbon::parse($data->birth_date)->isoFormat('D MMMM YYYY') }}</p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Jenis Kelamin</strong>
                            <p class="mb-0">{{ getGenderList()[$data->gender] ?? 'N/A' }}</p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Agama</strong>
                            <p class="mb-0">{{ getReligionList()[$data->religion] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Kewarganegaraan</strong>
                            <p class="mb-0">{{ getCitizenshipList()[$data->citizenship] ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <h5 class="mb-3 text-primary"><i class="ti ti-id me-1"></i> Data Kependudukan & Pekerjaan</h5>
                    <div class="row mb-4 border-bottom pb-3">
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">No. Kartu Keluarga (KK)</strong>
                            <p class="mb-0">{{ $data->family_card_number }}</p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Hubungan Keluarga</strong>
                            <p class="mb-0">{{ getFamilyRelationshipList()[$data->family_relationship] ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Status Pernikahan</strong>
                            <p class="mb-0">{{ getMaritalStatusList()[$data->marital_status] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Pekerjaan</strong>
                            <p class="mb-0">{{ getJobList()[$data->job] ?? 'N/A' }}</p>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Pendidikan Terakhir</strong>
                            <p class="mb-0">{{ getEducationList()[$data->last_education] ?? 'N/A' }}</p>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <strong class="text-muted d-block">Status Kematian</strong>
                            @php
                                $status = getDeathStatusList()[$data->death_status] ?? 'N/A';
                                $badgeClass = strtolower($data->death_status) == 'hidup' ? 'bg-success' : 'bg-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>

                            @if ($data->transfer_date)
                                <small class="d-block text-warning">Tanggal Pindah/Keluar:
                                    {{ \Carbon\Carbon::parse($data->transfer_date)->isoFormat('D MMMM YYYY') }}</small>
                            @endif
                        </div>
                    </div>

                    <h5 class="mb-3 text-primary"><i class="ti ti-map-pin me-1"></i> Data Alamat</h5>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-4 mb-3">
                            <strong class="text-muted d-block">Alamat Lengkap</strong>
                            <p class="mb-0">{{ $data->address }}</p>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <strong class="text-muted d-block">RT/RW</strong>
                            <p class="mb-0">{{ $data->rt }} / {{ $data->rw }}</p>
                        </div>
                        <div class="col-lg-4 col-md-4 mb-3">
                            <strong class="text-muted d-block">Dusun/Kelurahan</strong>
                            <p class="mb-0">{{ $data->hamlet_village ?? '-' }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
