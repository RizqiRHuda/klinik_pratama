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
                        <li class="breadcrumb-item"><a href="">Terapi</a></li>

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
                <div id="sticky-action" class="sticky-action">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="no_rm">No. RM</label>
                                    <input type="text" class="form-control" id="no_rm"
                                        placeholder="Masukkan No. RM...">
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                                <button type="button" class="btn btn-success cari">Cari</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <h5>Data Pasien</h5>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label">No. RM</label>
                                <input type="text" class="form-control" id="data_no_rm" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">NIK</label>
                                <input type="text" class="form-control" id="data_nik" readonly>
                            </div>

                            <div class="form-group">
                                <label class="form-label">No Telepon</label>
                                <input type="text" class="form-control" id="data_no_hp" readonly>
                            </div>

                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control" id="data_nama_pasien" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <input type="text" class="form-control" id="data_jk" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="data_alamat" readonly></input>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" id="data_tgl_lahir" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="data_pekerjaan" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alergi</label>
                                <input type="text" class="form-control" id="data_alergi" readonly>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <h5 class="mt-2">Form Grid</h5>
                    <hr>
                    <form>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label" for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="inputAddress2">Address 2</label>
                            <input type="text" class="form-control" id="inputAddress2"
                                placeholder="Apartment, studio, or floor">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="inputCity">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label" for="inputState">State</label>
                                <select id="inputState" class="form-select">
                                    <option selected>select</option>
                                    <option>Large select</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label" for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">Check me out</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            // Fungsi untuk mencari pasien
            function cariPasien() {
                var no_rm = $("#no_rm").val().trim(); // Ambil input & hapus spasi

                if (no_rm.length > 0) {
                    $.ajax({
                        url: "/terapi/cari-pasien/" + no_rm,
                        type: "GET",
                        success: function(data) {
                            if (data) {
                                // Isi input field dengan data pasien
                                $("#data_no_rm").val(data.no_rm);
                                $("#data_nama_pasien").val(data.nama_pasien);
                                $("#data_nik").val(data.nik);
                                $("#data_alamat").val(data.alamat);
                                $("#data_no_hp").val(data.no_hp ?? '-');
                                $("#data_tgl_lahir").val(data.tgl_lahir);
                                $("#data_jk").val(data.jk === 'L' ? 'Laki-laki' : 'Perempuan');
                                $("#data_alergi").val(data.riwayat_alergi ?? '-');
                                $("#data_pekerjaan").val(data.pekerjaan ?? '-');
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: "error",
                                title: "Pasien Tidak Ditemukan!",
                                text: "Periksa kembali No. RM yang dimasukkan.",
                                confirmButtonText: "OK",
                                timer: 3000
                            });

                            // Kosongkan input jika tidak ditemukan
                            $("#data_no_rm, #data_nama_pasien, #data_nik, #data_alamat, #data_no_hp, #data_tgl_lahir, #data_jk, #data_alergi, #data_pekerjaan")
                                .val("");
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Masukkan No. RM!",
                        text: "Kolom No. RM tidak boleh kosong.",
                        confirmButtonText: "OK",
                        timer: 2000
                    });
                }
            }

            // Event klik tombol "Cari"
            $(".btn-success").click(function() {
                cariPasien();
            });

            // Event tekan tombol "Enter" di input No. RM
            $("#no_rm").keypress(function(event) {
                if (event.which === 13) { // 13 = kode tombol Enter
                    event.preventDefault(); // Hindari submit form bawaan
                    cariPasien(); // Jalankan fungsi pencarian
                }
            });
        });
    </script>
@endpush
@endsection
