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
        <div class="col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 f-w-400 text-muted">Grafik Terapi Rujuk & Rawat Jalan ({{ $year }})</h6>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body pc-component">
                    <h5 class="mb-3">Table Obat</h5>
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active text-uppercase" id="home-tab" data-bs-toggle="tab" href="#home"
                                role="tab" aria-controls="home" aria-selected="true">Obat Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase" id="profile-tab" data-bs-toggle="tab" href="#profile"
                                role="tab" aria-controls="profile" aria-selected="false">Obat Aman</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ url('/dashboard/export-obat-order') }}" class="btn btn-success export-btn">
                                    <i class="fas fa-file-excel"></i> Export Obat Order
                                </a>
                                <div class="spinner-border text-success ms-2 d-none" role="status" id="loading-spinner">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <table class="table table-bordered" id="obat_order">
                                <thead class="table-danger">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th>
                                        <th>Stock Awal</th>
                                        <th>Pemakaian</th>
                                        <th>Pemasukan</th>
                                        <th>Stock Akhir</th>
                                        <th>Minimal Stock</th>
                                        <th>Status Stock</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obatOrder as $index => $obat)
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $obat->nama_obat }}</td>
                                            <td>{{ $obat->stock_awal }}</td>
                                            <td>{{ $obat->pemakaian }}</td>
                                            <td>{{ $obat->pemasukan }}</td>
                                            <td>{{ $obat->stock_akhir }}</td>
                                            <td>{{ $obat->min_stock }}</td>
                                            <td><span class="badge bg-danger">{{ $obat->status_stock }}</span></td>
                                            
                                            <td>{{ $obat->satuan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                       
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <table class="table table-bordered" id="obat_aman">
                                <thead class="table-success">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Obat</th>
                                        <th>Stock Awal</th>
                                        <th>Pemakaian</th>
                                        <th>Pemasukan</th>
                                        <th>Stock Akhir</th>
                                        <th>Minimal Stock</th>
                                        <th>Status</th>
                                        <th>Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($obatAman as $index => $obat)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $obat->nama_obat }}</td>
                                            <td>{{ $obat->stock_awal }}</td>
                                            <td>{{ $obat->pemakaian }}</td>
                                            <td>{{ $obat->pemasukan }}</td>
                                            <td>{{ $obat->stock_akhir }}</td>
                                            <td>{{ $obat->min_stock }}</td>
                                            <td><span class="badge bg-success">{{ $obat->status_stock }}</span></td>
                                            <td>{{ $obat->satuan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var options = {
                    chart: {
                        type: 'line',
                        height: 350
                    },
                    series: [{
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
        <script>
            $(document).ready(function () {
                $('#obat_aman, #obat_order').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "lengthMenu": [5, 10, 25, 50, 100],
                    "language": {
                        "search": "Cari Obat:",
                        "lengthMenu": "Tampilkan _MENU_ data"
                    }
                });
            });

            document.querySelector('.export-btn').addEventListener('click', function () {
                document.getElementById('loading-spinner').classList.remove('d-none');
                setTimeout(() => {
                    document.getElementById('loading-spinner').classList.add('d-none');
                }, 3000);
            });
        </script>
    @endpush
@endsection
