    <!-- Header-->


    <div class="container">
        <div class="slider mt-5">
            <?php foreach ($events as $event) :  ?>
                <?php if (count($event['tickets']) > 0) : ?>
                    <a href="event/detail/<?= $event['id'] ?>">
                        <img src="<?= $event['event_images'] ?>" style="height: 400px; width: 100%;" alt="">
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>

    <section class="py-5">
        <h2 class="fw-bolder">Event Yang Akan Datang</h2>
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php foreach ($events as $event) :  ?>
                    <?php if (count($event['tickets']) > 0) : ?>
                        <div class="col mb-5">
                            <div class="card h-100">
                                <!-- Sale badge-->
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                <!-- Product image-->
                                <img class="card-img-top" src="<?= $event['event_images'] ?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body">
                                    <h5 class="fw-bolder"><?= $event['event_name'] ?></h5>
                                    <p><i class="fa-solid fa-calendar-days"></i> <?= $event['event_date'] ?></p>
                                    <p><i class="fa-solid fa-location-dot"></i> <?= $event['kota'] ?></p>

                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto w-100" href="event/detail/<?= $event['id'] ?>">Detail</a></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>