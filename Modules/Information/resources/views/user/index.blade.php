@extends('user.layouts.app')

@section('title', 'Pengumuman')

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
                                                <span class="fs-5 fw-semibold mb-2">Pengumuman</span>
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
                                                <a href="{{ route('user.information.detail', $item->slug) }}"
                                                    class="d-block text-decoration-none text-dark flex-grow-1"
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
                                                <a href="{{ route('user.news.detail', $item->slug) }}"
                                                    class="d-block text-decoration-none text-dark flex-grow-1"
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
                <div class="col-12 col-lg-8">
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-4 pb-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fs-4 fw-semibold mb-2">Pengumuman Desa</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row information">
                                @foreach ($informations as $item)
                                    <div class="col-12 mb-3">
                                        <div class="card overflow-hidden information-item">
                                            <div class="card-body p-0 h-100">
                                                <img src="{{ $item->thumbnail }}" alt=""
                                                    class="img-fluid w-100 h-100 object-fit-cover" />
                                                <div class="position-absolute w-100 h-100 p-3 d-flex flex-column justify-content-end"
                                                    style="top: 0; left: 0; right: 0; bottom: 0">
                                                    <div class="card w-100 rounded-4"
                                                        style="border-bottom: 2px solid var(--color-secondary-app); background-color: rgba(255,255,255,0.9) !important;">
                                                        <div class="card-body">
                                                            <div class="d-flex gap-4 align-items-center">
                                                                <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/Logo.webp"
                                                                    alt="" class="flex-shrink-0"
                                                                    style="width: 65px" />
                                                                <div class="d-flex flex-column flex-grow-1"
                                                                    style="min-width: 0; max-width: 100%">
                                                                    <span
                                                                        class="fs-5 fw-semibold d-block text-truncate">{{ $item->title }}</span>
                                                                    <span class="mb-2 d-block text-truncate"
                                                                        style="font-size: 13px">{{ strip_tags($item->content) }}</span>
                                                                    <div
                                                                        class="d-flex flex-column flex-md-row align-items-start gap-1 gap-md-3">
                                                                        <div class="d-flex align-items-center gap-2">
                                                                            <i class="bi bi-calendar3"
                                                                                style="font-size: 12px"></i>
                                                                            <span class="fw-semibold"
                                                                                style="font-size: 12px">{{ $item->created_at->format('Y-m-d\TH:i') }}</span>
                                                                        </div>
                                                                        <a href="{{ route('user.information.detail', $item->slug) }}"
                                                                            class="d-flex align-items-center gap-2 read-information text-dark">
                                                                            <i class="bi bi-eye"
                                                                                style="font-size: 12px"></i>
                                                                            <span class="fw-semibold"
                                                                                style="font-style: italic; font-size: 12px;">Baca
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
