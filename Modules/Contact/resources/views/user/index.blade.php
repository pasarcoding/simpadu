@extends('user.layouts.app')

@section('title', 'Kontak')

@section('header')
    <style>
        .form-control {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }
    </style>
@endsection

@section('content')
    <section>
        <iframe src="{{ extractIframeSrc($setting_contact['maps'] ?? '') }}" class="contact-maps" allowfullscreen=""
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        {{-- <iframe src="https://maps.google.com/maps?width=100&height=100&hl=en&q=salatiga&t=&z=14&ie=UTF8&iwloc=B&output=embed"
            class="contact-maps" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
    </section>
    <section style="margin: 2rem 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4 mb-4">
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body pb-4">
                            <div class="row">
                                <div class="col-12 mb-4 pb-1">
                                    <div class="d-flex flex-column">
                                        <span class="fs-5 fw-semibold mb-2">Hubungi Kami</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 40px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex align-items-center gap-3 mb-4">
                                        <a href="{{ $setting_contact['youtube'] ?? '' }}" target="_blank"
                                            class="bg-app rounded-2 position-relative hover-scale-effect text-decoration-none"
                                            style="padding: 0.85rem">
                                            <i class="bi bi-youtube position-absolute text-white"
                                                style="top: 50%;left: 50%;transform: translate(-50%, -50%);font-size: 12px;"></i>
                                        </a>
                                        <a href="{{ $setting_contact['instagram'] ?? '' }}" target="_blank"
                                            class="bg-app rounded-2 position-relative hover-scale-effect text-decoration-none"
                                            style="padding: 0.85rem">
                                            <i class="bi bi-instagram position-absolute text-white"
                                                style="top: 50%;left: 50%;transform: translate(-50%, -50%);font-size: 12px;"></i>
                                        </a>
                                        <a href="{{ $setting_contact['facebook'] ?? '' }}" target="_blank"
                                            class="bg-app rounded-2 position-relative hover-scale-effect text-decoration-none"
                                            style="padding: 0.85rem">
                                            <i class="bi bi-facebook position-absolute text-white"
                                                style="top: 50%;left: 50%;transform: translate(-50%, -50%);font-size: 12px; "></i>
                                        </a>
                                        <a href="{{ $setting_contact['twitter'] ?? '' }}" target="_blank"
                                            class="bg-app rounded-2 position-relative hover-scale-effect text-decoration-none"
                                            style="padding: 0.85rem">
                                            <i class="bi bi-twitter position-absolute text-white"
                                                style="top: 50%;left: 50%;transform: translate(-50%, -50%);font-size: 12px;"></i>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-envelope-at-fill text-app"></i>
                                            <span class="fw-semibold">Email : {{ $setting_contact['email'] ?? '' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-whatsapp text-app"></i>
                                            <span class="fw-semibold">WA : {{ $setting_contact['whatsapp'] ?? '' }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-geo-alt-fill text-app"></i>
                                            <span class="fw-semibold">Kantor :
                                                {{ $setting_contact['address'] ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="card shadow shadow-sm rounded-4">
                        <form action="{{ route('user.contact.critique-suggestion') }}" method="POST" class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-4 pb-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fs-4 fw-semibold mb-2">Kritik & Saran</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Berhasil!</strong> {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

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
                                </div>
                                <div class="form-group col-12 mb-4">
                                    <input type="text" name="name" id="name" class="form-control fst-italic"
                                        placeholder="Nama" required>
                                </div>
                                <div class="form-group col-12 col-lg-6 mb-4">
                                    <input type="tel" name="phone" id="phone" pattern="^(\+62|0)8[0-9]{8,12}$"
                                        class="form-control fst-italic" placeholder="No.Hp/Wa" required>
                                </div>
                                <div class="form-group col-12 col-lg-6 mb-4">
                                    <input type="email" name="email" id="email" class="form-control fst-italic"
                                        placeholder="Email" required>
                                </div>
                                <div class="form-group col-12 mb-4">
                                    <input type="text" name="subject" id="subject" class="form-control fst-italic"
                                        placeholder="Subjek" required>
                                </div>
                                <div class="form-group col-12 mb-4">
                                    <textarea type="text" name="content" id="content" class="form-control fst-italic" placeholder="Pesan Anda"
                                        style="height: 15rem;" required></textarea>
                                </div>
                                <div class="form-group col-12 text-end">
                                    <input type="submit" value="Kirim"
                                        class="btn text-white btn-app-secondary bg-app-secondary px-4 py-2">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
