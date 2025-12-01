@extends('admin.layouts.app')

@section('title', 'Tambah Anggota')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.village-official.member.index') }}">Anggota</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Anggota</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.village-official.member.store') }}" method="POST" enctype="multipart/form-data"
                class="card">
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
                                    <th style="min-width: 20rem;">Penduduk <span class="text-danger">*</span></th>
                                    <th style="min-width: 15rem;">Jabatan <span class="text-danger">*</span></th>
                                    <th style="min-width: 15rem;">Foto <span class="text-danger">*</span></th>
                                    <th style="width: auto;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (old('members'))
                                    @foreach (old('members') as $i => $val)
                                        <tr>
                                            <td>
                                                <select name="members[{{ $i }}][resident_id]"
                                                    class="form-control select2" style="width: 100%;" required>
                                                    <option value="" disabled selected>Pilih Penduduk</option>
                                                    @foreach ($residents as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('members.' . $i . '.resident_id') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->full_name }}({{ $item->national_id }}) |
                                                            {{ $item->hamlet_village }}({{ $item->rt }}/{{ $item->rw }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="members[{{ $i }}][position]"
                                                    class="form-control" placeholder="Masukkan Jabatan"
                                                    value="{{ old('members.' . $i . '.position') }}" required>
                                            </td>
                                            <td>
                                                <input type="file" accept="image/*"
                                                    name="members[{{ $i }}][image]" class="form-control"
                                                    required>
                                            </td>
                                            <td>
                                                @if ($i < count(old('members')) - 1)
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
            const residents = Object.values(@json($residents)).map((val) => {
                return `<option value="${val.id}">${val.full_name}(${val.national_id}) | ${val.hamlet_village}(${val.rt}/${val.rw}) </option>`;
            });

            const el = `<tr>
                            <td>
                                <select name="members[0][resident_id]" class="form-control select2"
                                    style="width: 100%;" required>
                                    <option value="" disabled selected>Pilih Penduduk</option>
                                    ${residents}
                                </select>
                            </td>
                            <td>
                                <input type="text" name="members[0][position]" class="form-control"
                                    placeholder="Masukkan Jabatan" required>
                            </td>
                            <td>
                                <input type="file" accept="image/*" name="members[0][image]" class="form-control" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success"><i class="ti ti-plus"></i></button>
                            </td>
                        </tr>`;

            $('tbody').append(el);
            $('.select2').select2();
            changeFormDetection();
        }

        @if (!old('members'))
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
