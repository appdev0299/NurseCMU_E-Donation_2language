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
                <form class="custom-form donate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="form">
                    <?php
                    if (isset($_GET['id'])) {
                        require_once 'config_th/connection.php';
                        $stmt = $conn->prepare("SELECT * FROM donation WHERE id=?");
                        $stmt->execute([$_GET['id']]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($row) {
                    ?>
                            <div class="row">
                                <div class="col-lg-12 col-12 mt-3">
                                    <h5>ข้อมูลผู้รับเงินบริจาค</h5>
                                    <h6><?php echo $row['edo_name']; ?></h6>
                                    <h6><?php echo $row['edo_tex']; ?></h6>
                                    <h6>จำนวนเงิน : <?php echo $row['amount']; ?> บาท</h6>
                                    <hr>
                                </div>
                                <div class="col-lg-12 col-12 mt-3">
                                    <h5>ข้อมูลผู้ชำระเงินบริจาค</h5>
                                    <h6><?php echo $lang['rec_email1'] ?> : <?php echo $row['rec_email1']; ?></h6>
                                    <h6> <?php echo $lang['donation_fullname'] ?> : <?php echo $row['donation_fullname']; ?>
                                    </h6>
                                    <h6><?php echo $lang['rec_idname'] ?> : <?php echo $row['rec_idname']; ?></h6>
                                    <h6><?php echo $lang['rec_tel'] ?> : <?php echo $row['rec_tel']; ?></h6>
                                    <h6><?php echo $lang['address'] ?> : <?php echo $row['address']; ?>
                                        <?php echo $row['district']; ?> <?php echo $row['amphure']; ?>
                                        <?php echo $row['province']; ?> <?php echo $row['zip_code']; ?></h6>
                                    <hr>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12 mt-3">
                                <div class="row">
                                    <div class="col">
                                        <button type="button" name="back" class="form-control mt-4" onclick="window.history.back();"><?php echo $lang['back'] ?></button>
                                    </div>
                                    <div class="col">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                        <button type="submit" name="submit" class="form-control mt-4"><?php echo $lang['submit'] ?></button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['submit'])) {
                        require_once 'config_th/connection.php';
                        if (isset($_POST['id'])) {
                            $id = $_POST['id'];
                            $stmt_donation = $conn->prepare("SELECT * FROM donation WHERE id = ?");
                            $stmt_donation->execute([$id]);
                            $row_donation = $stmt_donation->fetch(PDO::FETCH_ASSOC);
                            if ($row_donation) {
                                $rec_email1 = $row_donation['rec_email1'];
                                $rec_email2 = $row_donation['rec_email2'];
                                $amount = $row_donation['amount'];
                                $status_receipt = $row_donation['status_receipt'];
                                $name_title = $row_donation['name_title'];
                                $donation_fullname = $row_donation['donation_fullname'];
                                $rec_idname = $row_donation['rec_idname'];
                                $rec_tel = $row_donation['rec_tel'];
                                $address = $row_donation['address'];
                                $province = $row_donation['province'];
                                $amphure = $row_donation['amphure'];
                                $district = $row_donation['district'];
                                $zip_code = $row_donation['zip_code'];
                                $edo_pro_id = $row_donation['edo_pro_id'];
                                $edo_name = $row_donation['edo_name'];
                                $edo_description = $row_donation['edo_description'];
                                $rec_date_s = $row_donation['rec_date_s'];

                                // Generate ref1
                                $id_year = date('Y') + 543;
                                $last_two_digits = substr($id_year, -2);
                                $lastInsertedId = $conn->lastInsertId();
                                $id_suffix = $edo_pro_id . str_pad($id, 7, '0', STR_PAD_LEFT);
                                $ref1 = "{$last_two_digits}{$id_suffix}";

                                $sql = "INSERT INTO donation (rec_email1, rec_email2, amount, status_receipt, name_title, donation_fullname, rec_idname, rec_tel, address, province, amphure, district, zip_code, edo_pro_id, edo_name, edo_description, rec_date_s, payby, status_donat, status_user, receipt_cc, ref1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                $stmt_receipt = $conn->prepare($sql);
                                $result = $stmt_receipt->execute([$rec_email1, $rec_email2, $amount, $status_receipt, $name_title, $donation_fullname, $rec_idname, $rec_tel, $address, $province, $amphure, $district, $zip_code, $edo_pro_id, $edo_name, $edo_description, $rec_date_s, 'QR CODE', 'online', 'person', 'confirm', $ref1]);

                                if ($result) {
                                    $lastInsertedId = $conn->lastInsertId();
                                    $pdflink = "https://app.nurse.cmu.ac.th/edonation/finance/pdf_maker.php?id=$lastInsertedId&ACTION=VIEW";
                                    $updateSql = "UPDATE donation SET pdflink = :pdflink WHERE id = :lastInsertedId";
                                    $updateStmt = $conn->prepare($updateSql);
                                    $updateStmt->bindParam(':pdflink', $pdflink, PDO::PARAM_STR);
                                    $updateStmt->bindParam(':lastInsertedId', $lastInsertedId, PDO::PARAM_INT);
                                    $updateResult = $updateStmt->execute();

                                    if ($updateResult) {
                                        echo '
                                <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                                <script>
                                    swal({
                                        title: "บันทึกข้อมูลบริจาคสำเร็จ",
                                        text: "กรุณารอสักครู่",
                                        type: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    }, function(){
                                        window.location.href = "qrgenerator?id=' . $id . '&amount=' . $amount . '&rec_date_s=' . $rec_date_s . '&ref1=' .  $ref1 . '&lang=' .  $_SESSION['lang'] . '";
                                    });
                                </script>';
                                    } else {
                                        echo '
                                <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                                <script>
                                    swal({
                                        title: "เกิดข้อผิดพลาดในการอัพเดต",
                                        type: "error"
                                    }, function() {
                                        window.location = "index";
                                    });
                                </script>';
                                    }
                                } else {
                                    echo '
                            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                            <script>
                                swal({
                                    title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
                                    type: "error"
                                }, function() {
                                    window.location = "index";
                                });
                            </script>';
                                }
                            } else {
                                echo "ไม่พบข้อมูลในตาราง donation สำหรับ ID: $id";
                            }
                        } else {
                            echo '
                            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
                            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
                            <script>
                                swal({
                                    title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
                                    type: "error"
                                }, function() {
                                    window.location = "index";
                                });
                            </script>';
                        }
                    }
                }
                ?>
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


</body>

</html>