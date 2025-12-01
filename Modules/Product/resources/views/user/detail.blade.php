@extends('user.layouts.app')

@section('title', $data->name)

@section('content')
    <section style="margin: 2rem 0px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-4 mb-2">
                                    <img src="{{ $data->image }}" alt=""
                                        class="img-fluid object-fit-cover rounded-3 mb-2" style="aspect-ratio: 9/6" />
                                </div>
                                <div class="col-12 col-lg-8">
                                    <h4>{{ $data->name }}</h4>
                                    <i class="fs-5 fw-normal">{{ rupiah_formatted($data->price) }}</i>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 col-lg-8 mb-2">{!! $data->description !!}</div>
                                        <div class="col-12 col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="d-block mb-3">Beli Sekarang:</span>
                                                    <a href="https://wa.me/{{ $data->whatsapp_number }}?text={{ getBuyMessageTemplate($data->name) }}"
                                                        target="_blank"
                                                        class="btn btn-app-secondary fw-semibold text-white w-100"
                                                        style="background-color: var(--color-primary-app)!important;"><i
                                                            class="bi bi-whatsapp"></i> Buy Now</a>
                                                </div>
                                            </div>
                                        </div>
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
