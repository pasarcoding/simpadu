@extends('user.layouts.app')

@section('title', 'Data Statistik')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/custom.chart.css') }}">
    <style>
        table thead tr th {
            background-color: #C0DBFE !important;
            color: #6A6A6A !important;
            font-weight: 500;
        }

        table tbody tr td {
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')
    <section style="margin: 2rem 0px">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 mb-5">
                    <div class="card shadow shadow-sm rounded-4">
                        <div class="card-body pt-4">
                            <div class="row justify-content-center mt-2">
                                <div class="col-12 col-md-6 col-lg-4 mb-4 civilStatisticWrapper">
                                    <div class="d-flex flex-column align-items-center" style="height: 20rem;">
                                        <span class="fs-5 fw-semibold mb-2">Data Penduduk Berdasarkan Jenis Kelamin</span>
                                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                                            <canvas id="genderStatistic" class="w-100 h-100"></canvas>
                                        </div>
                                        <div id="gender-legend" class="legend-scroll-wrapper"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mb-4 civilStatisticWrapper">
                                    <div class="d-flex flex-column align-items-center" style="height: 20rem;">
                                        <span class="fs-5 fw-semibold mb-2">Data Penduduk Berdasarkan Agama</span>
                                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                                            <canvas id="religionStatistic" class="w-100 h-100"></canvas>
                                        </div>
                                        <div id="religion-legend" class="legend-scroll-wrapper"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mb-4 civilStatisticWrapper">
                                    <div class="d-flex flex-column align-items-center" style="height: 20rem;">
                                        <span class="fs-5 fw-semibold mb-2">Data Penduduk Berdasarkan Pekerjaan</span>
                                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                                            <canvas id="jobStatistic" class="w-100 h-100"></canvas>
                                        </div>
                                        <div id="job-legend" class="legend-scroll-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($budgetProgress as $i => $item)
                    <div class="col-12 col-md-6 col-lg-4 mb-5">
                        <div class="card shadow rounded-4 overflow-hidden">
                            <div class="card-header bg-white">
                                <div class="card-title text-center text-truncate fs-5 fw-semibold">{{ $item->title }}
                                </div>
                            </div>
                            <div class="card-body overflow-hidden">
                                <div class="d-flex justify-content-center py-3 position-relative">
                                    <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/61dc37eb166d8.webp"
                                        alt="" class="position-absolute opacity-50"
                                        style="bottom: -30px; right: -30px; width: 200px" />
                                    <div class="position-relative" style="width: 60%">
                                        <div id="budget-progress-{{ $i }}"></div>
                                        <div class="d-flex flex-column justify-content-center align-items-center position-absolute w-100 h-100"
                                            style="top: 0; left: 0">
                                            <div class="d-flex justify-content-center align-items-start">
                                                <span class="fw-bold">Rp</span>
                                                <span
                                                    class="fs-4 fw-bold">{{ rupiah_formatted($item->total_out, '') }}</span>
                                            </div>
                                            <span class="fw-semibold" style="font-size: 13px">Total :
                                                {{ rupiah_formatted($item->total_in) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @foreach ($budgetTables as $item)
                    <div class="col-12 mb-4">
                        <div class="card border border-2 border-top-0"
                            style="border-color: var(--color-primary-app)!important;">
                            <div class="card-header bg-app py-3">
                                <div class="fw-semibold text-white" style="font-size: 1.1rem;">
                                    {{ $item->title }}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Kode Rekening/Uraian</th>
                                                <th>Anggaran</th>
                                                <th>Realisasi</th>
                                                <th>Lebih/Kurang</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>{{ $item->bank_number }}</td>
                                                <td>{{ rupiah_formatted($item->total_in) }}</td>
                                                <td>{{ rupiah_formatted($item->total_out) }}</td>
                                                <td>{{ rupiah_formatted($item->total_in - $item->total_out) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section style="margin-bottom: 4rem">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card rounded-4 bg-app-gradient">
                        <div class="card-body py-4 position-relative">
                            <div class="position-absolute h-100 opacity-50" style="top: 0; right: 0">
                                <img src="https://wpndeso.rrdigital.id/wp-content/uploads/2023/08/CS-Overlay.png"
                                    alt="" class="h-100" />
                            </div>
                            <div class="container-fluid position-relative">
                                <div class="row mb-4 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex flex-column">
                                            <span class="fs-4 fw-semibold mb-2 text-white">Pengaduan Desa</span>
                                            <div class="bg-app-secondary rounded-pill" style="height: 4px; width: 90px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12 text-white fs-5 fw-semibold mb-2 mb-md-0">
                                        Apabila Anda Memiliki Keluhan dan Dan Permasalahan bisa
                                        klik button di bawah ini !
                                    </div>
                                    <div class="col-12 text-white">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Sed egestas felis nec massa ornare blandit.
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <a href="{{ route('user.e-letter.index') }}"
                                            class="btn btn-lg btn-app-secondary rounded-pill border border-3 border-info border-opacity-50 px-4 text-white d-inline-flex align-items-center gap-2">
                                            <span style="font-size: 13px">Pengajuan Surat</span>
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
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

@section('footer')
    <script src="{{ asset('js/custom.chart.js') }}"></script>
    <script>
        $(document).ready(function() {
            function chartInit(elId, legendId, label, value) {
                const chartConfig = {
                    type: "doughnut",
                    data: {
                        labels: label,
                        datasets: [{
                            // label: "Nilai Data",
                            data: value,
                            backgroundColor: ['#4DC9F6', '#F7464A', '#FDB45C', '#949FB1', '#46BFBD',
                                '#8064A1', '#FFC0CB', '#B0E0E6', '#98FB98', '#FFD700',
                                '#ADD8E6', '#F08080', '#FFCC99', '#D3D3D3', '#87CEFA', '#6A5ACD',
                                '#EE82EE', '#AFEEEE', '#90EE90', '#FFA07A',
                                '#FF6384', '#36A2EB', '#FFCE56', '#5AD3D1', '#CC65FE', '#CDA79F',
                                '#8A2BE2', '#7FFF00', '#D2B48C', '#E6E6FA'
                            ],
                            hoverOffset: 4,
                        }, ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                                position: "bottom",
                                // labels: {
                                //     usePointStyle: true,
                                //     pointStyle: "rect",
                                // },
                            },
                            tooltip: {
                                callbacks: {
                                    title: () => [],
                                    label: function(tooltipItem) {
                                        return ` ${tooltipItem.label}: ${tooltipItem.formattedValue}`;
                                    }
                                }
                            },
                            htmlLegend: {
                                containerID: legendId,
                            },
                            title: {
                                display: false,
                                text: "Data",
                            },
                        },
                        cutout: "15%",
                    },
                    plugins: [htmlLegendPlugin]
                };

                const chartEl = document.getElementById(elId);
                window.chartInstance = new Chart(chartEl, chartConfig);

                let chartCountResizeTimer;
                $(window).on("resize", function() {
                    clearTimeout(chartCountResizeTimer);
                    chartCountResizeTimer = setTimeout(function() {
                        if (window.chartInstance) {
                            window.chartInstance.destroy();
                        }
                        window.chartInstance = new Chart(
                            chartEl,
                            chartConfig
                        );
                    }, 150);
                });
            }

            chartInit('genderStatistic', 'gender-legend', @json($residentGenders->label),
                @json($residentGenders->value));
            chartInit('religionStatistic', 'religion-legend', @json($residentReligions->label),
                @json($residentReligions->value));
            chartInit('jobStatistic', 'job-legend', @json($residentJobs->label), @json($residentJobs->value));

            @foreach ($budgetProgress as $i => $item)
                const totalIn{{ $i }} = parseInt('{{ $item->total_in }}');
                const totaOut{{ $i }} = parseInt('{{ $item->total_out }}');

                let progressRatio{{ $i }} = 0;
                if (totalIn{{ $i }} > 0) {
                    progressRatio{{ $i }} = totaOut{{ $i }} / totalIn{{ $i }};
                }
                progressRatio{{ $i }} = Math.min(progressRatio{{ $i }}, 1);

                let colorCode{{ $i }} = "#15aa3d";
                if (progressRatio{{ $i }} >= 0.7) {
                    colorCode{{ $i }} = "#DC3545";
                } else if (progressRatio{{ $i }} >= 0.5) {
                    colorCode{{ $i }} = "#FFC107";
                }

                var budgetProgress{{ $i }} = new ProgressBar.Circle(
                    "#budget-progress-{{ $i }}", {
                        color: colorCode{{ $i }},
                        trailColor: "#e0e0e0",
                        strokeWidth: 4,
                        trailWidth: 4,
                        easing: "easeInOut",
                        duration: 1400,
                        strokeLinecap: "round",
                    });
                budgetProgress{{ $i }}.set(progressRatio{{ $i }});
            @endforeach
        });
    </script>
@endsection
