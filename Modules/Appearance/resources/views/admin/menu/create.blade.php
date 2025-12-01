@extends('admin.layouts.app')

@section('title', 'Tambah Menu')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.appearance.menu.index') }}">Menu</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Menu</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.appearance.menu.store') }}" method="POST" class="card">
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
                                <label for="parent_id" class="form-label">Parent Menu <span class="text-danger">*</span></label>
                                <select name="parent_id" id="parent_id" class="form-control select2">
                                    @foreach ($menus as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('parent_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Menu <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama Menu" value="{{ old('name') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="page_origin" class="form-label">Asal Halaman <span class="text-danger">*</span></label>
                                <select name="page_origin" id="page_origin" class="form-control select2" required>
                                    @foreach (getPageOriginList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('page_origin') == $k ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="form-group">
                                <label for="appearance_page_id" class="form-label">Halaman <span class="text-danger">*</span></label>
                                <select name="appearance_page_id" id="appearance_page_id" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>Pilih Halaman</option>
                                    @foreach ($pages as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('appearance_page_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-8 d-none">
                            <div class="form-group">
                                <label for="url" class="form-label">Url <span class="text-danger">*</span></label>
                                <input type="url" name="url" id="url" class="form-control"
                                    placeholder="Masukkan Url" value="{{ old('url') }}" required>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="behaviour_target" class="form-label">Tingkah Url <span class="text-danger">*</span></label>
                                <select name="behaviour_target" id="behaviour_target" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Tingkah Url</option>
                                    @foreach (getAppearanceMenuBehaviourTargetList() as $k => $v)
                                        <option value="{{ $k }}"
                                            {{ old('behaviour_target') == $k ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="type" class="form-label">Posisi <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control select2" required>
                                    <option value="" disabled selected>Pilih Posisi</option>
                                    @foreach (getAppearanceMenuTypeList() as $k => $v)
                                        <option value="{{ $k }}" {{ old('type') == $k ? 'selected' : '' }}>
                                            {{ $v }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="order" class="form-label">Urutan <span class="text-danger">*</span></label>
                                <input type="text" name="order" id="order" class="form-control"
                                    placeholder="Masukkan Urutan" value="{{ old('order') }}" required>
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

@section('footer')
    <script>
        function toggleUrlPage() {
            const page_origin_val = $('select[name="page_origin"]').val();
            const appearance_page_id = $('select[name="appearance_page_id"]');
            const url = $('input[name="url"]');

            if (page_origin_val == 'in') {
                appearance_page_id.closest('.col-lg-8').removeClass('d-none');
                appearance_page_id.prop('required', true);
                url.closest('.col-lg-8').removeClass('d-none').addClass('d-none');
                url.prop('required', false);

                appearance_page_id.select2();
            } else if (page_origin_val == 'ex') {
                appearance_page_id.closest('.col-lg-8').removeClass('d-none').addClass('d-none');
                appearance_page_id.prop('required', false);
                url.closest('.col-lg-8').removeClass('d-none');
                url.prop('required', true);
            }

        }

        toggleUrlPage();
        $('select[name="page_origin"]').on('change', toggleUrlPage);
    </script>
@endsection
