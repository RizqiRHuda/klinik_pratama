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
                            $(".id_pasien").val(data.id);
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

        // Inisialisasi datepicker
        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
            todayBtn: "linked",
            language: 'id'
        });

        // Fungsi untuk mengisi dropdown dengan data obat
        function fillDropdown(selectElement, data) {
            selectElement.empty().append('<option value="">Pilih Obat</option>');
            data.forEach(function(obat) {
                selectElement.append(`<option value="${obat.id}">${obat.nama_obat}</option>`);
            });
            selectElement.select2({
                width: '100%'
            }); // Inisialisasi select2
        }

        // AJAX untuk mengambil data obat
        $.ajax({
            url: '{{ route('terapi.obat-terapi') }}',
            method: 'GET',
            success: function(data) {
                window.obatData = data; // Simpan data obat ke variabel global
                fillDropdown($(".select-obat").first(), data); // Isi dropdown pertama
            },
            error: function(xhr, status, error) {
                console.error("Terjadi kesalahan: ", error);
            }
        });

        // Event untuk menambahkan baris baru
        $(document).on('click', '.btn-add', function() {
            let row = `
                <tr>
                    <td>
                        <select class="form-select obat select-obat" name="obat[]" >
                            <option value="">Pilih Obat</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control pengeluaran" name="pengeluaran[]" placeholder="0" >
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </td>
                </tr>
            `;
            $('#obat-container').append(row);

            // Isi dropdown yang baru ditambahkan dengan data obat
            let newSelect = $('#obat-container .select-obat').last();
            fillDropdown(newSelect, window.obatData);
        });

        // Event untuk menghapus baris
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

     
    });
</script>
