<div class="card">
    <div class="card-header">
        <h3 class="card-title">Redeem Ticket</h3>
    </div>
    <div class="card-body">
        <div class="container mb-5">
            <form action="/admin/redeem-ticket" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" card">
                            <div class="card-body">
                                <?php if (isset($_SESSION['error'])) : ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        <?= $_SESSION['error']; ?>
                                        <?php unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['success'])) : ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        <?= $_SESSION['success']; ?>
                                        <?php unset($_SESSION['success']); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="barcode">Barcode ID</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Redeem</button>
                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>