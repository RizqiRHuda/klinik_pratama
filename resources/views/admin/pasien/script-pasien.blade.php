<script>
$(document).ready(function() {
    let table = $('#data-pasien').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('pasien.data-pasien') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'no_rm', name: 'no_rm' },
            { data: 'nama_pasien', name: 'nama_pasien' },
            { data: 'nik', name: 'nik' },
            { data: 'alamat', name: 'alamat' },
            { data: 'no_hp', name: 'no_hp' },
            { data: 'tgl_lahir', name: 'tgl_lahir' },
            { data: 'jk', name: 'jk' },
            { data: 'pekerjaan', name: 'pekerjaan' },
            { data: 'riwayat_alergi', name: 'riwayat_alergi' },
            {
                data: 'id',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm edit" data-id="${data}">Edit</button>
                        <button class="btn btn-danger btn-sm delete" data-id="${data}">Hapus</button>
                    `;
                }
            }
        ],
        initComplete: function () {
            // Tambahkan input filter di setiap kolom di tfoot
            this.api().columns().every(function () {
                let column = this;
                let input = $('<input type="text" class="form-control form-control-sm" placeholder="Cari...">')
                    .appendTo($(column.footer()).empty())
                    .on('keyup change clear', function () {
                        column.search($(this).val()).draw();
                    });
            });
        }
    });

    $('#formPasien').on('submit', function(e) {
        e.preventDefault(); // Mencegah reload halaman

        $.ajax({
            url: "{{ route('pasien.simpan-data') }}",
            method: "POST",
            data: $(this).serialize(),
            beforeSend: function() {
                $('button[type="submit"]').prop('disabled', true);
            },
            success: function(response) {
                if (response.message) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Data berhasil disimpan.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        $('#formPasien')[0].reset(); // Reset form setelah berhasil
                        table.ajax.reload(null, false);
                    });
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors || {};
                let errorMessage = "";
                $.each(errors, function(key, value) {
                    errorMessage += `• ${value[0]}<br>`;
                });

                Swal.fire({
                    title: "Gagal!",
                    html: errorMessage,
                    icon: "error",
                    confirmButtonText: "Coba Lagi"
                });
            },
            complete: function() {
                $('button[type="submit"]').prop('disabled', false);
            }
        });
    });
    // **🔹 Event Klik Edit**
    $('#data-pasien').on('click', '.edit', function() {
        let id = $(this).data('id');
        $.get("{{ url('pasien/edit') }}/" + id, function(data) {
            $('#modalEdit').modal('show');
            $('#edit_id').val(data.id);
            $('#edit_nama_pasien').val(data.nama_pasien);
            $('#edit_alamat').val(data.alamat);
            $('#edit_no_hp').val(data.no_hp);
            $('#edit_jk').val(data.jk);
            $('#edit_pekerjaan').val(data.pekerjaan);
            $('#edit_riwayat_alergi').val(data.riwayat_alergi);
        });
    });

    // **🔹 Event Klik Update (Simpan Edit)**
    $('#formEditPasien').on('submit', function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ url('pasien/update') }}/" + id,
            method: "PUT",
            data: formData,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                Swal.fire("Berhasil!", "Data telah diperbarui.", "success");
                $('#modalEdit').modal('hide');
                table.ajax.reload();
            },
            error: function() {
                Swal.fire("Gagal!", "Terjadi kesalahan saat memperbarui data.", "error");
            }
        });
    });

    // **🔹 Event Klik Hapus**
    $('#data-pasien').on('click', '.delete', function() {
    let id = $(this).data('id');
    Swal.fire({
        title: "Hapus Data?",
        text: "Data akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('pasien/hapus') }}/" + id,
                type: "POST", // 🔹 Gunakan POST, bukan DELETE
                data: {
                    _method: 'DELETE', // 🔹 Laravel butuh metode ini untuk DELETE
                    _token: $('meta[name="csrf-token"]').attr('content') // 🔹 Tambahkan token di data
                },
                success: function(response) {
                    Swal.fire("Berhasil!", "Data telah dihapus.", "success");
                    table.ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data.", "error");
                    console.error(xhr.responseText); // 🔹 Debugging
                }
            });
        }
    });
});

});


</script>
