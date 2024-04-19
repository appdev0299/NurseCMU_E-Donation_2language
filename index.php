<!doctype html>
<html lang="th">
<?php require_once 'config_th/config_languages.php';
require_once 'config_th/head.php'; ?>

<body id="section_1">
    <?php require_once 'config_th/header.php';
    require_once 'config_th/nav.php'; ?>
    <main>
        <section class="hero-section hero-section-full-height">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-12 p-0">
                        <div id="hero-slide" class="carousel carousel-fade slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="images/slide/poster_home1_<?php echo $_SESSION['lang']; ?>.jpg" class="carousel-image img-fluid" alt="...">
                                </div>

                                <div class="carousel-item">
                                    <img src="images/slide/poster_home2_<?php echo $_SESSION['lang']; ?>.jpg" class="carousel-image img-fluid" alt="...">
                                </div>

                                <div class="carousel-item">
                                    <img src="images/slide/poster_home3_<?php echo $_SESSION['lang']; ?>.jpg" class="carousel-image img-fluid" alt="...">
                                </div>

                                <div class="carousel-item">
                                    <img src="images/slide/poster_home4_<?php echo $_SESSION['lang']; ?>.jpg" class="carousel-image img-fluid" alt="...">
                                </div>
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#hero-slide" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#hero-slide" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-padding" id="section_3">
            <div class="container">
                <div class="row">

                    <div class="col-lg-12 col-12 text-center mb-4">
                        <h2>โครงการ</h2>
                    </div>
                    <?php
                    require_once 'config_th/connection.php';
                    $table_name = ($_SESSION['lang'] === 'en') ? 'project_en' : 'project_th';
                    if ($conn) {
                        $stmt = $conn->prepare("SELECT * FROM $table_name");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        foreach ($result as $t1) {
                            $edoId = $t1['id'];
                            $imageURL = "images/causes" . $t1['img_file'];
                    ?>

                            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                <div class="custom-block-wrap">
                                    <img src="images/causes/<?= $t1['img_file']; ?>" class="custom-block-image img-fluid" alt="">
                                    <div class="custom-block">
                                        <div class="custom-block-body" style="height: 200px;">
                                            <h5 class="mb-3"><?php echo $t1['edo_name']; ?></h5>
                                            <p><?php echo $t1['edo_description']; ?></p>
                                        </div>
                                        <a href="details?id=<?= $edoId; ?>&lang=<?php echo $_SESSION['lang']; ?>" class="custom-btn btn"><?php echo $lang['donation'] ?></a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "Failed to connect to database.";
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <?php require_once('config_th/footer.php'); ?>

    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>