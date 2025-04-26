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
                <div class="card-header">
                    <h5>Terapi-Pasien</h5>
                </div>
                {{-- <div id="sticky-action" class="sticky-action"> --}}
                <div>
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label" for="no_rm">No. RM</label>
                                    <input type="text" class="form-control" id="no_rm"
                                        placeholder="Masukkan No. RM...">
                                </div>
                            </div>
                            <div class="col-sm-6 text-sm-start mt-3 mt-sm-0">
                                <button type="button" class="btn btn-success cari-pasien mt-3">Cari</button>
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
                    <form id="formterapi">
                        @csrf
                        <h5 class="mt-2 text-center">Formulir Data Terapi</h5>
                        <hr>
                        <div class="row align-items-center justify-content-between">
                            <div class="col-md-3">
                                <input type="hidden" class="form-control id_pasien" id="id_pasien" name="id_pasien">
                                <label class="form-label" for="">Tanggal</label>
                                <input type="text" id="datepicker" name="tgl_terapi" class="form-control">
                            </div>
                            <div class="col-md-3 text-start">
                                <label class="form-label" for="">Jenis Layanan</label>
                                <div class="btn-group" role="group" aria-label="Jenis Pelayanan">
                                    <input type="radio" class="btn-check" name="jenis_pelayanan" id="rujuk"
                                        value="rujuk">
                                    <label class="btn btn-outline-primary btn-sm" for="rujuk">Rujuk</label>

                                    <input type="radio" class="btn-check" name="jenis_pelayanan" id="rawat_jalan"
                                        value="rawat_jalan">
                                    <label class="btn btn-outline-primary btn-sm" for="rawat_jalan">Rawat
                                        Jalan</label>

                                    <input type="radio" class="btn-check" name="jenis_pelayanan" id="batal"
                                        value="batal">
                                    <label class="btn btn-outline-primary btn-sm" for="batal">Batal</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label class="form-label" for="">Anamnesa</label>
                                <input type="text" class="form-control" id="anamnesa" name="anamnesa">
                            </div>
                        </div>

                        <h5 class="mt-2">Pemeriksaan</h5>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">TB (cm)</label>
                                <input type="text" class="form-control" name="tb">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">BB (kg)</label>
                                <input type="text" class="form-control" name="bb">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Suhu (°C)</label>
                                <input type="text" class="form-control" name="suhu">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tensi (mmHg)</label>
                                <input type="text" class="form-control" name="tensi">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Nadi (bpm)</label>
                                <input type="text" class="form-control" name="nadi">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Pernafasan (x/menit)</label>
                                <input type="text" class="form-control" name="pernafasan">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label class="form-label" for="diagnosa">Diagnosa</label>
                                <input type="text" class="form-control" id="diagnosa" name="diagnosa">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label class="form-label" for="tindakan">Terapi</label>
                                <input type="text" class="form-control" id="tindakan" name="tindakan">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="mt-3">Pengobatan</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Obat</th>
                                                <th>Pengeluaran</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="obat-container">
                                            <tr>
                                                <td>
                                                    <select class="form-select obat select-obat" name="obat[]">
                                                        <option value="">Pilih Obat</option>
                                                        <!-- Populate with available drugs dynamically -->

                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control pengeluaran"
                                                        name="pengeluaran[]" placeholder="0">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-add">+</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

</div>
@push('scripts')
    @include('admin.terapi.script_terapi')
    <script>
        $(document).ready(function() {
            // Ketika form disubmit
            $('#formterapi').submit(function(e) {
                e.preventDefault(); // Mencegah halaman reload saat submit form

                var formData = new FormData(this); // Mengambil data form

                // Kirim data dengan AJAX
                $.ajax({
                    url: '{{ route('terapi.simpan-terapi') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#formterapi')[0].reset(); // Reset form jika diperlukan
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan data!',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                });

            });
        });
    </script>
@endpush
@endsection
