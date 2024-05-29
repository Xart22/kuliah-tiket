<div class="card">
  <div class="card-header">
    <h3 class="card-title">List User</h3>
  </div>
  <div class="card-body">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUser" id="addUser">
      Tambah User
    </button>

    <table class="table table-bordered" id="dataTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; ?>
        <?php
        if (!empty($users)) {

          foreach ($users as $user) : ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $user['full_name']; ?></td>
              <td><?= $user['email']; ?></td>
              <td><?= $user['role']; ?></td>
              <td>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalUser" data-user='<?= json_encode($user); ?>' onclick="editUser(this)">
                  Edit
                </button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalUserDelete" data-user='<?= json_encode($user); ?>' onclick="deleteUser(this)">
                  Delete
                </button>
              </td>
            </tr>
        <?php endforeach;
        } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="modal fade" id="modalUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/manage-user/store" method="post" id="formUser">
          <div class="form-group">
            <label for="full_name">Nama</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role">
              <option value="admin">Admin</option>
              <option value="user">User</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalUserDelete" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/admin/manage-user/delete" method="post">
          <input type="hidden" name="id" id="id" />
          <p id="deleteText"></p>
          <button type="submit" class="btn btn-danger w-100">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="../../../assets/vendor/jquery/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $("#addUser").click(function() {
      $("#modalTitle").html("Tambah User");
      $("#formUser").attr("action", "/admin/manage-user/store");
      $("#full_name").val("");
      $("#email").val("");
      $("#password").val("");
      $("#role").val("admin");
    });
  });

  function editUser(el) {
    $("#modalTitle").html("Edit User");
    $("#formUser").attr("action", "/admin/manage-user/update");
    const user = JSON.parse(el.getAttribute("data-user"));
    $("#full_name").val(user.full_name);
    $("#email").val(user.email);
    $("#role").val(user.role);
  }

  function deleteUser(el) {
    const user = JSON.parse(el.getAttribute("data-user"));
    $("#id").val(user.id);
    $("#deleteText").html("Apakah anda yakin ingin menghapus user " + user.full_name + " ?");
  }
</script>