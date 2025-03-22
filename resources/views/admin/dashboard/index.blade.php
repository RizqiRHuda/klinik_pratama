@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>

                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0"></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Rujuk (/hari)</h6>
                    <h4 class="mb-3">{{ number_format($terapi_rujuk) }}
                        <span class="badge bg-light-primary border border-primary">
                            <i class="fa fa-users text-primary"></i> <!-- Ikon FontAwesome -->
                        </span>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Total Rawat Jalan (/hari)</h6>
                    <h4 class="mb-3">{{ number_format($terapi_jalan) }}
                        <span class="badge bg-light-success border border-success">
                            <i class="fa fa-users text-success"></i> <!-- Ikon FontAwesome -->
                        </span>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Grafik Terapi Rujuk & Rawat Jalan ({{ $year }})</h6>
            <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        var options = {
            chart: {
                type: 'line',
                height: 350
            },
            series: [
                {
                    name: "Terapi Rujuk",
                    data: @json($rujuk)
                },
                {
                    name: "Terapi Rawat Jalan",
                    data: @json($jalan)
                }
            ],
            xaxis: {
                categories: [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ],
                title: {
                    text: "Bulan"
                }
            },
            yaxis: {
                title: {
                    text: "Jumlah Pasien"
                }
            },
            colors: ['#FF4560', '#008FFB'],
            stroke: {
                curve: 'smooth'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>
    
    @endpush
@endsection
