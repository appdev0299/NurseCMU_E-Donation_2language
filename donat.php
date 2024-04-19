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
                            <input type="email" name="rec_email1" id="rec_email1" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="<?php echo $lang['rec_email1'] ?>">
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
                                    <input type="text" name="donation_fullname" id="donation_fullname" class="form-control" placeholder="<?php echo $lang['donation_fullname'] ?>">
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
                            <input type="text" name="edo_tex" value="<?= $row['edo_tex']; ?>" hidden>
                            <input type="text" name="edo_pro_id" value="<?= $row['edo_pro_id']; ?>" hidden>
                            <input type="text" name="edo_description" value="<?= $row['edo_description']; ?>" hidden>
                            <input type="text" name="rec_date_s" value="<?php echo date('Y-m-d'); ?>" hidden>


                            <button type="submit" name="submit" class="form-control mt-4"><?php echo $lang['submit'] ?></button>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['submit'])) {
                        if (
                            !empty($_POST['rec_email1'])
                            && !empty($_POST['rec_email2'])
                            && !empty($_POST['amount'])
                        ) {
                            try {
                                require 'config_th/connection.php';
                                $lang = isset($_GET['lang']) ? $_GET['lang'] : 'th';
                                $province_code = $_POST['provinces'];
                                $stmt_province = $conn->prepare("SELECT " . ($lang === 'en' ? "name_en" : "name_th") . " FROM provinces WHERE id = :province_code");
                                $stmt_province->bindParam(':province_code', $province_code, PDO::PARAM_STR);
                                $stmt_province->execute();
                                $province_result = $stmt_province->fetch(PDO::FETCH_ASSOC);
                                $province_name = $province_result ? $province_result[($lang === 'en' ? 'name_en' : 'name_th')] : '';

                                $amphures_code = $_POST['amphures'];
                                $stmt_amphures = $conn->prepare("SELECT " . ($lang === 'en' ? "name_en" : "name_th") . " FROM amphures WHERE id = :amphures_code");
                                $stmt_amphures->bindParam(':amphures_code', $amphures_code, PDO::PARAM_STR);
                                $stmt_amphures->execute();
                                $amphures_result = $stmt_amphures->fetch(PDO::FETCH_ASSOC);
                                $amphures_name = $amphures_result ? $amphures_result[($lang === 'en' ? 'name_en' : 'name_th')] : '';

                                $districts_code = $_POST['districts'];
                                $stmt_districts = $conn->prepare("SELECT " . ($lang === 'en' ? "name_en" : "name_th") . ", zip_code FROM districts WHERE id = :districts_code");
                                $stmt_districts->bindParam(':districts_code', $districts_code, PDO::PARAM_STR);
                                $stmt_districts->execute();
                                $districts_result = $stmt_districts->fetch(PDO::FETCH_ASSOC);
                                $districts_name = $districts_result ? $districts_result[($lang === 'en' ? 'name_en' : 'name_th')] : '';
                                $zip_code = $districts_result ? $districts_result['zip_code'] : '';


                                $status_receipt = isset($_POST['status_receipt']) ? 1 : 0;

                                $stmt = $conn->prepare("INSERT INTO donation
                                (rec_email1, rec_email2, amount, name_title, donation_fullname, rec_idname, rec_tel, address, province, amphure, district, zip_code, status_receipt, edo_pro_id, edo_description, rec_date_s,edo_name,edo_tex)
                                VALUES (:rec_email1, :rec_email2, :amount, :name_title, :donation_fullname, :rec_idname, :rec_tel, :address, :province_name, :amphure_name, :district_name, :zip_code, :status_receipt, :edo_pro_id, :edo_description, :rec_date_s,:edo_name,:edo_tex)");

                                $stmt->bindParam(':rec_email1', $_POST['rec_email1'], PDO::PARAM_STR);
                                $stmt->bindParam(':rec_email2', $_POST['rec_email2'], PDO::PARAM_STR);
                                $stmt->bindParam(':amount', $_POST['amount'], PDO::PARAM_STR);
                                $stmt->bindParam(':name_title', $_POST['name_title'], PDO::PARAM_STR);
                                $stmt->bindParam(':donation_fullname', $_POST['donation_fullname'], PDO::PARAM_STR);
                                $stmt->bindParam(':rec_idname', $_POST['rec_idname'], PDO::PARAM_STR);
                                $stmt->bindParam(':rec_tel', $_POST['rec_tel'], PDO::PARAM_STR);
                                $stmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
                                $stmt->bindParam(':province_name', $province_name, PDO::PARAM_STR);

                                $stmt->bindParam(':amphure_name', $amphures_name, PDO::PARAM_STR);
                                $stmt->bindParam(':district_name', $districts_name, PDO::PARAM_STR);
                                $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
                                $stmt->bindParam(':status_receipt', $status_receipt, PDO::PARAM_INT);
                                $stmt->bindParam(':edo_name', $_POST['edo_name'], PDO::PARAM_STR);
                                $stmt->bindParam(':edo_tex', $_POST['edo_tex'], PDO::PARAM_STR);
                                $stmt->bindParam(':edo_pro_id', $_POST['edo_pro_id'], PDO::PARAM_STR);
                                $stmt->bindParam(':edo_description', $_POST['edo_description'], PDO::PARAM_STR);
                                $stmt->bindParam(':rec_date_s', $_POST['rec_date_s'], PDO::PARAM_STR);


                                $result = $stmt->execute();

                                if ($result) {
                                    $id = $conn->lastInsertId();
                                    $lang = isset($_GET['lang']) ? $_GET['lang'] : '';
                                    $url = "donat_check.php?id=$id&lang=$lang";
                                    echo "<script>window.location.href = '$url';</script>";
                                } else {
                                    echo "มีข้อผิดพลาดในการบันทึกข้อมูล";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                        } else {
                            echo "ไม่มีข้อมูลที่จำเป็นสำหรับการบันทึก";
                        }
                    }
                    echo '<pre>';
                    print_r($_POST);
                    echo '</pre>';
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