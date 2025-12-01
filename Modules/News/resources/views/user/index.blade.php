@extends('user.layouts.app')

@section('title', 'Berita')

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
                                        <span class="fs-4 fw-semibold mb-2">Berita Desa</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($searchQuery)
                                    <i class="mb-4">Pencarian "<b>{{ $searchQuery }}</b>"</i>
                                @endif
                                @foreach ($news as $item)
                                    <div class="col-12 col-md-6 col-lg-4 mb-4">
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
                                                        <div class="fs-5 fw-semibold mb-2 text-truncate">
                                                            {{ $item->title }}
                                                        </div>
                                                        <div class="news-item-content" style="font-size: 13px">
                                                            {{ strip_tags($item->content) }}</div>
                                                    </div>
                                                    <div class="w-100 bg-white" style="height: 0.5px"></div>
                                                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center px-3"
                                                        style="padding-top: 0.8rem; padding-bottom: 0.8rem">
                                                        <div
                                                            class="d-flex justify-content-between justify-content-md-start align-items-center gap-2 mb-2 mb-md-0">
                                                            <div class="border rounded-circle"
                                                                style="border-color: red !important; padding: 2px;">
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
                                                            class="btn btn-lg btn-app-secondary rounded-pill border border-opacity-50 px-4 text-white d-flex align-items-center justify-content-center gap-2 btn-news-new"><span
                                                                style="font-size: 13px">Baca</span>
                                                            <i class="bi bi-book"></i></a>
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
