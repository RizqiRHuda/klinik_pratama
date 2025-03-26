@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
      <div class="row align-items-center">
        <div class="col-md-12">
          <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript: void(0)">Data Terapi Pasien</a></li>
          </ul>
        </div>
        <div class="col-md-12">
          <div class="page-header-title">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header table-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Tabel Terapi Pasien</h5>
                        <div class="d-flex align-items-center">
                        
                            <label for="filter-date-from" class="col-form-label me-2">Tanggal</label>
              
                            <div class="input-daterange input-group me-3">
                                <input type="date" id="filter-date-from" class="form-control form-control-sm">
                                <span class="input-group-text">to</span>
                                <input type="date" id="filter-date-to" class="form-control form-control-sm">
                            </div>
                            
                            <button type="button" class="btn btn-primary btn-sm" id="filter-date"><i class="ti ti-filter"></i></button>
                            <button class="btn btn-success btn-sm ms-2" onclick="exportTerapi()"><i class="fa-regular fa-file-excel"></i></button>
                        </div>
                    </div>
            </div>
            
          <div class="card-body">
            <div class="d-flex justify-content-end align-items-center gap-3 mb-3">
              <div class="d-flex align-items-center mb-2 mb-md-0">
                  <label for="filter-pasien" class="col-form-label me-2">No. RM</label>
                  <select id="filter-pasien" class="form-control select2" style="min-width: 200px;">
                      <option value="">Pilih Pasien</option>
                      <!-- Data pasien akan dimuat dengan AJAX -->
                  </select>
              </div>
          
              <button type="button" class="btn btn-primary btn-sm" id="filter-pasien-btn"> <i class="fas fa-filter"></i> Filter Pasien</button>
          </div>
        
            <div class="dt-responsive table-responsive">
                <table id="table-terapi" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Tanggal Terapi</th>
                            <th>Jenis Layanan</th>
                            <th>Anamnesa</th>
                            <th>Diagnosa</th>
                            <th>Pemeriksaan</th>
                            <th>Obat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diambil secara otomatis melalui DataTables -->
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
  </div>
  @include('admin.terapi.modal-detail')
@push('scripts')
<script>
    $(document).ready(function(){
        $('#filter-pasien').select2({
          ajax: {
              url: '{{ route("terapi.get-pasienTerapi") }}',
              dataType: 'json',
              delay: 250,
              processResults: function (data) {
                  return {
                      results: data.map(function (pasien) {
                          return {
                              id: pasien.no_rm,
                              text: pasien.no_rm + ' - ' + pasien.nama_pasien
                          };
                      })
                  };
              },
              cache: true
          }
      });

        var table = $('#table-terapi').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("terapi.table-terapi") }}',
            order: [[3, 'desc']],
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'pasien.no_rm', name: 'pasien.no_rm' },
                { data: 'pasien.nama_pasien', name: 'pasien.nama_pasien' },
                { data: 'tgl_terapi', name: 'tgl_terapi' },
                { data: 'jenisLayanan', name: 'jenisLayanan' },
                { data: 'anamnesa', name: 'anamnesa' },
                { data: 'diagnosa', name: 'diagnosa' },
                { data: 'pemeriksaan', name: 'pemeriksaan', orderable: false, searchable: false },
                { data: 'obat', name: 'obat', orderable: false, searchable: false },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false } 
            ]
        });

        $('#filter-date').click(function(){
            var startDate = $('#filter-date-from').val();
            var endDate = $('#filter-date-to').val();
            if (startDate && endDate) {
                table.ajax.url('{{ route("terapi.table-terapi") }}?start_date=' + startDate + '&end_date=' + endDate).load();
            } else {
                alert('Harap pilih rentang tanggal yang valid!');
            }
        });

        $('#filter-pasien-btn').click(function(){
          var no_rm = $('#filter-pasien').val();
          var url = '{{ route("terapi.table-terapi") }}';
          if (no_rm) {
              url += '?no_rm=' + no_rm;
          }

          table.ajax.url(url).load();
      });

    });

    function exportTerapi()
    {
        let from = document.getElementById('filter-date-from').value;
        let to = document.getElementById('filter-date-to').value;
        window.location.href = `/terapi/laporanTerapi?from=${from}&to=${to}`; 
    }

    function showDetail(id) {
    $.ajax({
        url: `/terapi/getData/${id}/detail`, 
        type: 'GET',
        success: function(response) {
            let terapi = response.terapi;
            let pasien = terapi.pasien;

            // Set Data Pasien
            $('#detail_no_rm').text(pasien.no_rm);
            $('#detail_nama_pasien').text(pasien.nama_pasien);
            $('#detail_nik').text(pasien.nik);
            $('#detail_alamat').text(pasien.alamat);
            $('#detail_no_hp').text(pasien.no_hp);
            $('#detail_tgl_lahir').text(pasien.tgl_lahir);
            $('#detail_jk').text(pasien.jk);
            $('#detail_pekerjaan').text(pasien.pekerjaan);
            $('#detail_riwayat_alergi').text(pasien.riwayat_alergi ?? '-');

            // Set Data Terapi
            $('#detail_tgl_terapi').text(terapi.tgl_terapi);
            $('#detail_anamnesa').text(terapi.anamnesa);
            $('#detail_diagnosa').text(terapi.diagnosa);
            $('#detail_jenis_layanan').text(terapi.jenis_layanan.nama);

            // Set Pemeriksaan
            let pemeriksaanHtml = '';
            if (terapi.pemeriksaan) {
                let pemeriksaan = JSON.parse(terapi.pemeriksaan);
                pemeriksaanHtml += `<li>TB: ${pemeriksaan.tb ?? '-'} cm</li>`;
                pemeriksaanHtml += `<li>BB: ${pemeriksaan.bb ?? '-'} kg</li>`;
                pemeriksaanHtml += `<li>Suhu: ${pemeriksaan.suhu ?? '-'} °C</li>`;
                pemeriksaanHtml += `<li>Tensi: ${pemeriksaan.tensi ?? '-'} mmHg</li>`;
                pemeriksaanHtml += `<li>Nadi: ${pemeriksaan.nadi ?? '-'} bpm</li>`;
                pemeriksaanHtml += `<li>Pernafasan: ${pemeriksaan.pernafasan ?? '-'} x/menit</li>`;
            }
            $('#detail_pemeriksaan').html(pemeriksaanHtml);

            // Set Data Obat
            let obatHtml = '';
            if (terapi.obat.length > 0) {
                terapi.obat.forEach(obat => {
                    obatHtml += `<li>${obat.nama_obat} [${obat.pivot.jumlah_obat} ${obat.satuan}]</li>`;
                });
            } else {
                obatHtml = '<li>Tidak ada obat</li>';
            }
            $('#detail_obat').html(obatHtml);

            // Tampilkan Modal
            $('#modalDetailTerapi').modal('show');
        }
    });
}

</script>
@endpush
@endsection
