<!-- Modal Edit User -->
<div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserLabel">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                @csrf
                <input type="hidden" id="editUserId" name="id">
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <div class="form-floating mb-0">
                                <input type="text" class="form-control" id="editName" name="name" required>
                                <label for="editName">Full Name</label>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <div class="form-floating mb-0">
                                <input type="text" class="form-control" id="editUsername" name="username" required>
                                <label for="editUsername">Username</label>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-floating mb-0">
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                                <label for="editEmail">Email address</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-0">
                                <input type="password" class="form-control" id="editPassword" name="password">
                                <label for="editPassword">Password</label>
                            </div>
                            <div class="mt-2">
                                <input type="checkbox" id="showPassword" onclick="togglePassword()">
                                <label for="showPassword">Tampilkan Password</label>
                            </div>
                        </div>


                        <!-- Role -->
                        <div class="col-md-6">
                            <div class="form-floating mb-0">
                                <select class="form-control" id="editRole" name="role" required>
                                    <option value="admin"
                                        {{ isset($user) && $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user"
                                        {{ isset($user) && $user->role == 'user' ? 'selected' : '' }}>User</option>
                                </select>


                                <label for="editRole">Role</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        let passwordField = document.getElementById("editPassword");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
</script>
