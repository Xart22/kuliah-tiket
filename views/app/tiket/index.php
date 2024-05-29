<div class="container mt-5" style="height: 80vh;">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $title; ?></h5>
            <hr>
            <?php foreach ($orders as $ticket) : ?>
                <?php if ($ticket['status'] == 'success' || $ticket['status'] == 'used') : ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col col-10">
                                    <div class="container ">
                                        <h5 class="card-title"><?php echo $ticket['ticket_name'] ?></h5>
                                        <p class="card-text">Harga : <?php echo $ticket['price'] ?></p>
                                        <button type="button" class="btn btn-outline-dark mt-auto w-100" data-bs-toggle="modal" data-bs-target="#detailTiket" data-bs-poster="<?php echo $ticket['event_images'] ?>" data-bs-barcode="<?php echo $ticket['barcode'] ?>" data-bs-event-name="<?php echo $ticket['event_name'] ?>" data-bs-event-date="<?php echo $ticket['event_date'] ?>" data-bs-event-time="<?php echo $ticket['event_time'] ?>" data-bs-description="<?php echo $ticket['description'] ?>" data-bs-terms="<?php echo $ticket['terms'] ?>" data-bs-order-id="<?php echo $ticket['order_id'] ?>" onclick="detailTiket(this)">
                                            Detail Tiket
                                        </button>
                                    </div>
                                </div>
                                <div class="col col-2 h-100 d-flex justify-content-center align-items-center ">
                                    <img src="/<?php echo $ticket['event_images'] ?>" class="img-fluid rounded" alt=" <?php echo $ticket['event_name'] ?>" style="height: 110px; ">
                                </div>
                            </div>

                        </div>
                    </div>
                <?php elseif ($ticket['status'] == 'pending') : ?>
                    <div class="card mt-3 ticket-available" data-ticket-id="<?php echo $ticket['id']; ?>">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-10">
                                    <div class="container ">
                                        <h5 class="card-title"><?php echo $ticket['ticket_name'] ?></h5>
                                        <p class="card-text">Harga : <?php echo $ticket['price'] ?></p>
                                        <button type="button" class="btn btn-outline-dark mt-auto w-100" data-bs-ticket='<?php echo json_encode($ticket); ?>' onclick="lanjutkanPembayaran(this)">
                                            Lanjutkan Pembayaran
                                        </button>


                                    </div>
                                </div>
                                <div class=" col col-2 h-100 d-flex justify-content-center align-items-center ">
                                    <img src=" /<?php echo $ticket['event_images'] ?>" class="img-fluid rounded" alt=" <?php echo $ticket['event_name'] ?>" style="height: 110px; ">
                                </div>
                            </div>

                        </div>
                    </div>
                <?php else : ?>
                    <div class="card mt-3 ticket-available" data-ticket-id="<?php echo $ticket['id']; ?>">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col col-10">
                                    <div class="container ">
                                        <h5 class="card-title"><?php echo $ticket['ticket_name'] ?></h5>
                                        <p class="card-text">Harga : <?php echo $ticket['price'] ?></p>
                                        <p class="card-text text-danger">Pembayaran Gagal</p>
                                    </div>
                                </div>
                                <div class="col col-2 h-100 d-flex justify-content-center align-items-center ">
                                    <img src="/<?php echo $ticket['event_images'] ?>" class="img-fluid rounded" alt=" <?php echo $events['event_name'] ?>" style="height: 110px; ">
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>




<div class="modal fade " id="detailTiket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5"> Detail Tiket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col col-6">
                        <img src="/${ticket.event_images}" class="img-fluid" alt="${ticket.event_name}" id="poster">
                        <div class="mt-3">
                            <!-- centering barcode -->
                            <div class="d-flex justify-content-center">
                                <img src="/${ticket.barcode}" class="img-fluid" alt="barcode" id="barcode">

                            </div>
                            <p class="card-text fw-bolder text-center" id="orderId"></p>
                        </div>
                    </div>
                    <div class="col col-6">
                        <h1 class="modal-title fs-5" id="detailTiketHeader"></h1>
                        <p class="card-text" id="detailTiketDate"></p>
                        <p class="card-text" id="detailTiketTime"></p>
                        <p class="card-text fw-bolder">Deskripsi :</p>
                        <p id="detailTiketDescription"></p>
                        <p class="card-text fw-bolder">Syarat & Ketentuan :</p>
                        <p id="detailTiketTerms"></p>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../../assets/vendor/jquery/jquery.min.js"></script>

<script>
    function detailTiket(el) {

        $('#detailTiketHeader').text($(el).data('bs-event-name'));
        $('#poster').attr('src', '/' + $(el).data('bs-poster'));
        $('#detailTiketDate').text('Tanggal Event : ' + $(el).data('bs-event-date'));
        $('#detailTiketTime').text('Waktu Event : ' + $(el).data('bs-event-time'));
        $('#detailTiketDescription').text($(el).data('bs-description'));
        $('#detailTiketTerms').text($(el).data('bs-terms'));
        $('#barcode').attr('src', '/' + $(el).data('bs-barcode'));
        $('#orderId').text($(el).data('bs-order-id'));
    }

    function lanjutkanPembayaran(el) {
        const data = $(el).data('bs-ticket');
        window.snap.pay(data.snaptoken, {
            onSuccess: function(result) {
                callbackSuccess(result);

            },
            onError: function(result) {
                console.log(result);
            }
        });

    }

    function callbackSuccess(response) {
        console.log(response);
        $.ajax({
            url: 'http://127.0.0.1/tiket/payment/create-transaction/update-status/' + response.order_id,
            method: 'get',
            success: function(data) {
                window.location.reload();
            }
        });
    }

    function callbackError(response) {
        console.log('error');
    }
</script>