@extends('admin.layouts.app')

@section('title', 'Pengajuan Surat')

@section('header')
    <style>
        .docx-wrapper {
            overflow-x: auto;
        }

        .docx-wrapper>section.docx {
            margin-left: 33.5rem !important;
        }

        @media screen and (min-width: 768px) {
            .docx-wrapper>section.docx {
                margin-left: 9rem !important;
            }
        }

        @media screen and (min-width: 1024px) {
            .docx-wrapper>section.docx {
                margin-left: 0px !important;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Pengajuan Surat</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-striped table-bordered text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Penduduk</th>
                                <th>NIK</th>
                                <th>Jenis Surat</th>
                                <th>No. Surat</th>
                                <th>No. Whatsapp</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Konfirmasi Hapus Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data pengajuan surat ini? Aksi ini tidak dapat dibatalkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="downloadModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="downloadModalLabel">Download Pengajuan Surat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body overflow-x-auto">
                    <div id="displayEletter"></div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <a id="btnDownloadEletter" class="btn btn-secondary">Download <i class="ti ti-download"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/docx-preview@0.3.7/dist/docx-preview.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,
                ajax: "{{ route('admin.e-letter.submission.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'resident_name',
                        name: 'resident_name',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'national_id',
                        name: 'national_id'
                    },
                    {
                        data: 'e_letter_template.name',
                        name: 'e_letter_template.name',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'letter_number',
                        name: 'letter_number'
                    },
                    {
                        data: 'whatsapp_number',
                        name: 'whatsapp_number'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            var buttonTrigger = $(event.relatedTarget);
            var deleteUrl = buttonTrigger.data('delete-url');

            $(this).find('form').attr('action', deleteUrl);
        });

        $('#downloadModal').on('show.bs.modal', function(event) {
            var buttonTrigger = $(event.relatedTarget);
            var downloadUrl = buttonTrigger.data('download-url');

            $('#btnDownloadEletter').attr('href', downloadUrl);
            renderDocxFromUrl('displayEletter', downloadUrl);
        });

        async function fetchDocxAsArrayBuffer(url) {
            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error(`Gagal memuat file: Status ${response.status}`);
                }

                const arrayBuffer = await response.arrayBuffer();
                return arrayBuffer;

            } catch (error) {
                alert("Kesalahan saat mengambil dokumen:", error);
                throw new Error("Gagal mengambil file DOCX.");
            }
        }

        async function renderDocxFromUrl(container_id, docx_url) {
            const containerElement = document.getElementById(container_id);

            if (!containerElement) {
                alert(`Elemen dengan ID '${container_id}' tidak ditemukan.`);
                return;
            }

            if (docx_url === "GANTI_DENGAN_URL_FILE_ANDA" || !docx_url) {
                containerElement.innerHTML =
                    '<p style="color: red;" class="w-100 text-center">ERROR: URL dokumen belum diatur.</p>';
                return;
            }

            containerElement.innerHTML = '<p class="w-100 text-center">Memuat dokumen, mohon tunggu...</p>';

            try {
                const docData = await fetchDocxAsArrayBuffer(docx_url);

                if (typeof docx === 'undefined' || !docx.renderAsync) {
                    throw new Error("Library docx.js tidak terdefinisi atau method renderAsync tidak ditemukan.");
                }

                docx.renderAsync(docData, containerElement)
                    .then(() => {
                        console.log("docx: finished rendering");
                    })
                    .catch(err => {
                        alert("Error rendering docx:", err);
                        containerElement.innerHTML =
                            '<p style="color: red;" class="w-100 text-center">Kesalahan saat merender dokumen Word.</p>';
                    });

            } catch (error) {
                alert(error.message);
                containerElement.innerHTML = `<p style="color: red;" class="w-100 text-center">${error.message}</p>`;
            }
        }
    </script>
@endsection
