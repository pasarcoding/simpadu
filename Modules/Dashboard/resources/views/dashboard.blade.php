@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/custom.chart.css') }}">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Jumlah Penduduk</h6>
                    <h4 class="mb-0">{{ rupiah_formatted($residentCount, '') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Jumlah Berita</h6>
                    <h4 class="mb-0">{{ rupiah_formatted($newsCount, '') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Jumlah Pengajuan Pending</h6>
                    <h4 class="mb-0">{{ rupiah_formatted($eLetterPendingCount, '') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Jumlah Pengajuan Selesai</h6>
                    <h4 class="mb-0">{{ rupiah_formatted($eLetterSuccessCount, '') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Jumlah Pengajuan Ditolak</h6>
                    <h4 class="mb-0">{{ rupiah_formatted($eLetterRejectCount, '') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-4 civilStatisticWrapper">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center" style="height: 20rem;">
                        <span class="fs-6 fw-semibold mb-2 text-center">Data Penduduk Berdasarkan Jenis Kelamin</span>
                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                            <canvas id="genderStatistic" class="w-100 h-100"></canvas>
                        </div>
                        <div id="gender-legend" class="legend-scroll-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-4 civilStatisticWrapper">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center" style="height: 20rem;">
                        <span class="fs-6 fw-semibold mb-2 text-center">Data Penduduk Berdasarkan Agama</span>
                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                            <canvas id="religionStatistic" class="w-100 h-100"></canvas>
                        </div>
                        <div id="religion-legend" class="legend-scroll-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-4 civilStatisticWrapper">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center" style="height: 20rem;">
                        <span class="fs-6 fw-semibold mb-2 text-center">Data Penduduk Berdasarkan Pekerjaan</span>
                        <div class="flex-grow-1 min-h-0" style="min-height: 0 !important">
                            <canvas id="jobStatistic" class="w-100 h-100"></canvas>
                        </div>
                        <div id="job-legend" class="legend-scroll-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/custom.chart.js') }}"></script>
    <script>
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
    </script>
@endsection
