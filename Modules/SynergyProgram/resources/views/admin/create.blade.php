@extends('admin.layouts.app')

@section('title', 'Tambah Program Sinergi')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.synergy-program.index') }}">Program Sinergi</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Program Sinergi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.synergy-program.store') }}" method="POST" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th style="min-width: 15rem;">Gambar <span class="text-danger">*</span></th>
                                    <th style="min-width: 15rem;">Nama Program <span class="text-danger">*</span></th>
                                    <th style="width: auto;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (old('synergy_programs'))
                                    @foreach (old('synergy_programs') as $i => $val)
                                        <tr>
                                            <td>
                                                <input type="file" accept="image/*"
                                                    name="synergy_programs[{{ $i }}][image]" class="form-control"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="text" name="synergy_programs[{{ $i }}][name]"
                                                    class="form-control" placeholder="Masukkan Nama Program"
                                                    value="{{ old('synergy_programs.' . $i . '.name') }}" required>
                                            </td>
                                            <td>
                                                @if ($i < count(old('synergy_programs')) - 1)
                                                    <button type="button" class="btn btn-danger"><i
                                                            class="ti ti-trash"></i></button>
                                                @else
                                                    <button type="button" class="btn btn-success"><i
                                                            class="ti ti-plus"></i></button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary">Simpan <i class="ti ti-cloud-upload"></i></button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        function appendForm() {
            const el = `<tr>
                            <td>
                                <input type="file" accept="image/*" name="synergy_programs[0][image]" class="form-control" required>
                            </td>
                            <td>
                                <input type="text" name="synergy_programs[0][name]" class="form-control"
                                    placeholder="Masukkan Nama Program" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success"><i class="ti ti-plus"></i></button>
                            </td>
                        </tr>`;

            $('tbody').append(el);
            changeFormDetection();
        }

        @if (!old('synergy_programs'))
            appendForm();
        @endif

        $('table tbody').on('click', 'button.btn-success', function() {
            appendForm();
        });

        $('table tbody').on('click', 'button.btn-danger', function() {
            $(this).closest('tr').remove();
            changeFormDetection();
        });

        function changeFormDetection() {
            const row = $('table tbody tr');
            row.each((i, el) => {
                if (i < row.length - 1) {
                    $(el).find('button').removeClass('btn-success').addClass('btn-danger');
                    $(el).find('button > i').removeClass('ti-plus').addClass('ti-trash');
                }

                $(el).find('input, select').each((i2, el2) => {
                    if ($(el2).attr('name')) {
                        const newName = $(el2).attr('name').replace(/\[\d+\]/g, '[' + i + ']');
                        $(el2).attr('name', newName);
                    }
                });
            });
        }
    </script>
@endsection
