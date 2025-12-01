@extends('user.layouts.app')

@section('title', 'Produk Desa')

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
                                        <span class="fs-4 fw-semibold mb-2">Produk Desa</span>
                                        <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 50px"></div>
                                    </div>
                                </div>

                                {{-- <div class="col-12 mb-5">
                                    <input type="text" class="form-control" placeholder="Ketikan Nama disini..."
                                        style="font-style: italic" />
                                </div> --}}
                            </div>
                            <div class="row justify-content-center">
                                @foreach ($products as $item)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="card shadow-sm rounded-4 mt-2 mb-3">
                                            <div class="card-body">
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <img src="{{ $item->image }}" alt=""
                                                        class="img-fluid object-fit-cover rounded-3 mb-2"
                                                        style="aspect-ratio: 9/6" />
                                                    <span class="fw-semibold d-block text-truncate w-100"
                                                        style="font-size: 15px;">{{ $item->name }}</span>
                                                    <span
                                                        class="d-block text-truncate w-100 mb-3">{{ rupiah_formatted($item->price) }}</span>
                                                    <div class="d-flex justify-content-between w-100">
                                                        <a href="https://wa.me/{{ $item->whatsapp_number }}?text={{ getBuyMessageTemplate($item->name) }}"
                                                            target="_blank"
                                                            class="btn btn-app-secondary fw-semibold text-white"
                                                            style="background-color: var(--color-primary-app)!important;"><i
                                                                class="bi bi-whatsapp"></i> Buy Now</a>
                                                        <a href="{{ route('user.product.detail', $item->slug) }}"
                                                            class="btn btn-app-secondary bg-app-secondary fw-semibold text-white"><i
                                                                class="bi bi-eye"></i> Details</a>
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
