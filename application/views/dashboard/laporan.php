<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h3>Laporan</h3>
            </div>

            <?php $i = 1;
            foreach ($data as $d) {
                $menu = $d['menu'];
            ?>
                <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                    <div class="card card-outline card-success">
                        <div class="card-body">
                            <h6><strong><?= $i++ ?>. <?= $d['title'] ?></strong></h6>
                            <hr>
                            <?php foreach ($menu as $m) { ?>
                                <div class="text-center">
                                    <a href="<?= base_url() . $m['url'] ?>" class="my-1 btn btn-sm btn-<?= $m['color'] ?>"><i class="far fa-folder"></i> <?= $m['title'] ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div><!-- /.container-fluid -->
</section>