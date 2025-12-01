@extends('user.layouts.app')

@section('title', 'Gallery Desa')

@section('content')
    <section style="margin: 2rem 0px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-4 pb-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fs-4 fw-semibold mb-2">Gallery Desa</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>

                                {{-- <div class="col-12 mb-5">
                                    <input type="text" class="form-control" placeholder="Ketikan Nama disini..."
                                        style="font-style: italic" />
                                </div> --}}
                            </div>
                            <div id="grider" class="row grider">
                                @foreach ($galleries as $item)
                                    <div class="rounded-3">
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}" />
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
