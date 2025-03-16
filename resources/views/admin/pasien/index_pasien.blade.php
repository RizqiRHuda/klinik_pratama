@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0)">Biodata</a></li>

                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <h5>Regristrasi Pasien</h5>
        </div>
        <div class="card-body">
            <form id="formPasien" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kolom Kiri -->
                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <label for="no_rm" class="col-sm-3 col-form-label">No. RM</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_rm" name="no_rm">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nik" name="nik">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tgl_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jk" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-9">
                                <select class="form-select" id="jk" name="jk">
                                    <option value="">Pilih</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="no_hp" class="col-sm-3 col-form-label">No. Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_hp" name="no_hp">
                            </div>
                        </div>
                    </div>
            
                    <!-- Kolom Kanan -->
                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <label for="nama_pasien" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="alamat" rows="3" name="alamat"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alergi" class="col-sm-2 col-form-label">Alergi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alergi" name="riwayat_alergi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pekerjaan" class="col-sm-2 col-form-label" style="font-size: 13.5px">Pekerjaan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control me-2" id="pekerjaan" name="pekerjaan">
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Tombol Submit di Tengah -->
                <div class="row">
                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <button type="reset" class="btn btn-secondary mt-3 btn-sm">Reset</button>
                        <button type="submit" class="btn btn-primary mt-3 btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Tabel Data Pasien</h5>

            </div>
            <div class="card-body">
                <div class="dt-responsive table-responsive">
                    <table id="data-pasien" class="table compact table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th>No</th> <!-- Kolom Penomoran -->
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Tgl Lahir</th>
                                <th>JK</th>
                                <th>Pekerjaan</th>
                                <th>Alergi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>No. HP</th>
                                <th>Tgl Lahir</th>
                                <th>JK</th>
                                <th>Pekerjaan</th>
                                <th>Alergi</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
    @include('admin.pasien.edit_pasien')
    @push('scripts')
    @include('admin.pasien.script-pasien')
    @endpush
@endsection

