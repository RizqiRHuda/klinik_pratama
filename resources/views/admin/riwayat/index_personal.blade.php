@extends('layouts.app')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="">Riway Terapi Pasien</a></li>

                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        {{-- <h2 class="mb-0">Sticky Action Bar</h2> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ form-element ] start -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>Terapi Pasien Personal</h5>
                </div>
               
                <div>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="no_rm"></label>
                                    <input type="text" class="form-control" id="no_rm"
                                        placeholder="Masukkan No. RM...">
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-start  mt-sm-0">
                                <button type="button" class="btn btn-success get-pasien mt-3 mb-2">Cari</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h5>Nama : <span id="nama_pasien"></span></h5>
                    
                        <!-- Menambahkan elemen untuk detail pasien -->
                        <div class="row g-3">
                            <div class="col-md-6"><label class="fw-bold">No RM:</label> <span id="detail_no_rm"></span></div>
                            <div class="col-md-6"><label class="fw-bold">NIK:</label> <span id="detail_nik"></span></div>
                            <div class="col-md-6"><label class="fw-bold">Alamat:</label> <span id="detail_alamat"></span></div>
                            <div class="col-md-6"><label class="fw-bold">No HP:</label> <span id="detail_no_hp"></span></div>
                            <div class="col-md-6"><label class="fw-bold">Tanggal Lahir:</label> <span id="detail_tgl_lahir"></span></div>
                            <div class="col-md-6"><label class="fw-bold">Jenis Kelamin:</label> <span id="detail_jk"></span></div>
                            <div class="col-md-6"><label class="fw-bold">Pekerjaan:</label> <span id="detail_pekerjaan"></span></div>
                            <div class="col-12"><label class="fw-bold">Riwayat Alergi:</label> <span id="detail_riwayat_alergi"></span></div>
                        </div>
                    
                        <hr>
                    
                        <!-- Menambahkan section untuk Data Terapi -->
                        <h6 class="mb-3">Data Terapi</h6>
                        <div id="detail_terapi"></div>
                    
                    </div>
                    
                </div>

            </div>
        </div>
    </div>

</div>
@push('scripts')
   
<script>
    function getPasien() {
        var no_rm = $("#no_rm").val().trim();
        if (no_rm.length > 0) {
            $.ajax({
                url: "/riwayat/get-riwayat/" + no_rm,
                type: "GET",
                success: function (data) {
                    if (data.length > 0) {
                        // ========================
                        // TAMPILKAN DATA PASIEN
                        // ========================
                        console.log(data);
                        
                        const pasien = data[0].pasien;
    
                        $("#detail_no_rm").text(pasien.no_rm);
                        $("#nama_pasien").text(pasien.nama_pasien);
                        $("#detail_nik").text(pasien.nik);
                        $("#detail_alamat").text(pasien.alamat);
                        $("#detail_no_hp").text(pasien.no_hp);
                        $("#detail_tgl_lahir").text(pasien.tgl_lahir);
                        $("#detail_jk").text(pasien.jenis_kelamin);
                        $("#detail_pekerjaan").text(pasien.pekerjaan);
                        $("#detail_riwayat_alergi").text(pasien.riwayat_alergi);
    
                        // ========================
                        // MENAMPILKAN RIWAYAT TERAPI
                        // ========================
                        $("#detail_terapi").empty(); // Clear previous details
                        data.forEach(function (terapi) {
                            const pemeriksaan = JSON.parse(terapi.pemeriksaan || '{}');
                            const jenisLayanan = terapi.jenis_layanan?.nama || '-';
    
                            // Menampilkan data terapi
                            let detailTerapi = `
                                <div class="row g-3 mb-4 border-bottom pb-3">
                                    <div class="col-md-6"><label class="fw-bold">Tanggal Terapi:</label> ${terapi.tgl_terapi}</div>
                                    <div class="col-md-6"><label class="fw-bold">Anamnesa:</label> ${terapi.anamnesa}</div>
                                    <div class="col-md-6"><label class="fw-bold">Diagnosa:</label> ${terapi.diagnosa}</div>
                                    <div class="col-md-6"><label class="fw-bold">Jenis Layanan:</label> ${jenisLayanan}</div>
                                    <div class="col-12">
                                        <label class="fw-bold">Pemeriksaan:</label>
                                        <ul>
                                            <li>TB: ${pemeriksaan.tb || '-'}</li>
                                            <li>BB: ${pemeriksaan.bb || '-'}</li>
                                            <li>Suhu: ${pemeriksaan.suhu || '-'}</li>
                                            <li>Tensi: ${pemeriksaan.tensi || '-'}</li>
                                            <li>Nadi: ${pemeriksaan.nadi || '-'}</li>
                                            <li>Pernapasan: ${pemeriksaan.pernafasan || '-'}</li>
                                        </ul>
                                    </div>
                            `;
    
                            // Menampilkan data obat dalam terapi
                            let listObat = '';
                            if (terapi.obat && terapi.obat.length > 0) {
                                listObat += '<ul>';
                                    terapi.obat.forEach(function (o) {
                                        listObat += `<li>
                                            ${o.nama_obat} (${o.satuan || '-'}) 
                                            \n Jumlah: ${o.pivot?.jumlah_obat || '-'}
                                        </li>`;
                                    });

                                listObat += '</ul>';
                            } else {
                                listObat = '<ul><li>Tidak ada obat yang diberikan.</li></ul>';
                            }
    
                            // Menambahkan data obat ke detail terapi
                            detailTerapi += `
                                <div class="col-12">
                                    <label class="fw-bold">Obat:</label>
                                    ${listObat}
                                </div>
                            </div>
                            `;
    
                            // Menambahkan detail terapi ke halaman
                            $("#detail_terapi").append(detailTerapi);
                        });
    
                    } else {
                        alert("Data tidak ditemukan");
                    }
                }
            });
        } else {
            alert("Nomor RM tidak boleh kosong.");
        }
    }
    
    $(".get-pasien").click(function () {
        getPasien();
    });
    
    $("#no_rm").keypress(function(event) {
        if(event.which === 13) {
            event.preventDefault();
            getPasien();
        }
    });
    </script>
    
@endpush
@endsection