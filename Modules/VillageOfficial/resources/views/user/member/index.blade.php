@extends('user.layouts.app')

@section('title', 'Aparatur Desa')

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
                                        <span class="fs-4 fw-semibold mb-2">Aparatur Desa</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>

                                {{-- <div class="col-12 mb-5">
                                    <input type="text" class="form-control" placeholder="Ketikan Nama disini..."
                                        style="font-style: italic" />
                                </div> --}}
                            </div>
                            <div class="row justify-content-center">
                                @foreach ($villageOfficialMembers as $item)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="card shadow-sm rounded-4 mt-2 mb-3">
                                            <div class="card-body">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="{{ $item->image }}" alt=""
                                                        class="img-fluid object-fit-cover rounded-3 rounded-bottom-0 mb-2"
                                                        style="aspect-ratio: 7/9" />
                                                    {{-- <img src="{{ $item->resident->image }}" alt=""
                                                        class="img-fluid object-fit-cover rounded-3 rounded-bottom-0 mb-2"
                                                        style="aspect-ratio: 7/9" /> --}}
                                                    <span
                                                        class="fw-semibold d-block text-truncate text-center w-100 village-structure-name">{{ $item->resident->full_name }}</span>
                                                    <span class="d-block text-truncate text-center w-100">{{ $item->position }}</span>
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
