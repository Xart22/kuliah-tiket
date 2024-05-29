<div class="container" style="height: 85vh;">
    <div class="row">
        <div class="col">
            <img src="/<?php echo $events['event_images'] ?>" style="height: 400px; width: 100%;" class="img-fluid rounded" alt=" <?php echo $events['event_name'] ?>">
        </div>
        <div class="col">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="contianer" style="height: 312px; overflow-y: scroll;">
                            <h5 class="card-title fw-bolder">Pilih Tiket</h5>
                            <hr>
                            <?php foreach ($events['tickets'] as $ticket) : ?>
                                <?php if ($ticket['qty'] == 0) : ?>
                                    <div class="card mt-3">
                                        <div class="card-body" style="background-color: #c2c2c2;">
                                            <div class="container">
                                                <h5 class="card-title">( SOLD OUT ) <?php echo $ticket['ticket_name'] ?></h5>
                                                <p class="card-text">Harga : <?php echo $ticket['price'] ?></p>
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
                                                    </div>
                                                </div>
                                                <div class="col col-2 h-100 d-flex justify-content-center align-items-center ">
                                                    <i class="fas fa-check-circle text-success" style="font-size: 30px; display: none;"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <div class="mt-3">
                                <input type="hidden" name="ticket_id" id="ticket-id">
                                <button type="button" class="btn btn-primary w-100" id="pay-button" disabled>Beli Tiket</button>

                            </div>
                        <?php else : ?>
                            <div class="mt-3">
                                <a href="/login" class="btn btn-primary w-100">Login untuk Membeli Tiket</a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>
    </div>



    <div class=" text-center bg-ligh mt-5 border border-2 rounded">
        <h2><?php echo $events['event_name'] ?></h2>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title fw-bolder">Detail Event</h5>
            <p class="card-text">Tanggal Event : <?php echo $events['event_date'] ?></p>
            <p class="card-text">Waktu Event : <?php echo $events['event_time'] ?></p>
            <p class="card-text">Kota : <?php echo $events['kota'] ?></p>
            <p class="card-text fw-bolder">Deskripsi Event : </p>
            <p><?php echo $events['description'] ?></p>
            <p class="card-text fw-bolder">Syarat & Ketentuan :</p>
            <p> <?php echo $events['terms'] ?></p>

        </div>
    </div>
</div>
<script src="../../../assets/vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.ticket-available').click(function() {
            $('.ticket-available').css('background-color', '').find('i').hide();
            $(this).css('background-color', '#f1f1f1').find('i').show();
            var ticketId = $(this).data('ticket-id');
            $('#ticket-id').val(ticketId);
            $('#pay-button').removeAttr('disabled');
        });
        $('#pay-button').click(function(event) {
            event.preventDefault();
            $(this).attr("disabled", "disabled");

            $.ajax({
                url: 'http://127.0.0.1/tiket/payment/create-transaction',
                method: 'post',
                data: {
                    ticket_id: $('#ticket-id').val(),
                    user_id: <?php echo $_SESSION['user']['id'] ?>
                },
                success: function(data) {
                    window.snap.pay(data, {
                        onSuccess: function(result) {
                            result.snaptoken = data;
                            callbackSuccess(result);

                        },
                        onPending: function(result) {
                            result.snaptoken = data;
                            callbackPending(result);
                        },
                        onError: function(result) {
                            callbackError(result);
                        }
                    });
                }
            });

            function callbackSuccess(response) {
                $.ajax({
                    url: 'http://127.0.0.1/tiket/payment/create-transaction/success',
                    method: 'post',
                    data: {
                        order_id: response.order_id,
                        transaction_status: response.transaction_status,
                        payment_type: response.payment_type,
                        fraud_status: response.fraud_status,
                        transaction_time: response.transaction_time,
                        transaction_id: response.transaction_id,
                        status_message: response.status_message,
                        gross_amount: response.gross_amount,
                        user_id: <?php echo $_SESSION['user']['id'] ?>,
                        ticket_id: $('#ticket-id').val(),
                        snaptoken: response.snaptoken
                    },
                    success: function(data) {
                        console.log(data);
                        window.location.href = '/ticket-saya';
                    }
                });
            }

            function callbackPending(response) {
                console.log(response);
                $.ajax({
                    url: 'http://127.0.0.1/tiket/payment/create-transaction/pending',
                    method: 'post',
                    data: {
                        order_id: response.order_id,
                        transaction_status: response.transaction_status,
                        payment_type: response.payment_type,
                        fraud_status: response.fraud_status,
                        transaction_time: response.transaction_time,
                        transaction_id: response.transaction_id,
                        status_message: response.status_message,
                        gross_amount: response.gross_amount,
                        user_id: <?php echo $_SESSION['user']['id'] ?>,
                        ticket_id: $('#ticket-id').val(),
                        snaptoken: response.snaptoken
                    },
                    success: function(data) {
                        window.location.href = '/ticket-saya';
                    }
                });
            }

            function callbackError(response) {
                console.log('error');
            }
        });
    });
</script>