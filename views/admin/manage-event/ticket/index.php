<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Tiket <?= $event['event_name']; ?></h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Event</th>
                    <th>Nama Event</th>
                    <th>Nama Tiket / Kategori Tiket
                    <th>Qouta Tiket</th>
                    <th>Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php
                if (!empty($tickets)) {

                    foreach ($tickets as $ticket) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $event['event_date']; ?></td>
                            <td><?= $event['event_name']; ?></td>
                            <td><?= $ticket['ticket_name']; ?></td>
                            <td><?= $ticket['qty']; ?></td>
                            <td><?= $ticket['price']; ?></td>
                            <td>
                                <?php if ($event['event_date'] > date('Y-m-d')) : ?>
                                    <a href="/admin/manage-event/edit-ticket/<?= $ticket['id']; ?>" class="btn btn-warning">Edit</a>

                                    <a href="/admin/manage-event/delete-ticket/<?= $ticket['id']; ?>" class="btn btn-danger">Delete</a>
                                <?php endif; ?>

                            </td>

                        </tr>
                <?php endforeach;
                } ?>





            </tbody>
        </table>

    </div>
</div>