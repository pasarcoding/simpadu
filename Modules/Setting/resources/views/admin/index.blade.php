@extends('admin.layouts.app')

@section('title', 'Pengaturan')

@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
    <style>
        .clr-field {
            width: 100% !important;
        }

        .clr-field button[type="button"] {
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">
        Pengaturan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.setting.app') }}" method="POST" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-header py-3">
                    <h4 class="mb-0">Aplikasi</h4>
                </div>
                <div class="card-body">
                    @if (session('app_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('app_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('app_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('app_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->app->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                            <ul>
                                @foreach ($errors->app->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan Nama" value="{{ old('name', $setting_app['name'] ?? '') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="logo" class="form-label">Logo
                                    @if (isset($setting_app['logo']))
                                        (<a href="{{ Storage::disk('public')->url($setting_app['logo']) }}"
                                            target="_blank">Lihat <i class="ti ti-eye"></i></a>)
                                    @endif
                                </label>
                                <input type="file" accept="image/*" name="logo" id="logo" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description" class="form-label">Deskripsi <span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" style="height: 10rem;"
                                    placeholder="Masukkan Deksripsi" required>{{ old('description', $setting_app['description'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
        <div class="col-12">
            <form action="{{ route('admin.setting.appearance') }}" method="POST" enctype="multipart/form-data"
                class="card">
                @csrf
                <div class="card-header py-3">
                    <h4 class="mb-0">Tampilan</h4>
                </div>
                <div class="card-body">
                    @if (session('appearance_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('appearance_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('appearance_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('appearance_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->appearance->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                            <ul>
                                @foreach ($errors->appearance->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="background_banner" class="form-label">Banner Background
                                    @if ($setting_appearance['background_banner'] ?? null)
                                        (<a href="{{ Storage::disk('public')->url($setting_appearance['background_banner']) }}"
                                            target="_blank">Lihat <i class="ti ti-eye"></i></a>)
                                    @endif
                                </label>
                                <input type="file" accept="image/*" name="background_banner" id="background_banner"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="color_primary" class="form-label d-block">Color Primary <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="color_primary" id="color_primary" class="form-control"
                                    placeholder="Masukkan Color Accent"
                                    value="{{ old('color_primary', $setting_appearance['color_primary'] ?? '') }}"
                                    data-coloris required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="color_secondary" class="form-label d-block">Color Secondary <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="color_secondary" id="color_secondary" class="form-control"
                                    placeholder="Masukkan Color Secondary"
                                    value="{{ old('color_secondary', $setting_appearance['color_secondary'] ?? '') }}"
                                    data-coloris required>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                <label for="color_accent" class="form-label d-block">Color Accent <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="color_accent" id="color_accent" class="form-control"
                                    placeholder="Masukkan Color Accent"
                                    value="{{ old('color_accent', $setting_appearance['color_accent'] ?? '') }}"
                                    data-coloris required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
        <div class="col-12">
            <form action="{{ route('admin.setting.contact') }}" method="POST" class="card">
                @csrf
                <div class="card-header py-3">
                    <h4 class="mb-0">Kontak</h4>
                </div>
                <div class="card-body">
                    @if (session('contact_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('contact_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('contact_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('contact_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->contact->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                            <ul>
                                @foreach ($errors->contact->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="maps" class="form-label">Maps (<a href="https://map-embed.org/"
                                        target="_blank">Generate Maps</a>)</label>
                                <input type="text" name="maps" id="maps" class="form-control"
                                    placeholder="Masukkan Url Maps"
                                    value="{{ old('maps', $setting_contact['maps'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address" id="address" class="form-control"
                                    placeholder="Masukkan Alamat"
                                    value="{{ old('address', $setting_contact['address'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Masukkan Email"
                                    value="{{ old('email', $setting_contact['email'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="whatsapp" class="form-label">Whatsapp</label>
                                <input type="tel" name="whatsapp" id="whatsapp" pattern="^(\+62|0)8[0-9]{8,12}$"
                                    class="form-control" placeholder="Masukkan Whatsapp"
                                    value="{{ old('whatsapp', $setting_contact['whatsapp'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" name="instagram" id="instagram" class="form-control"
                                    placeholder="Masukkan Instgram"
                                    value="{{ old('instagram', $setting_contact['instagram'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" name="facebook" id="facebook" class="form-control"
                                    placeholder="Masukkan Facebook"
                                    value="{{ old('facebook', $setting_contact['facebook'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="twitter" class="form-label">Twitter</label>
                                <input type="url" name="twitter" id="twitter" class="form-control"
                                    placeholder="Masukkan Twitter"
                                    value="{{ old('twitter', $setting_contact['twitter'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="youtube" class="form-label">Youtube</label>
                                <input type="url" name="youtube" id="youtube" class="form-control"
                                    placeholder="Masukkan Youtube"
                                    value="{{ old('youtube', $setting_contact['youtube'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
        <div class="col-12">
            <form action="{{ route('admin.setting.e-letter') }}" method="POST" class="card">
                @csrf
                <div class="card-header py-3">
                    <h4 class="mb-0">Pesan Surat</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning fade show" role="alert">
                        <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                            href="#collapseExample" role="button" aria-expanded="false"
                            aria-controls="collapseExample">
                            <span><strong>Perhatian!</strong> Perhatikan cara penggunaan berikut (klik):</span>
                            <i class="ti ti-chevron-down" style="font-size: 1rem;"></i>
                        </div>
                        <ul class="collapse" id="collapseExample">
                            <li>
                                <span>Daftar Varibale yang Diizinkan:</span>
                                <ul>
                                    @foreach ($eLetterVariableMessage as $item)
                                        <li><code>{{ $item }}</code></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>

                    @if (session('e_letter_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('e_letter_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('e_letter_error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('e_letter_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->e_letter->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                            <ul>
                                @foreach ($errors->e_letter->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="success" class="form-label">Surat Selesai <span
                                        class="text-danger">*</span></label>
                                <textarea type="text" name="success" id="success" class="form-control" style="height: 12rem;"
                                    placeholder="Masukkan Pesan Surat Selesai" required>{{ old('success', $setting_e_letter['success'] ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="reject" class="form-label">Surat Ditolak <span
                                        class="text-danger">*</span></label>
                                <textarea type="text" name="reject" id="reject" class="form-control" style="height: 12rem;"
                                    placeholder="Masukkan Pesan Surat Ditolak" required>{{ old('reject', $setting_e_letter['reject'] ?? '') }}</textarea>
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
    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
    <script>
        Coloris({
            swatches: [
                '#15aa3d',
                '#ec8544',
                '#219ad0',
            ],
            onChange: (color, inputEl) => {
                console.log(`The new color is ${color}`);
            }
        });
    </script>
@endsection
