@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0)">Data Obat</a></li>

                </ul>
            </div>
            <div class="col-md-12">
                <div class="page-header-title">
                    <h2 class="mb-0">Tabel Obat</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- [ basic-table ] start -->
    <div class="col-xl-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tabel Obat</h5>
            <div>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalObat">
                <i class="fas fa-file-alt"></i> Tambah
              </button>
                @include('admin.obat.form')
                <button type="button" class="btn btn-info btn-sm"  data-bs-toggle="modal" data-bs-target="#uploadExcelModal"> <i class="fas fa-file-excel me-1"></i> Upload Excel</button>
            </div>
        </div>
        
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-column-manipulation">
                        <table id="table-obat" class="display table table-striped table-hover dt-responsive nowrap"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Obat</th>
                                    <th>Stock Awal</th>
                                    <th>Pemakaian</th>
                                    <th>Pemasukan</th>
                                    <th>Stock Akhir</th>
                                    <th>Min Stock</th>
                                    <th>Satuan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="uploadExcelModal" tabindex="-1" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="uploadExcelModalLabel">
                  <i class="fas fa-file-excel text-success"></i> Upload File Excel
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="{{ route('obat.import-obat') }}" enctype="multipart/form-data"  method="POST">
                  @csrf
                  <div class="input-group input-group-sm">
                      <span class="input-group-text"><i class="fas fa-file-excel text-success"></i></span>
                      <input type="file" name="file" class="form-control form-control-sm" accept=".xls,.xlsx" required>
                  </div>
                  <div class="text-end mt-3">
                      <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                          <i class="fas fa-times"></i> Batal
                      </button>
                      <button type="submit" class="btn btn-success btn-sm">
                          <i class="fas fa-upload"></i> Upload
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
    @push('scripts')
    <script>
       $(document).ready(function() {
        // Inisialisasi DataTables
        let table = $('#table-obat').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('obat.get-obat') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'stock_awal', name: 'stock_awal' },
                { data: 'pemakaian', name: 'pemakaian' },
                { data: 'pemasukan', name: 'pemasukan' },
                { data: 'stock_akhir', name: 'stock_akhir' },
                { data: 'min_stock', name: 'min_stock' },
                { data: 'satuan', name: 'satuan' },
                { 
                    data: 'status_stock', 
                    name: 'status_stock',
                    render: function(data, type, row) {
                        let badgeClass = (data === 'Aman') ? 'bg-success text-white' : 'bg-danger text-white';
                        return `
                            <div class="d-flex justify-content-center align-items-center">
                                <span class="badge ${badgeClass}">${data}</span>
                            </div>
                        `;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        // Form Submit Tambah Obat
        $("#formObat").submit(function(e) {
            e.preventDefault(); // Hindari reload halaman

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('obat.simpan-obat') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        $("#modalObat form").modal('hide'); // Tutup modal
                        $("#formObat")[0].reset(); // Reset form
                        table.ajax.reload(); // Reload DataTables
                        alert(response.message); // Notifikasi sukses
                    } else {
                        alert("Gagal menyimpan data!");
                    }
                },
                error: function(xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseJSON.message);
                }
            });
        });

    });
    </script>
    @endpush
@endsection
