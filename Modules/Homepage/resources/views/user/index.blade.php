@extends('user.layouts.app')

@section('title', 'Homepage')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/custom.chart.css') }}">
@endsection

@section('content')
    <!-- Greeting -->
    <div class="bg-parallax"
        style="padding-top: 4rem; padding-bottom: 4rem; background-image: url({{ $setting_appearance['background_banner'] ? Storage::disk('public')->url($setting_appearance['background_banner']) : '' }});">
        <div class="bg-parallax-overlay"></div>
        <div class="container position-relative" style="z-index: 1">
            <div class="row">
                <!-- Title and Search -->
                <div class="col-12 d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ isset($setting_app['logo']) ? Storage::disk('public')->url($setting_app['logo']) : '' }}"
                        alt="" style="width: 75px" />
                    <span class="fs-3 fw-semibold text-white mt-4">Sistem Informasi Desa
                        {{ $setting_app['name'] ?? '' }}</span>
                    <span class="fs-5 text-white mb-5 mb-md-0">{{ $setting_contact['address'] ?? '' }}</span>
                    <form action="{{ route('user.news.index') }}" method="GET" class="greeting-search-form"
                        role="search">
                        <div class="position-relative w-100">
                            <i class="bi bi-search position-absolute ms-4 text-app-secondary"
                                style="top: 50%; left: 0; transform: translate(-50%, -50%)"></i>
                            <input class="form-control rounded-pill py-2"
                                style="padding-left: 2.5rem !important;font-style: italic;border-bottom: 2px solid var(--color-secondary-app);"
                                type="search" name="s" placeholder="Cari Informasi yang anda butuhkan disini ..."
                                aria-label="Search" />
                        </div>
                    </form>
                </div>
                <!-- End Title and Search -->

                <!-- Grid Main Menu-->
                <div class="col-12">
                    <div class="row">
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.gallery.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/image-gallery.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Gallery</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.news.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/document.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Berita</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.e-letter.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/compliant.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Surat</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.product.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/trolley.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Produk</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.statistic.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/archive.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Statistik</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.information.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/announcement.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Pengumuman</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.contact.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/architect.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate w-100 text-center">Bantuan</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-3 col-md-3 col-lg mb-4">
                            <a href="{{ route('user.contact.index') }}" class="card rounded-4 card-greeting-menu">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/map.webp"
                                        alt="" class="mb-1 mb-md-3" />
                                    <span style="font-size: 12px"
                                        class="mb-1 d-block text-truncate text-center">Peta</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Grid Main Menu-->
            </div>
        </div>
    </div>
    <!-- End Greeting -->

    <div class="container position-relative" style="z-index: 1; margin-bottom: 4rem">
        <div class="row" style="margin-top: -2.5rem">
            <!-- Banner -->
            <div class="col-12 col-lg-8 position-relative banner-wrapper">
                <div class="position-absolute bg-app-secondary py-2 px-4 fw-semibold text-white"
                    style="top: 0; z-index: 1; border-bottom-right-radius: 1.5rem">
                    Pengumuman Desa
                </div>
                <div class="banner">
                    @foreach ($informations as $item)
                        <div class="card overflow-hidden banner-item">
                            <div class="card-body p-0 h-100">
                                <img src="{{ $item->thumbnail }}" alt=""
                                    class="img-fluid w-100 h-100 object-fit-cover" />
                                <div class="position-absolute w-100 h-100 p-3 d-flex flex-column justify-content-end"
                                    style="top: 0; left: 0; right: 0; bottom: 0">
                                    <div class="card w-100 rounded-4"
                                        style="border-bottom: 2px solid var(--color-secondary-app); background-color: rgba(255, 255, 255, 0.9) !important;">
                                        <div class="card-body">
                                            <div class="d-flex gap-4 align-items-center">
                                                <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/Logo.webp"
                                                    alt="" class="flex-shrink-0" style="width: 65px" />
                                                <div class="d-flex flex-column flex-grow-1"
                                                    style="min-width: 0; max-width: 100%">
                                                    <span
                                                        class="fs-5 fw-semibold d-block text-truncate">{{ $item->title }}</span>
                                                    <span class="mb-2 d-block text-truncate"
                                                        style="font-size: 13px">{{ strip_tags($item->content) }}</span>
                                                    <div
                                                        class="d-flex flex-column flex-md-row align-items-start gap-1 gap-md-3">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="bi bi-calendar3" style="font-size: 12px"></i>
                                                            <span class="fw-semibold"
                                                                style="font-size: 12px">{{ $item->created_at->format('Y-m-d\TH:i') }}</span>
                                                        </div>
                                                        <a href="{{ route('user.information.detail', $item->slug) }}"
                                                            class="d-flex align-items-center gap-2 read-information text-dark">
                                                            <i class="bi bi-eye" style="font-size: 12px"></i>
                                                            <span class="fw-semibold"
                                                                style="font-style: italic; font-size: 12px">Baca
                                                                Pengumuman</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="position-absolute w-100 justify-content-between align-items-center btn-nav-slick">
                    <div class="rounded-circle bg-white border shadow-sm btn-nav-slick-prev">
                        <i class="bi bi-chevron-left" style="font-size: 1.2rem"></i>
                    </div>
                    <div class="rounded-circle bg-white border shadow-sm btn-nav-slick-next">
                        <i class="bi bi-chevron-right" style="font-size: 1.2rem"></i>
                    </div>
                </div>
            </div>
            <!-- End Banner -->

            <!-- Statistik Penduduk -->
            <div class="col col-lg-4 d-none d-lg-block civilStatisticWrapper">
                <div class="card" style="height: 20rem">
                    <div class="card-body h-100 d-flex flex-column align-items-center">
                        <span class="fs-5 fw-semibold mb-2">Data Penduduk Desa</span>
                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                            <canvas id="civilStatistic" class="w-100 h-100"></canvas>
                        </div>
                        <div id="civilStatistic-legend" class="legend-scroll-wrapper"></div>
                        <span class="fw-semibold">Total Penduduk :
                            {{ rupiah_formatted($residentGenders->total, '') }}</span>
                    </div>
                </div>
            </div>
            <!-- End Statistik Penduduk -->
        </div>
    </div>

    <div class="container" style="margin-bottom: 4rem">
        <div class="row mx-0 overflow-hidden">
            <div class="col-12 col-lg-4 ps-0 position-relative overflow-hidden pray-schedule-header">
                <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2025/03/Jadwal-Sholat.jpg" alt=""
                    class="img-fluid d-block position-absolute w-100" style="left: 0; top: 0" />
                <div class="d-flex align-items-center w-100 position-absolute px-4 pb-2 mb-2 gap-3 pray-schedule-header-text"
                    style="left: 0; bottom: 0">
                    <i class="bi bi-clock text-white"></i>
                    <span class="fs-5 fw-semibold text-white">Jadwal Sholat di {{ $setting_app['name'] ?? '' }}</span>
                </div>
            </div>
            <div class="col-12 col-lg-8 pt-3 pray-schedule-body">
                <div class="row h-100 align-items-center">
                    <div class="col-4 col-lg-2 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/1.-Muslim-Pro-removebg-preview-e1692256856186.png"
                                        alt="" style="width: 24px; height: 24px" />
                                    <span class="d-block text-truncate" style="font-size: 16px">Imsak</span>
                                </div>
                                <span class="d-block fs-3 text-center fw-bold" style="letter-spacing: 1px"
                                    id="pray-schedule-imsak">00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/1.-Muslim-Pro-removebg-preview-e1692256856186.png"
                                        alt="" style="width: 24px; height: 24px" />
                                    <span class="d-block text-truncate" style="font-size: 16px">Subuh</span>
                                </div>
                                <span class="d-block fs-3 text-center fw-bold" style="letter-spacing: 1px"
                                    id="pray-schedule-subuh">00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/1.-Muslim-Pro-removebg-preview-e1692256856186.png"
                                        alt="" style="width: 24px; height: 24px" />
                                    <span class="d-block text-truncate" style="font-size: 16px">Dzuhur</span>
                                </div>
                                <span class="d-block fs-3 text-center fw-bold" style="letter-spacing: 1px"
                                    id="pray-schedule-dzuhur">00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/1.-Muslim-Pro-removebg-preview-e1692256856186.png"
                                        alt="" style="width: 24px; height: 24px" />
                                    <span class="d-block text-truncate" style="font-size: 16px">Ashar</span>
                                </div>
                                <span class="d-block fs-3 text-center fw-bold" style="letter-spacing: 1px"
                                    id="pray-schedule-ashar">00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/1.-Muslim-Pro-removebg-preview-e1692256856186.png"
                                        alt="" style="width: 24px; height: 24px" />
                                    <span class="d-block text-truncate" style="font-size: 16px">Maghrib</span>
                                </div>
                                <span class="d-block fs-3 text-center fw-bold" style="letter-spacing: 1px"
                                    id="pray-schedule-maghrib">00:00</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 col-lg-2 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/1.-Muslim-Pro-removebg-preview-e1692256856186.png"
                                        alt="" style="width: 24px; height: 24px" />
                                    <span class="d-block text-truncate" style="font-size: 16px">Isya</span>
                                </div>
                                <span class="d-block fs-3 text-center fw-bold" style="letter-spacing: 1px"
                                    id="pray-schedule-isya">00:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section style="margin-bottom: 4rem">
        <div class="position-relative" style="bottom: -1px">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" class="w-100"
                style="height: 35px; fill: #e7f4f4">
                <path
                    d="M790.5,93.1c-59.3-5.3-116.8-18-192.6-50c-29.6-12.7-76.9-31-100.5-35.9c-23.6-4.9-52.6-7.8-75.5-5.3
                                                                                                                                                                                                                                                                                 c-10.2,1.1-22.6,1.4-50.1,7.4c-27.2,6.3-58.2,16.6-79.4,24.7c-41.3,15.9-94.9,21.9-134,22.6C72,58.2,0,25.8,0,25.8V100h1000V65.3
                                                                                                                                                                                                                                                                                 c0,0-51.5,19.4-106.2,25.7C839.5,97,814.1,95.2,790.5,93.1z">
                </path>
            </svg>
        </div>
        <div class="py-3" style="background-color: #e7f4f4">
            <div class="container">
                <div class="row mb-4 pb-2">
                    <div class="col-12">
                        <div class="d-flex flex-column">
                            <span class="fs-4 fw-semibold mb-2">Aparatur Desa</span>
                            <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 40px"></div>
                        </div>
                    </div>
                </div>
                @if ($villageOfficialGreeting)
                    <div class="row">
                        <div class="col-12 col-lg-5 mb-4">
                            <img src="{{ $villageOfficialGreeting->image }}" alt=""
                                class="img-fluid rounded-4 object-fit-cover" style="aspect-ratio: 9/7" />
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="fw-semibold text-app-secondary">
                                Sambutan Pemimpin Desa.
                            </div>
                            <div class="fs-4 fw-bold mb-4">{{ $villageOfficialGreeting->name }}</div>
                            <div class="mb-4">{{ $villageOfficialGreeting->content }}</div>
                            <div class="sign-image">
                                <img src="{{ $villageOfficialGreeting->sign_image }}" alt=""
                                    style="width: 125px" />
                            </div>
                        </div>
                        <div class="col-12 pt-2">
                            <hr />
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12 position-relative village-structure-wrapper">
                        <div class="village-structure">
                            @foreach ($villageOfficialMembers as $item)
                                <div class="card shadow-sm rounded-4 mt-2 mb-3" style="background-color: #e7f4f4">
                                    <div class="card-body">
                                        <div class="d-flex flex-column justify-content-center align-items-center">
                                            <img src="{{ $item->image }}" alt=""
                                                class="img-fluid object-fit-cover rounded-3 rounded-bottom-0 mb-2"
                                                style="aspect-ratio: 7/9" />
                                            {{-- <img src="{{ $item->resident->image }}" alt=""
                                                class="img-fluid object-fit-cover rounded-3 rounded-bottom-0 mb-2"
                                                style="aspect-ratio: 7/9" /> --}}
                                            <span
                                                class="fw-semibold d-block text-truncate w-100 village-structure-name text-center">{{ $item->resident->full_name }}</span>
                                            <span
                                                class="d-block text-truncate text-center w-100">{{ $item->position }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="position-absolute w-100 justify-content-between align-items-center btn-nav-slick">
                            <div class="rounded-circle bg-white border shadow-sm btn-nav-slick-prev">
                                <i class="bi bi-chevron-left" style="font-size: 1.2rem"></i>
                            </div>
                            <div class="rounded-circle bg-white border shadow-sm btn-nav-slick-next">
                                <i class="bi bi-chevron-right" style="font-size: 1.2rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative" style="top: -1px">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" class="w-100"
                style="height: 35px; fill: #e7f4f4">
                <path
                    d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
                                                                                                                                                                                                                                                                                 c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
                                                                                                                                                                                                                                                                                 c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z">
                </path>
            </svg>
        </div>
    </section>

    <section style="margin-bottom: 4rem">
        <div class="container">
            <div class="row mb-4 pb-2">
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <span class="fs-4 fw-semibold mb-2">Berita Desa</span>
                        <div class="bg-app-secondary rounded-pill" style="height: 5px; width: 40px"></div>
                    </div>
                </div>
            </div>
            @if ($news->topNews)
                <div class="row align-items-center">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="card shadow-sm overflow-hidden rounded-4">
                            <div class="card-body p-0" style="height: 25rem">
                                <img src="{{ $news->topNews->thumbnail }}" alt=""
                                    class="img-fluid w-100 h-100 object-fit-cover" />
                                <div class="w-100 h-100 position-absolute"
                                    style="top: 0; left: 0; background-color: transparent; background-image: linear-gradient(180deg,#ffffff00 0%,#000000 45%); opacity: 0.75; z-index: 1;">
                                </div>
                                <div class="d-flex flex-column justify-content-end w-100 h-100 position-absolute text-white"
                                    style="top: 0; left: 0; z-index: 4">
                                    <div class="px-3" style="padding-top: 0.8rem; padding-bottom: 0.8rem">
                                        <div class="fs-5 fw-semibold mb-2 text-truncate">{{ $news->topNews->title }}</div>
                                        <div class="news-content-new" style="font-size: 13px">
                                            {{ strip_tags($news->topNews->content) }}</div>
                                    </div>
                                    <div class="w-100 bg-white flex-shrink-0" style="height: 0.5px"></div>
                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center px-3"
                                        style="padding-top: 0.8rem; padding-bottom: 0.8rem">
                                        <div class="d-flex align-items-center gap-4 mb-2 mb-md-0">
                                            <div class="border rounded-circle"
                                                style="border-color: red !important; padding: 2px">
                                                <img src="https://secure.gravatar.com/avatar/?s=96&d=mm&r=g"
                                                    alt="" class="object-fit-cover rounded-circle"
                                                    style="width: 33px; height: 33px" />
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-person-circle" style="font-size: 12px"></i>
                                                    <span style="font-size: 12px">by
                                                        {{ $news->topNews->user->name }}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-calendar-fill" style="font-size: 12px"></i>
                                                    <span
                                                        style="font-size: 12px">{{ $news->topNews->created_at->format('d/m/Y') }}</span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-eye" style="font-size: 12px"></i>
                                                    <span style="font-size: 12px">{{ $news->topNews->views }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('user.news.detail', $news->topNews->slug) }}"
                                            class="btn btn-lg btn-app-secondary rounded-pill border border-opacity-50 px-5 text-white d-flex justify-content-center align-items-center gap-2 btn-news-new"><span
                                                style="font-size: 13px">Baca Berita</span>
                                            <i class="bi bi-book"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 position-relative news-wrapper">
                        <div class="news">
                            @foreach ($news->childrenNews as $item)
                                <div class="card shadow-sm overflow-hidden rounded-4">
                                    <div class="card-body news-item p-0">
                                        <img src="{{ $item->thumbnail }}" alt=""
                                            class="img-fluid w-100 h-100 object-fit-cover" />
                                        <div class="w-100 h-100 position-absolute"
                                            style="top: 0; left: 0; background-color: transparent; background-image: linear-gradient(180deg,#ffffff00 0%,#000000 45%); opacity: 0.75; z-index: 1;">
                                        </div>
                                        <div class="d-flex flex-column justify-content-end w-100 h-100 position-absolute text-white"
                                            style="top: 0; left: 0; z-index: 4">
                                            <div class="px-3" style="padding-top: 0.8rem; padding-bottom: 0.8rem">
                                                <div class="fs-5 fw-semibold mb-2 text-truncate">{{ $item->title }}</div>
                                                <div class="news-item-content" style="font-size: 13px">
                                                    {{ strip_tags($item->content) }}</div>
                                            </div>
                                            <div class="w-100 bg-white" style="height: 0.5px"></div>
                                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center px-3"
                                                style="padding-top: 0.8rem; padding-bottom: 0.8rem">
                                                <div
                                                    class="d-flex justify-content-between justify-content-md-start align-items-center gap-3 mb-2 mb-md-0">
                                                    <div class="border rounded-circle"
                                                        style="border-color: red !important; padding: 2px">
                                                        <img src="https://secure.gravatar.com/avatar/?s=96&d=mm&r=g"
                                                            alt="" class="object-fit-cover rounded-circle"
                                                            style="width: 33px; height: 33px" />
                                                    </div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-eye" style="font-size: 12px"></i>
                                                        <span style="font-size: 12px">{{ $item->views }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('user.news.detail', $item->slug) }}"
                                                    class="btn btn-lg btn-app-secondary rounded-pill border border-opacity-50 px-5 text-white d-flex align-items-center gap-2 btn-news-new"><span
                                                        style="font-size: 13px">Baca</span>
                                                    <i class="bi bi-book"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="position-absolute w-100 justify-content-between align-items-center btn-nav-slick">
                            <div class="rounded-circle bg-white border shadow-sm btn-nav-slick-prev">
                                <i class="bi bi-chevron-left" style="font-size: 1.2rem"></i>
                            </div>
                            <div class="rounded-circle bg-white border shadow-sm btn-nav-slick-next">
                                <i class="bi bi-chevron-right" style="font-size: 1.2rem"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="py-5" style="background-color: #e7f4f4; margin-bottom: 4rem">
        <div class="container">
            <div class="row mb-4 pb-2">
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <span class="fs-4 fw-semibold mb-2">Galeri Kegiatan Desa</span>
                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 90px"></div>
                    </div>
                </div>
            </div>
            <div id="grider" class="row grider">
                @foreach ($galleries as $item)
                    <div class="rounded-3">
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section style="margin-bottom: 4rem">
        <div class="container">
            <div class="row mb-4 pb-2">
                <div class="col-12">
                    <div class="d-flex flex-column align-items-center">
                        <span class="fs-4 fw-semibold mb-2">Transparansi Anggaran</span>
                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 80px"></div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($budgets as $i => $item)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card shadow rounded-4 overflow-hidden">
                            <div class="card-header bg-white">
                                <div class="card-title text-center text-truncate fs-5 fw-semibold">{{ $item->title }}
                                </div>
                            </div>
                            <div class="card-body overflow-hidden">
                                <div class="d-flex justify-content-center py-3 position-relative">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/61dc37eb166d8.webp"
                                        alt="" class="position-absolute opacity-50"
                                        style="bottom: -30px; right: -30px; width: 200px" />
                                    <div class="position-relative" style="width: 60%">
                                        <div id="budget-progress-{{ $i }}"></div>
                                        <div class="d-flex flex-column justify-content-center align-items-center position-absolute w-100 h-100"
                                            style="top: 0; left: 0">
                                            <div class="d-flex justify-content-center align-items-start">
                                                <span class="fw-bold">Rp</span>
                                                <span
                                                    class="fs-4 fw-bold">{{ rupiah_formatted($item->total_out, '') }}</span>
                                            </div>
                                            <span class="fw-semibold" style="font-size: 13px">Total :
                                                {{ rupiah_formatted($item->total_in) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="pt-5"
        style="
        margin-bottom: 4rem;
        padding-bottom: 4rem;
        background-color: #e7f4f4;
      ">
        <div class="container">
            <div class="row mb-4 pb-3">
                <div class="col-12">
                    <div class="d-flex flex-column align-items-center">
                        <span class="fs-4 fw-semibold mb-2">Program Sinergi</span>
                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 90px"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="integration-goverment">
                        @foreach ($synergyPrograms as $item)
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" style="width: 100px" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section style="margin-bottom: 4rem">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-4 bg-app-gradient">
                        <div class="card-body py-4 position-relative">
                            <div class="position-absolute h-100 opacity-50" style="top: 0; right: 0">
                                <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/CS-Overlay.png"
                                    alt="" class="h-100" />
                            </div>
                            <div class="container-fluid position-relative">
                                <div class="row mb-4 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex flex-column">
                                            <span class="fs-4 fw-semibold mb-2 text-white">Pengaduan Desa</span>
                                            <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 90px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 text-white fs-5 fw-semibold mb-2 mb-md-0">
                                        Apabila Anda Memiliki Keluhan dan Dan Permasalahan bisa
                                        klik button di bawah ini !
                                    </div>
                                    <div class="col-12 text-white">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Sed egestas felis nec massa ornare blandit.
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <a href="{{ route('user.e-letter.index') }}"
                                            class="btn btn-lg btn-app-secondary rounded-pill border border-3 border-info border-opacity-50 px-4 text-white d-inline-flex align-items-center gap-2">
                                            <span style="font-size: 13px">Pengajuan Surat</span>
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script src="{{ asset('js/custom.chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            const civilStatisticConfig = {
                type: "doughnut",
                data: {
                    labels: @json($residentGenders->label),
                    datasets: [{
                        // label: "Nilai Data",
                        data: @json($residentGenders->value),
                        backgroundColor: ['#4DC9F6', '#F7464A', '#FDB45C', '#949FB1', '#46BFBD',
                            '#8064A1', '#FFC0CB', '#B0E0E6', '#98FB98', '#FFD700',
                            '#ADD8E6', '#F08080', '#FFCC99', '#D3D3D3', '#87CEFA', '#6A5ACD',
                            '#EE82EE', '#AFEEEE', '#90EE90', '#FFA07A',
                            '#FF6384', '#36A2EB', '#FFCE56', '#5AD3D1', '#CC65FE', '#CDA79F',
                            '#8A2BE2', '#7FFF00', '#D2B48C', '#E6E6FA'
                        ],
                        hoverOffset: 4,
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                            position: "bottom",
                            // labels: {
                            //     usePointStyle: true,
                            //     pointStyle: "rect",
                            // },
                        },
                        tooltip: {
                            callbacks: {
                                title: () => [],
                                label: function(tooltipItem) {
                                    return ` ${tooltipItem.label}: ${tooltipItem.formattedValue}`;
                                }
                            }
                        },
                        htmlLegend: {
                            containerID: 'civilStatistic-legend',
                        },
                        title: {
                            display: false,
                            text: "Data Penduduk",
                        },
                    },
                    cutout: "15%",
                },
                plugins: [htmlLegendPlugin]
            };

            const civilStatistic = document.getElementById("civilStatistic");
            window.civilStatisticChart = new Chart(civilStatistic, civilStatisticConfig);

            let chartCivilCountResizeTimer;
            $(window).on("resize", function() {
                clearTimeout(chartCivilCountResizeTimer);
                chartCivilCountResizeTimer = setTimeout(function() {
                    if (window.civilStatisticChart) {
                        window.civilStatisticChart.destroy();
                    }
                    window.civilStatisticChart = new Chart(
                        civilStatistic,
                        civilStatisticConfig
                    );
                }, 150);
            });

            @foreach ($budgets as $i => $item)
                const totalIn{{ $i }} = parseInt('{{ $item->total_in }}');
                const totaOut{{ $i }} = parseInt('{{ $item->total_out }}');

                let progressRatio{{ $i }} = 0;
                if (totalIn{{ $i }} > 0) {
                    progressRatio{{ $i }} = totaOut{{ $i }} / totalIn{{ $i }};
                }
                progressRatio{{ $i }} = Math.min(progressRatio{{ $i }}, 1);

                let colorCode{{ $i }} = "#15aa3d";
                if (progressRatio{{ $i }} >= 0.7) {
                    colorCode{{ $i }} = "#DC3545";
                } else if (progressRatio{{ $i }} >= 0.5) {
                    colorCode{{ $i }} = "#FFC107";
                }

                var budgetProgress{{ $i }} = new ProgressBar.Circle(
                    "#budget-progress-{{ $i }}", {
                        color: colorCode{{ $i }},
                        trailColor: "#e0e0e0",
                        strokeWidth: 4,
                        trailWidth: 4,
                        easing: "easeInOut",
                        duration: 1400,
                        strokeLinecap: "round",
                    });
                budgetProgress{{ $i }}.set(progressRatio{{ $i }});
            @endforeach

        });
    </script>
@endsection
