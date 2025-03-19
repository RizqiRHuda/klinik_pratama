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
        $(".cari-pasien").click(function() {
            cariPasien();
        });

        // Event tekan tombol "Enter" di input No. RM
        $("#no_rm").keypress(function(event) {
            if (event.which === 13) { // 13 = kode tombol Enter
                event.preventDefault(); // Hindari submit form bawaan
                cariPasien(); // Jalankan fungsi pencarian
            }
        });

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,       
            todayBtn: "linked",
            language: 'id'  
        });

        $(document).on('click', '.btn-add', function() {
            let row = `
                <tr>
                    <td>
                        <select class="form-select obat select-obat" name="obat[]" required>
                            <option value="">Pilih Obat</option>
                            <option value="Paracetamol">Paracetamol</option>
                            <option value="Amoxicillin">Amoxicillin</option>
                            <option value="Ibuprofen">Ibuprofen</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control pengeluaran" name="pengeluaran[]" placeholder="0" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </td>
                </tr>
            `;

            $('#obat-container').append(row);
            $(".select-obat").select2({ width: '100%' }); // Terapkan Select2 pada elemen baru
        });

        // Event Hapus Baris Obat (jika hanya ada 1 baris, tidak bisa dihapus)
        $(document).on('click', '.btn-remove', function() {
            if ($("#obat-container tr").length > 1) {
                $(this).closest('tr').remove();
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Tidak bisa menghapus!",
                    text: "Minimal harus ada satu baris obat.",
                    confirmButtonText: "OK",
                    timer: 2000
                });
            }
        });

        // Inisialisasi Select2 untuk pencarian obat
        $(".select-obat").select2({ width: '100%' });

    });
</script>