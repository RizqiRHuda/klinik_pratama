<!-- Modal Detail Terapi -->
<div class="modal fade" id="modalDetailTerapi" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Terapi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="mb-3">Data Pasien</h6>
                <div class="row g-3">
                    <div class="col-md-6"><label class="fw-bold">No RM:</label> <span id="detail_no_rm"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Nama:</label> <span id="detail_nama_pasien"></span></div>
                    <div class="col-md-6"><label class="fw-bold">NIK:</label> <span id="detail_nik"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Alamat:</label> <span id="detail_alamat"></span></div>
                    <div class="col-md-6"><label class="fw-bold">No HP:</label> <span id="detail_no_hp"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Tanggal Lahir:</label> <span id="detail_tgl_lahir"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Jenis Kelamin:</label> <span id="detail_jk"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Pekerjaan:</label> <span id="detail_pekerjaan"></span></div>
                    <div class="col-12"><label class="fw-bold">Riwayat Alergi:</label> <span id="detail_riwayat_alergi"></span></div>
                </div>
                
                <hr>
                
                <h6 class="mb-3">Data Terapi</h6>
                <div class="row g-3">
                    <div class="col-md-6"><label class="fw-bold">Tanggal Terapi:</label> <span id="detail_tgl_terapi"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Anamnesa:</label> <span id="detail_anamnesa"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Diagnosa:</label> <span id="detail_diagnosa"></span></div>
                    <div class="col-md-6"><label class="fw-bold">Jenis Layanan:</label> <span id="detail_jenis_layanan"></span></div>
                    <div class="col-12">
                        <label class="fw-bold">Pemeriksaan:</label>
                        <div id="detail_pemeriksaan"></div>
                    </div>
                </div>
                
                <hr>
                
                <h6 class="mb-3">Obat</h6>
                <div id="detail_obat"></div>
            </div>
        </div>
    </div>
</div>