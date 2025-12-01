@extends('user.layouts.app')

@section('title', 'Pengajuan Surat')

@section('header')
    <style>
        .form-control {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }
    </style>
@endsection

@section('content')
    <section style="margin: 2rem 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4 d-none d-lg-block">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="fs-5 fw-semibold mb-2">Informasi</span>
                                                <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($topInformations as $item)
                                            <div class="d-flex align-items-start mb-3">
                                                <img src="{{ $item->thumbnail }}" alt=""
                                                    class="object-fit-cover rounded-2 border me-2"
                                                    style="width: 5rem; aspect-ratio: 9/6;">
                                                <a href="" class="d-block text-decoration-none text-dark flex-grow-1"
                                                    style="min-width: 0;">
                                                    <div class="fw-semibold text-truncate w-100" style="font-size: 0.9rem;">
                                                        {{ $item->title }}</div>
                                                    <div class="text-truncate-2" style="font-size: 0.6rem;">
                                                        {{ strip_tags($item->content) }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card shadow shadow-sm rounded-4">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <span class="fs-5 fw-semibold mb-2">Berita</span>
                                                <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 30px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach ($topNews as $item)
                                            <div class="d-flex align-items-start mb-3">
                                                <img src="{{ $item->thumbnail }}" alt=""
                                                    class="object-fit-cover rounded-2 border me-2"
                                                    style="width: 5rem; aspect-ratio: 9/6;">
                                                <a href="" class="d-block text-decoration-none text-dark flex-grow-1"
                                                    style="min-width: 0;">
                                                    <div class="fw-semibold text-truncate w-100" style="font-size: 0.9rem;">
                                                        {{ $item->title }}</div>
                                                    <div class="text-truncate-2" style="font-size: 0.6rem;">
                                                        {{ strip_tags($item->content) }}</div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('user.e-letter.store') }}" method="POST" enctype="multipart/form-data"
                    class="col-12 col-lg-8">
                    @csrf
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-4 pb-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fs-4 fw-semibold mb-2">Form Pengajuan Surat</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Gagal!</strong> {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
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
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Berhasil!</strong> {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label for="e_letter_template_id" class="mb-1" style="font-size: 1.1rem;">Jenis Surat
                                        <span class="text-danger">*</span></label>
                                    <select name="e_letter_template_id" id="e_letter_template_id" class="form-control"
                                        required>
                                        <option value="" selected disabled>Pilih Jenis Surat</option>
                                        @foreach ($eLetters as $item)
                                            <option value="{{ $item->id }}" data-form="{{ $item->list_variables }}"
                                                {{ old('e_letter_template_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label for="whatsapp_number" class="mb-1" style="font-size: 1.1rem;">No. Whatsapp
                                        <span class="text-danger">*</span></label>
                                    <input type="tel" name="whatsapp_number" id="whatsapp_number"
                                        pattern="^(\+62|0)8[0-9]{8,12}$" class="form-control"
                                        placeholder="Masukkan No. Whatsapp" value="{{ old('whatsapp_number') }}"
                                        required>
                                </div>
                                <div class="col-12 form-group mb-3">
                                    <label for="national_id" class="mb-1" style="font-size: 1.1rem;">NIK
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="national_id" id="national_id" class="form-control"
                                            placeholder="Masukkan NIK" value="{{ old('national_id') }}" required>
                                        <button type="button" class="btn btn-app-secondary bg-app-secondary text-white"
                                            id="btn-resident-search">Isi Surat Otomatis</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="form-template">
                                @if (old('form'))
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    @foreach (json_decode($eLetters->firstWhere('id', old('e_letter_template_id'))->list_variables) as $item)
                                        @switch($item->format)
                                            @case('text')
                                                <div class="col-12 form-group mb-3">
                                                    <label for="" class="mb-1"
                                                        style="font-size: 1.1rem;">{{ $item->label }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="form[{{ $item->name }}]" id=""
                                                        class="form-control" placeholder="Masukkan {{ $item->label }}"
                                                        value="{{ old('form.' . $item->name) }}" required>
                                                </div>
                                            @break

                                            @case('image')
                                                <div class="col-12 form-group mb-3">
                                                    <label for="" class="mb-1"
                                                        style="font-size: 1.1rem;">{{ $item->label }}
                                                        <span class="text-danger">*</span></label>
                                                    <input type="file" accept="image/*" name="form[{{ $item->name }}]"
                                                        id="" class="form-control" required>
                                                </div>
                                            @break
                                        @endswitch
                                    @endforeach
                                    <div class="form-group text-end">
                                        <input type="submit" name="" id=""
                                            class="btn bg-app-secondary text-white px-4 py-2" value="Ajukan">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $('#e_letter_template_id').change(function() {
                const data = $(this).find('option:selected').data('form');
                $('#form-template').html('');

                $.each(data, (index, val) => {
                    let form = '';

                    if (index == 0) {
                        $('#form-template').append(`<div class="col-12">
                                    <hr>
                                </div>`);
                    }

                    switch (val.format) {
                        case 'text':
                            form = `<div class="col-12 form-group mb-3">
                                    <label for="" class="mb-1" style="font-size: 1.1rem;">${val.label} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="form[${val.name}]" id="" class="form-control"
                                        placeholder="Masukkan ${val.label}" required>
                                </div>`;
                            break;
                        case 'image':
                            form = `<div class="col-12 form-group mb-3">
                                    <label for="" class="mb-1" style="font-size: 1.1rem;">${val.label} <span
                                            class="text-danger">*</span></label>
                                    <input type="file" accept="image/*" name="form[${val.name}]" id="" class="form-control" required>
                                </div>`;
                            break;
                    };

                    $('#form-template').append(form);

                    if (index == data.length - 1) {
                        $('#form-template').append(`<div class="form-group text-end">
                                        <input type="submit" name="" id=""
                                            class="btn bg-app-secondary text-white px-4 py-2" value="Ajukan">
                                    </div>`);
                    }
                })
            });

            $('#btn-resident-search').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('user.e-letter.resident_by_national_id') }}",
                    method: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        e_letter_template_id: $('select[name="e_letter_template_id"]').val(),
                        national_id: $('input[name="national_id"]').val(),
                    },
                    dataType: 'json',
                    success: function(res) {
                        $.each(res.data, (key, val) => {
                            $(`input[name="form[${key}]"]`).val(val);
                        });
                    },
                    error: function(err) {
                        alert(err.responseJSON.message)
                    }
                });
            });
        });
    </script>
@endsection
