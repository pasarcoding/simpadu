@extends('user.layouts.app')

@section('title', 'Visi & Misi Desa')

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
                <div class="col-12 col-md-8">
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body">
                            @if ($villageOfficialVisionMission)
                                <div class="row">
                                    <div class="col-12 mb-4 pb-3">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="fs-4 fw-semibold mb-2">Visi Desa</span>
                                            <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">{!! $villageOfficialVisionMission->vision !!}</div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-4 pb-3">
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="fs-4 fw-semibold mb-2">Misi Desa</span>
                                            <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">{!! $villageOfficialVisionMission->mission !!}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
