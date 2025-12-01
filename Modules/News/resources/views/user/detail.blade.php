@extends('user.layouts.app')

@section('title', $data->title)

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
                                <div class="col-12 mb-4">
                                    <div class="d-flex flex-column">
                                        <span class="fs-4 fw-semibold mb-2">{{ $data->title }}</span>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="d-flex gap-2 align-items-center"><i
                                                    class="bi bi-person-circle"></i><i style="font-size: 0.9rem;">by
                                                    {{ $data->user->name }}</i>
                                            </div>
                                            <div class="d-flex gap-2 align-items-center"><i class="bi bi-calendar3"
                                                    style="font-size: 0.9rem;"></i><i
                                                    style="font-size: 0.9rem;">{{ $data->created_at->format('Y-m-d\TH:i') }}</i>
                                            </div>
                                            <div class="d-flex gap-2 align-items-center"><i class="bi bi-eye"></i><i
                                                    style="font-size: 0.9rem;">{{ $data->views }}</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-12">
                                    <img src="{{ $data->thumbnail }}" class="img-fluid d-block rounded-3 mb-4 w-100"
                                        alt="">
                                    <div>{!! $data->content !!}</div>
                                </div>
                            </div>
                            <form action="{{ route('user.news.comment', $data->slug) }}" method="POST" class="row">
                                @csrf
                                <div class="col-12 mb-3">
                                    <div class="fs-5 fw-semibold mb-3">Leave a Reply</div>
                                    <div style="font-size: 1.1rem;">Your email address will not be published. Required
                                        fields are marked <span class="text-danger">*</span></div>
                                </div>
                                <div class="col-12">
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Gagal!</strong> {{ session('error') }}
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
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="content" class="mb-1" style="font-size: 1.1rem;">Comment <span
                                                class="text-danger">*</span></label>
                                        <textarea type="text" name="content" id="content" class="form-control" style="height: 15rem;"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="name" class="mb-1" style="font-size: 1.1rem;">Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="mb-1" style="font-size: 1.1rem;">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label for="website" class="mb-1" style="font-size: 1.1rem;">Website</label>
                                        <input type="url" name="website" id="website" class="form-control">
                                    </div>
                                    <div class="form-group text-end">
                                        <input type="submit" class="btn btn-app-secondary bg-app-secondary text-white px-4 py-2"
                                            value="Post Comment">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
