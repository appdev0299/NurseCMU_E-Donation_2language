<!doctype html>
<html lang="th">

<?php require_once 'config_th/config_languages.php';
require_once 'config_th/head.php'; ?>

<body id="section_1">
    <?php require_once 'config_th/header.php';
    require_once 'config_th/nav.php'; ?>
    <main>
        <section class="cta-section section-padding section-bg">
            <br>
            <div class="container">
                <div class="row">
                    <?php
                    $table_name = ($_SESSION['lang'] === 'en') ? 'project_en' : 'project_th';

                    require_once 'config_th/connection.php';
                    if ($conn) {
                        if (isset($_GET['id'])) {
                            $stmt = $conn->prepare("SELECT * FROM $table_name WHERE id=?");
                            $stmt->execute([$_GET['id']]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row) {
                                $imageURL = "images/causes/" . $row['img_file'];
                    ?>
                                <div class="col-lg-5 col-12 mb-5 mb-lg-0">
                                    <img src="<?= $imageURL; ?>" class="custom-text-box-image img-fluid" alt="">
                                </div>
                    <?php
                            }
                        }
                    } else {
                        echo "Failed to connect to database.";
                    }
                    ?>

                    <div class="col-lg-7 col-12">
                        <?php if ($row) : ?>
                            <div class="custom-text-box">
                                <h3 class="mb-2"><?= $row['edo_name']; ?></h3>
                                <h5 class="mb-3"><?= $row['edo_tex']; ?></h5>
                                <p class="mb-0"><?= $row['edo_details']; ?></p>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="custom-text-box mb-lg-0">
                                        <h5 class="mb-3"><?php echo $lang['obj'] ?></h5>
                                        <p><?php echo $lang['details_of'] ?></p>
                                        <ul class="custom-list mt-2">
                                            <?php if (!empty($row['edo_details_objective1'])) : ?>
                                                <li class="custom-list-item d-flex">
                                                    <i class="bi-check custom-text-box-icon me-2"></i>
                                                    <?= $row['edo_details_objective1']; ?>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (!empty($row['edo_details_objective2'])) : ?>
                                                <li class="custom-list-item d-flex">
                                                    <i class="bi-check custom-text-box-icon me-2"></i>
                                                    <?= $row['edo_details_objective2']; ?>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (!empty($row['edo_details_objective3'])) : ?>
                                                <li class="custom-list-item d-flex">
                                                    <i class="bi-check custom-text-box-icon me-2"></i>
                                                    <?= $row['edo_details_objective3']; ?>
                                                </li>
                                            <?php endif; ?>
                                            <?php if (!empty($row['edo_details_objective4'])) : ?>
                                                <li class="custom-list-item d-flex">
                                                    <i class="bi-check custom-text-box-icon me-2"></i>
                                                    <?= $row['edo_details_objective4']; ?>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h2></h2>
                            <div class="col-lg-12 col-12">
                                <a href="donat?id=<?= $row['id']; ?>&lang=<?php echo $_SESSION['lang']; ?>" class="custom-btn btn smoothscroll">บริจาคเพื่อลดหย่อนภาษี</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </section>
    </main>
    <?php require_once('config_th/footer.php'); ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>