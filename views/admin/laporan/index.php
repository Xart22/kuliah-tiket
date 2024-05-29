<div class="row">

    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
            </div>
            <div class="card-body">
                <form action="/admin/laporan/report" method="post">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="event">Event</label>
                                <select name="event" id="event" class="form-control">
                                    <?php foreach ($events as $event) : ?>
                                        <option value="<?= $event['id'] ?>"><?= $event['event_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mt-4 w-100">Cari</button>
                            </div>
                        </div>
                    </div>


                </form>

                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Tanggal Event</th>
                            <th>Nama Tiket / Kategori Tiket</th>
                            <th>Harga</th>
                            <th>Total Tiket</th>
                            <th>Total Tiket Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($orders)) : ?>
                            <?php foreach ($orders as $ticketId => $orderGroup) : ?>
                                <?php $ticket = $orderGroup['ticket']; ?>
                                <tr>
                                    <td><?= $event['event_name'] ?></td>
                                    <td><?= $event['event_date'] ?></td>
                                    <td><?= $ticket['ticket_name'] ?></td>
                                    <td><?= $ticket['price'] ?></td>
                                    <td><?= $ticket['qty'] ?></td>
                                    <td><?= $orderGroup['total_sold'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>