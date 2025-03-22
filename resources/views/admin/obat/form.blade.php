<div class="modal fade" id="modalObat" tabindex="-1" aria-labelledby="modalObatLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalObatLabel"><i class="fas fa-pills"></i> Tambah Data Obat</h5>
                <button type="button" class="btn-close" id="createCloseButton" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="" id="formObat" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_obat" class="form-label">Nama Obat</label>
                                        <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock_awal" class="form-label">Stock Awal</label>
                                        <input type="number" class="form-control" id="stock_awal" name="stock_awal" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pemakaian" class="form-label">Pemakaian</label>
                                        <input type="number" class="form-control" id="pemakaian" name="pemakaian" required>
                                    </div>
                                </div>
                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pemasukan" class="form-label">Pemasukan</label>
                                        <input type="number" class="form-control" id="pemasukan" name="pemasukan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock_akhir" class="form-label">Stock Akhir</label>
                                        <input type="number" class="form-control" id="stock_akhir" name="stock_akhir">
                                    </div>
                                    <div class="mb-3">
                                        <label for="min_stock" class="form-label">Minimal Stock</label>
                                        <input type="number" class="form-control" id="min_stock" name="min_stock" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Satuan di bawah -->
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div> <!-- Card -->
            </div>
        </div>
    </div>
</div>


