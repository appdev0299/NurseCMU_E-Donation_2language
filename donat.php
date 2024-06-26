<!doctype html>
<html lang="th">

<?php require_once 'config_th/config_languages.php';
require_once 'config_th/head.php'; ?>

<body id="section_1">
    <?php require_once 'config_th/header.php';
    require_once 'config_th/nav.php'; ?>
    <main>
        <section class="cta-section section-padding section-bg">
            <div class="col-lg-8 col-12 mx-auto">
                <form class="custom-form donate-form" method="POST" role="form">
                    <?php
                    $table_name = ($_SESSION['lang'] === 'en') ? 'project_en' : 'project_th';

                    if (isset($_GET['id'])) {
                        require_once 'config_th/connection.php';
                        $stmt = $conn->prepare("SELECT * FROM $table_name WHERE id=?");
                        $stmt->execute([$_GET['id']]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    ?>
                    <h3 class="mb-4"><?= $row['edo_name']; ?></h3>
                    <div class="row">
                        <div class="col-lg-6 col-12 mt-3">
                            <input type="email" name="rec_email" id="rec_email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="<?php echo $lang['rec_email1'] ?>">
                        </div>
                        <div class="col-lg-6 col-12 mt-3">
                            <input type="email" name="rec_email2" id="rec_email2" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="<?php echo $lang['rec_email2'] ?>">
                        </div>
                        <div class="col-lg-12 col-12 mt-3">
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="<?php echo $lang['amount'] ?>">
                        </div>
                        <div class="col-lg-12 col-12 mt-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status_receipt" id="status_receipt">
                                <label class="form-check-label" for="status_receipt">
                                    <?php echo $lang['status_receipt'] ?>
                                </label>
                            </div>
                            <div class="row" id="newform" style="display: none;">
                                <div class="col-lg-2 col-12 mt-3">
                                    <select name="name_title" id="name_title" class="form-control">
                                        <option value=""><?php echo $lang['name_title'] ?></option>
                                        <option value="นาย">นาย</option>
                                        <option value="นาง">นาง</option>
                                        <option value="นางสาว">นางสาว</option>
                                    </select>
                                </div>
                                <div class="col-lg-5 col-12 mt-3">
                                    <input type="text" name="rec_name" id="rec_name" class="form-control" placeholder="<?php echo $lang['donation_fullname'] ?>">
                                </div>
                                <div class="col-lg-5 col-12 mt-3">
                                    <input type="number" name="rec_idname" id="rec_idname" class="form-control" placeholder="<?php echo $lang['rec_idname'] ?>">
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <input type="number" name="rec_tel" id="rec_tel" class="form-control" placeholder="<?php echo $lang['rec_tel'] ?>">
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="<?php echo $lang['address'] ?>">
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <?php
                                    require_once 'config_th/connect.php';
                                    $sql = "SELECT * FROM provinces";
                                    $query = mysqli_query($conn, $sql);
                                    ?>
                                    <select name="provinces" id="province" class="form-control">
                                        <option value=""><?= $lang['provinces'] ?></option>
                                        <?php while ($result = mysqli_fetch_assoc($query)) : ?>
                                            <option value="<?= $result['id'] ?>">
                                                <?php echo isset($_SESSION['lang']) && $_SESSION['lang'] === 'en' ? $result['name_en'] : $result['name_th']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <script>
                                    var lang = "<?php echo isset($_GET['lang']) ? $_GET['lang'] : 'th'; ?>";
                                </script>
                                <div class="col-lg-6 col-12 mt-3">
                                    <select name="amphures" id="amphure" class="form-control">
                                        <option value=""><?= $lang['amphures'] ?></option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <select name="districts" id="district" class="form-control">
                                        <option value=""><?= $lang['districts'] ?></option>
                                    </select>
                                </div>


                            </div>
                            <input type="text" name="edo_name" value="<?= $row['edo_name']; ?>" hidden>
                            <input type="text" name="edo_pro_id" value="<?= $row['edo_pro_id']; ?>" hidden>
                            <input type="text" name="edo_description" value="<?= $row['edo_description']; ?>" hidden>
                            <input type="text" name="rec_date_s" value="<?php echo date('Y-m-d'); ?>" hidden>
                            <button type="submit" name="submit" class="form-control mt-4"><?php echo $lang['submit'] ?></button>
                        </div>
                        <?php
                        require_once('donat_db.php');
                        // echo '<pre>';
                        // print_r($_POST);
                        // echo '</pre>';
                        ?>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php require_once('config_th/footer.php'); ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>
    <script src="config_th/script_province.js"></script>
    <script>
        $(document).ready(function() {
            $('#status_receipt').change(function() {
                if ($(this).is(':checked')) {
                    $('#newform').show();
                } else {
                    $('#newform').hide();
                }
            });
        });
    </script>


</body>

</html>