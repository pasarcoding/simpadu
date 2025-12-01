@extends('admin.layouts.app')

@section('title', 'Tambah Data Penduduk')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.resident.index') }}">Data Penduduk</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Data Penduduk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.resident.store') }}" method="POST" enctype="multipart/form-data" class="card">
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

                    @if (session('import_errors'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Kesalahan Validasi Impor!</strong> Berikut adalah detail baris yang tidak valid:
                            <ul class="mt-2" style="max-height: 300px; overflow-y: auto;">
                                @foreach (session('import_errors') as $error)
                                    <li>{!! $error !!}</li> {{-- Gunakan {!! !!} karena ada tag **b** untuk bold --}}
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="national_id" class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="national_id" id="national_id" class="form-control"
                                    placeholder="Masukkan NIK" maxlength="16" minlength="16"
                                    value="{{ old('national_id') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="full_name" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                    placeholder="Masukkan Nama Lengkap" value="{{ old('full_name') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="gender" class="form-label">Jenis Kelamin <span
                                        class="text-danger">*</span></label>
                                <select name="gender" id="gender" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    {{-- Asumsi getGenderList() mengembalikan key/value yang valid --}}
                                    @foreach (getGenderList() as $k => $v)
                                        <option value="{{ $k }}" {{ old('gender') == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="birth_place" class="form-label">Tempat Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="birth_place" id="birth_place" class="form-control"
                                    placeholder="Masukkan Tempat Lahir"value="{{ old('birth_place') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">Tanggal Lahir <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="birth_date" id="birth_date" class="form-control"
                                    value="{{ old('birth_date') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="citizenship" class="form-label">Kewarganegaraan <span
                                        class="text-danger">*</span></label>
                                <select name="citizenship" id="citizenship" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Kewarganegaraan</option>
                                    @foreach (getCitizenshipList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('citizenship') == $k ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="image" class="form-label">Foto</label>
                                <input type="file" accept="image/*" name="image" id="image" class="form-control">
                            </div>
                        </div> --}}
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="religion" class="form-label">Agama <span class="text-danger">*</span></label>
                                <select name="religion" id="religion" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Agama</option>
                                    @foreach (getReligionList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('religion') == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="job" class="form-label">Pekerjaan <span
                                        class="text-danger">*</span></label>
                                <select name="job" id="job" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Pekerjaan</option>
                                    @foreach (getJobList() as $k => $v)
                                        <option value="{{ $k }}" {{ old('job') == $k ? 'selected' : '' }}>
                                            {{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="other_job" class="form-label">Pekerjaan Lainnya</label>
                                <input type="text" name="other_job" id="other_job" class="form-control"
                                    value="{{ old('other_job') }}" placeholder="Masukkan Pekerjaan Lainnya">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="last_education" class="form-label">Pendidikan Terakhir <span
                                        class="text-danger">*</span></label>
                                <select name="last_education" id="last_education" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Pendidikan Terakhir</option>
                                    @foreach (getEducationList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('last_education') == $k ? 'selected' : '' }}>{{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="marital_status" class="form-label">Status Pernikahan <span
                                        class="text-danger">*</span></label>
                                <select name="marital_status" id="marital_status" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Status Pernikahan</option>
                                    @foreach (getMaritalStatusList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('marital_status') == $k ? 'selected' : '' }}>{{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="family_relationship" class="form-label">Hubungan Keluarga <span
                                        class="text-danger">*</span></label>
                                <select name="family_relationship" id="family_relationship" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>Pilih Hubungan Keluarga</option>
                                    @foreach (getFamilyRelationshipList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('family_relationship') == $k ? 'selected' : '' }}>{{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="family_card_number" class="form-label">Nomor Kartu Keluarga <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="family_card_number" id="family_card_number"
                                    class="form-control" placeholder="Masukkan No. KK"
                                    value="{{ old('family_card_number') }}" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address" class="form-label">Alamat Lengkap <span
                                        class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control" placeholder="Masukkan Alamat Lengkap" required>{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="form-group">
                                <label for="rt" class="form-label">RT <span class="text-danger">*</span></label>
                                <input type="text" name="rt" id="rt" class="form-control"
                                    placeholder="RT" value="{{ old('rt') }}" required>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="form-group">
                                <label for="rw" class="form-label">RW <span class="text-danger">*</span></label>
                                <input type="text" name="rw" id="rw" class="form-control"
                                    placeholder="RW" value="{{ old('rw') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="hamlet_village" class="form-label">Dusun/Kelurahan</label>
                                <input type="text" name="hamlet_village" id="hamlet_village" class="form-control"
                                    placeholder="Masukkan Dusun/Kelurahan (Opsional)"
                                    value="{{ old('hamlet_village') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="death_status" class="form-label">Status Kematian <span
                                        class="text-danger">*</span></label>
                                <select name="death_status" id="death_status" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Status Kematian</option>
                                    @foreach (getDeathStatusList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('death_status') == $k ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="transfer_date" class="form-label">Tanggal Pindah/Keluar (Opsional)</label>
                                <input type="date" name="transfer_date" id="transfer_date" class="form-control"
                                    value="{{ old('transfer_date') }}">
                            </div>
                        </div>
                    </div>
                    @if (!empty($forms))
                        <div class="d-flex align-items-center gap-2">
                            <hr class="flex-grow-1">
                            <span class="flex-shrink-0 fs-5">Form Tambahan</span>
                            <hr class="flex-grow-1">
                        </div>
                        <div class="row">
                            @foreach ($forms as $i => $item)
                                @if ($loop->last && count($forms) % 2 !== 0)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="resident_forms[{{ $item->id }}]"
                                                class="form-label">{{ $item->name }}</label>
                                            <input type="text" name="resident_forms[{{ $item->id }}]"
                                                id="resident_forms[{{ $item->id }}]" class="form-control"
                                                placeholder="Masukkan {{ $item->name }}"
                                                value="{{ old('resident_forms.' . $item->id) }}">
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="resident_forms[{{ $item->id }}]"
                                                class="form-label">{{ $item->name }}</label>
                                            <input type="text" name="resident_forms[{{ $item->id }}]"
                                                id="resident_forms[{{ $item->id }}]" class="form-control"
                                                placeholder="Masukkan {{ $item->name }}"
                                                value="{{ old('resident_forms.' . $item->id) }}">
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        const job = $('select[name="job"]');
        const otherJob = $('input[name="other_job"]');

        function toggleOtherJobInput() {
            console.log(job.val());
            if (job.val() === 'lainnya') {
                otherJob.prop('readonly', false);
                otherJob.focus();
            } else {
                otherJob.prop('readonly', true);
            }
        }

        toggleOtherJobInput();
        job.change(toggleOtherJobInput);
    </script>
@endsection
