<div class="card">
    <div class="card-header">
        <h3 class="card-title">Buat Tiket <?= $event['event_name']; ?></h3>
    </div>
    <div class="card-body">
        <div class="container mb-5">
            <form action="<?= $event['id']; ?>" method="post" enctype="multipart/form-data">
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
                                    <label for="ticket_name">Nama Tiket / Kategori Tiket</label>
                                    <input type="text" name="ticket_name" id="ticket_name" class="form-control" required>
                                    <small class="text-muted">Contoh: Presale, Early Bird, VIP, Regular</small>
                                </div>
                                <div class="form-group">
                                    <label for="price">Harga</label>
                                    <input type="text" name="price" id="price" class="form-control" required onkeyup="formatRupiah(this)">
                                </div>
                                <div class=" form-group">
                                    <label for="kota">Qouta Tiket</label>
                                    <input type="number" name="qty" id="qty" class="form-control" required>
                                    <small class="text-muted">Contoh: 100</small>
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




<script>
    function formatRupiah(el) {
        el.value = convertToRupiah(el.value, "Rp. ");
    }

    function convertToRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }
        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
</script>