<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Menggunakan modal-lg untuk ukuran besar -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditPasien" autocomplete="off">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- ID (Hidden, tidak bisa diedit) -->
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row">
                        <!-- Bagian Kiri -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control" id="edit_nama_pasien" name="nama_pasien">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="text" class="form-control" id="edit_no_hp" name="no_hp">
                            </div>
                        </div>

                        <!-- Bagian Kanan -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-control" id="edit_jk" name="jk">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="edit_pekerjaan" name="pekerjaan">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Riwayat Alergi</label>
                                <textarea class="form-control" id="edit_riwayat_alergi" name="riwayat_alergi"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
