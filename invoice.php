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

                <form class="custom-form subscribe-form" method="POST" role="form">
                    <div class="row">
                        <div class="col-lg-12 col-12 mt-3">
                            <input type="text" name="keyword_tex" id="keyword_tex" class="form-control" placeholder="<?php echo $lang['keyword_tex'] ?>">
                        </div>
                        <div class="col-lg-12 col-12">
                            <button type="submit" class="form-control">ค้นหา</button>
                        </div>
                    </div>
                    <?php
                    require_once 'config_th/connection.php';
                    if (isset($_GET['keyword_tex'])) {
                        $keyword_tex = $_GET['keyword_tex'];
                        $stmt = $conn->prepare("SELECT * FROM `receipt_2567` WHERE `rec_idname` LIKE :keyword_tex ORDER BY `id` DESC");
                        $stmt->bindValue(':keyword_tex', '%' . $keyword_tex . '%', PDO::PARAM_STR);
                        $stmt->execute();
                        $result = $stmt->fetchAll();

                        if (count($result) > 0) {
                            foreach ($result as $t1) {
                                echo '<div class="col-lg-8 col-12 mb-lg-2 mb-2 mx-auto">
                                                    <div class="custom-block bg-white shadow-lg">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">' . $t1['name'] . '</h5>
                                                                <h6 class="mb-2">' . $t1['giftname'] . '</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                            }
                        } else {
                            echo '<div class="col-lg-8 col-12 mx-auto">
                                                                <div class="custom-block bg-white shadow-lg">
                                                                    <div class="d-flex">
                                                                    <div>
                                                                    <p>ท่านไม่ได้รับรางวัล ร่วมลุ้นด้วยกันใหม่ปีหน้านะเจ้า</p>
                                                                    <p>Unfortunately, you didnt win the prize this time. See you again next year.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                        }
                    } else {

                        echo '<div class="col-lg-8 col-12 mx-auto">
                                                    <div class="custom-block bg-white shadow-lg">
                                                        <div class="d-flex">
                                                            <div>
                                                                <p>Enter search text. / กรุณากรอกหมายเลข</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                    }
                    ?>
                </form>
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