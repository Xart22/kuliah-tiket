<div class="card">
    <div class="card-header">
        <h3 class="card-title">List Tiket </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Event</th>
                    <th>Waktu</th>
                    <th>Kota</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php
                if (!empty($events)) {

                    foreach ($events as $event) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $event['event_date']; ?></td>
                            <td><?= $event['event_name']; ?></td>
                            <td><?= $event['event_time']; ?></td>
                            <td><?= $event['kota']; ?></td>
                            <td>
                                <?php if (empty($event['tickets'])) : ?>
                                    <a href="/admin/manage-event/create-ticket/<?= $event['id']; ?>" class="btn btn-primary">Buat Tiket</a>
                                    <a href="/admin/manage-event/edit/<?= $event['id']; ?>" class="btn btn-warning">Edit</a>
                                    <a href="/admin/manage-event/delete/<?= $event['id']; ?>" class="btn btn-danger">Delete</a>

                                <?php else : ?>
                                    <?php if ($event['event_date'] > date('Y-m-d')) : ?>
                                        <a href="/admin/manage-event/create-ticket/<?= $event['id']; ?>" class="btn btn-primary">Buat Tiket</a>
                                    <?php endif; ?>
                                    <a href="/admin/manage-event/ticket-detail/<?= $event['id']; ?>" class="btn btn-warning">Tiket Detail</a>
                                <?php endif; ?>

                            </td>
                        </tr>
                <?php endforeach;
                } ?>





            </tbody>
        </table>

    </div>
</div>