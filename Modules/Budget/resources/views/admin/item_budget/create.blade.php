@extends('admin.layouts.app')

@section('title', 'Tambah Detail Anggaran')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.budget.index') }}">Transparasi Anggaran</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.budget.detail.index', $data->id) }}">Detail Anggaran</a>
    </li>
    <li class="breadcrumb-item" aria-current="page">Tambah Detail Anggaran</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.budget.detail.store', $data->id) }}" method="POST" enctype="multipart/form-data"
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
                                    <th style="min-width: 15rem;">Nominal <span class="text-danger">*</span></th>
                                    <th style="min-width: 15rem;">Tipe <span class="text-danger">*</span></th>
                                    <th style="min-width: 15rem;">Tanggal Pembayaran <span class="text-danger">*</span></th>
                                    <th style="min-width: 15rem;">Catatan <span class="text-danger">*</span></th>
                                    <th style="width: auto;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (old('item_budgets'))
                                    @foreach (old('item_budgets') as $i => $val)
                                        <tr>
                                            <td>
                                                <input type="text" name="item_budgets[{{ $i }}][nominal]"
                                                    class="form-control" placeholder="Masukkan Nominal"
                                                    value="{{ old('item_budgets.' . $i . '.nominal') }}" required>
                                            </td>
                                            <td>
                                                <select name="item_budgets[{{ $i }}][type]" class="form-control select2"
                                                    style="width: 100%;" required>
                                                    <option value="" disabled selected>Pilih Tipe</option>
                                                    @foreach (getItemBudgetTypeList() as $k => $v)
                                                        <option value="{{ $k }}"
                                                            {{ old('item_budgets.' . $i . '.type') == $k ? 'selected' : '' }}>
                                                            {{ $v }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" name="item_budgets[{{ $i }}][payment_at]"
                                                    class="form-control"
                                                    value="{{ old('item_budgets.' . $i . '.payment_at') }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="item_budgets[{{ $i }}][note]" class="form-control"
                                                    placeholder="Masukkan Catatan"
                                                    value="{{ old('item_budgets.' . $i . '.note') }}" required>
                                            </td>

                                            <td>
                                                @if ($i < count(old('item_budgets')) - 1)
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
            const type = Object.entries(@json(getItemBudgetTypeList())).map(([key, val]) => {
                return `<option value="${key}">${val}</option>`;
            });

            const el = `<tr>
                            <td>
                                <input type="text" name="item_budgets[0][nominal]" class="form-control"
                                    placeholder="Masukkan Nominal" required>
                            </td>
                            <td>
                                <select name="item_budgets[0][type]" class="form-control select2"
                                    style="width: 100%;" required>
                                    <option value="" disabled selected>Pilih Tipe</option>
                                    ${type}
                                </select>
                            </td>
                            <td>
                                <input type="date" name="item_budgets[0][payment_at]" class="form-control" required>
                            </td>
                            <td>
                                <input type="text" name="item_budgets[0][note]" class="form-control"
                                    placeholder="Masukkan Catatan" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success"><i class="ti ti-plus"></i></button>
                            </td>
                        </tr>`;

            $('tbody').append(el);
            $('.select2').select2();
            changeFormDetection();
        }

        @if (!old('item_budgets'))
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
