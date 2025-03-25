@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Home</a></li>
                        <li class="breadcrumb-item active">User Management</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Tabel Pengguna</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Data Pengguna</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModalLive">
                        <i data-feather="user"></i> +
                    </button>
                </div>

                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table id="table-user" class="display table table-striped table-hover dt-responsive nowrap"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="createCloseButton"
                        aria-label="Close"></button>
                </div>
                <form id="userForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="form-floating mb-0">
                                    <input type="text" class="form-control" id="floatingName" name="name"
                                        placeholder="Full Name" required>
                                    <label for="floatingName">Full Name</label>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <div class="form-floating mb-0">
                                    <input type="text" class="form-control" id="floatingUsername" name="username"
                                        placeholder="Username" required>
                                    <label for="floatingUsername">Username</label>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-floating mb-0">
                                    <input type="email" class="form-control" id="floatingEmail" name="email"
                                        placeholder="Email address" required>
                                    <label for="floatingEmail">Email address</label>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <div class="form-floating mb-0">
                                    <input type="password" class="form-control" id="floatingPassword" name="password"
                                        placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-md-12">
                                <div class="form-floating mb-0">
                                    <select class="form-control" id="floatingRole" name="role" required>
                                        <option value="admin">Admin</option>
                                        <option value="user">User</option>
                                    </select>
                                    <label for="floatingRole">Role</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('auth.edit-user')
    @push('scripts')
        <script>
            $(document).ready(function() {
                let table = $("#table-user").DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('users.get-user') }}", // Sesuaikan dengan route controller
                        type: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                        { data: 'name', name: 'name' },
                        { data: 'username', name: 'username' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        { data: 'id',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                let disabled = row.role === 'super_admin' ? 'disabled' : '';
                                return `
                                    <button class="btn btn-warning btn-sm edit" data-id="${data}" ${disabled}>
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm delete" data-id="${data}" ${disabled}>
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                `;
                            }
                        }
                    ],
                });

                // Handle Form Submit
                $('#userForm').submit(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('users.store') }}", // Sesuaikan dengan route Laravel
                        type: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data berhasil disimpan!',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                // Tutup modal setelah toast muncul
                                $('#createCloseButton').click()

                                $('#table-user').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Data gagal disimpan!',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#createCloseButton').click()
                            Swal.fire("Terjadi Kesalahan!", xhr.responseJSON.message, "error");
                        },
                        complete: function() {
                            btnSubmit.prop("disabled", false).text("Simpan");
                        }
                    });
                });

                // edit
                $('#table-user').on('click', '.edit', function() {
                    let id = $(this).data('id');
                    $.get("{{ url('users/edit') }}/" + id, function(data) {
                        $('#editUserModal').modal('show');
                        $('#editUserId').val(data.id);
                        $('#editName').val(data.name);
                        $('#editUsername').val(data.username);
                        $('#editEmail').val(data.email);
                        $('#editPassword').val(data.password);
                        $('#editRole').val(data.role).change();
                    });
                });

                $('#editUserForm').on('submit', function(e) {
                    e.preventDefault();
                    let id = $('#edit_id').val();
                    let formData = $(this).serialize();

                    $.ajax({
                        url: "{{ url('users/update') }}/" + id,
                        method: "PUT",
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire("Berhasil!", "Data telah diperbarui.", "success");
                            $('#editUserModal').modal('hide');
                            table.ajax.reload();
                        },
                        error: function() {
                            Swal.fire("Gagal!", "Terjadi kesalahan saat memperbarui data.",
                            "error");
                            $('#editUserModal').modal('hide');
                        }
                    });
                });

                $('#table-user').on('click', '.delete', function() {
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
                                url: "{{ url('users/hapus') }}/" + id,
                                type: "POST", // 🔹 Gunakan POST, bukan DELETE
                                data: {
                                    _method: 'DELETE', // 🔹 Laravel butuh metode ini untuk DELETE
                                    _token: $('meta[name="csrf-token"]').attr(
                                        'content') // 🔹 Tambahkan token di data
                                },
                                success: function(response) {
                                    Swal.fire("Berhasil!", "Data telah dihapus.",
                                    "success");
                                    table.ajax.reload();
                                },
                                error: function(xhr) {
                                    Swal.fire("Gagal!",
                                        "Terjadi kesalahan saat menghapus data.",
                                        "error");
                                    console.error(xhr.responseText); // 🔹 Debugging
                                }
                            });
                        }
                    });
                });
            })
        </script>
    @endpush
@endsection
