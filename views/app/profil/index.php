<div class="container mt-5" style="height: 80vh;">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profil</h5>
            <hr>


            <form action="/update-profil" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" value="<?php echo $_SESSION['user']['full_name']; ?>" required name="full_name">
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email" value="<?php echo $_SESSION['user']['email']; ?>" required name="email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" required name="password">
                </div>

                <button class="btn btn-warning w-100" id="btn-update">Update</button>
            </form>


        </div>
    </div>
</div>
</div>