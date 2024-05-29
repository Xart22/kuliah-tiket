<div class="card">
    <div class="card-header">
        <h3 class="card-title">Buat Event Baru</h3>
    </div>
    <div class="card-body">
        <div class="container mb-5">
            <form action="/admin/manage-event/store" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class=" card">

                            <div class="card-body"><?php if (isset($_SESSION['error'])) : ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        <?= $_SESSION['error']; ?>
                                        <?php unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="event_name">Nama Event</label>
                                    <input type="text" name="event_name" id="event_name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="event_images">Poster</label>
                                    <input type="file" name="event_images" id="event_images" class="form-control" required accept="image/*">
                                </div>
                                <div class="form-group">
                                    <label for="event_date">Tanggal</label>
                                    <input type="date" name="event_date" id="event_date" class="form-control" required min="<?= date('Y-m-d', strtotime('+7 days')) ?>">
                                    <small class="text-muted">Contoh: 2021-12-31 </small>
                                </div>
                                <div class="form-group">
                                    <label for="event_time">Waktu</label>
                                    <input type="time" name="event_time" id="event_time" class="form-control" required>
                                    <small class="text-muted">Contoh: 12:00 </small>
                                </div>
                                <div class=" form-group">
                                    <label for="kota">Kota</label>
                                    <input type="text" name="kota" id="kota" class="form-control" required>
                                    <small class="text-muted">Contoh: Jakarta</small>
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="terms">Terms & Conditions</label>
                                    <textarea name="terms" id="terms" class="form-control" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-success w-100">Simpan</button>

                            </div>
                        </div>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>



<script src="../../../assets/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        let i = 1;
        $('#addTiket').click(function() {
            i++;
            $('#ticket-container').append(`
                <div class="card mt-2" id="ticket-form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="ticket_name${i}">Nama Tiket</label>
                            <input type="text" name="ticket_name[]" id="ticket_name${i}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price${i}">Harga Tiket</label>
                            <input type="text" name="price[]" id="price${i}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="qty${i}">Jumlah Tiket</label>
                            <input type="number" name="qty[]" id="qty${i}" class="form-control" required>
                        </div>
                    </div>
                </div>
            `);

        });
        $('#removeTiket').click(function() {
            if (i != 1) {
                $('#ticket-form').remove();
                i--;
            }
        });
    });
</script>