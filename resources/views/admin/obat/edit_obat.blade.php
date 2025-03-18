<!-- Modal Edit -->
<div class="modal fade" id="modalEditObat" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="formEditObat" autocomplete="off">
                <div class="modal-body">
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- ID (Hidden, tidak bisa diedit) -->
                    <input type="hidden" id="edit_id" name="id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="edit_nama_obat" name="nama_obat" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="edit_satuan" name="satuan" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_pemakaian" class="form-label">Pemakaian</label>
                            <input type="number" class="form-control" id="edit_pemakaian" name="pemakaian" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_pemasukan" class="form-label">Pemasukan</label>
                            <input type="number" class="form-control" id="edit_pemasukan" name="pemasukan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="edit_stock_awal" class="form-label">Stock Awal</label>
                            <input type="number" class="form-control" id="edit_stock_awal" name="stock_awal" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_min_stock" class="form-label">Minimal Stock</label>
                            <input type="number" class="form-control" id="edit_min_stock" name="min_stock" required>
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
