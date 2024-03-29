<!doctype html>
<html lang="en">

<?php require_once 'config_th/head.php'; ?>

<body id="section_1">
    <?php require_once 'config_th/header.php';
    require_once 'config_th/nav.php'; ?>
    <main>
        <section class="cta-section section-padding section-bg">
            <div class="col-lg-8 col-12 mx-auto">
                <form class="custom-form donate-form" action="donat_db" method="POST" role="form">
                    <?php
                    if (isset($_GET['id'])) {
                        require_once 'config_th/connection.php';
                        $stmt = $conn->prepare("SELECT * FROM project_th WHERE id=?");
                        $stmt->execute([$_GET['id']]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    ?>
                    <h3 class="mb-4"><?= $row['edo_name']; ?></h3>
                    <div class="row">
                        <div class="col-lg-6 col-12 mt-3">
                            <input type="email" name="rec_email1" id="rec_email1" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="อีเมล">
                        </div>
                        <div class="col-lg-6 col-12 mt-3">
                            <input type="email" name="rec_email2" id="rec_email2" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="ยืนยันอีเมล">
                        </div>
                        <div class="col-lg-12 col-12 mt-3">
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="ระบุจำนวนเงินบริจาค">
                        </div>
                        <div class="col-lg-12 col-12 mt-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status_receipt" id="status_receipt">
                                <label class="form-check-label" for="status_receipt">
                                    ต้องการใบเสร็จรับเงิน
                                </label>
                            </div>
                            <div class="row" id="newform" style="display: none;">
                                <div class="col-lg-2 col-12 mt-3">
                                    <select name="name_title" id="name_title" class="form-control">
                                        <option value=""></option>
                                        <option value="นาย">นาย</option>
                                        <option value="นาง">นาง</option>
                                        <option value="นางสาว">นางสาว</option>
                                    </select>
                                </div>
                                <div class="col-lg-5 col-12 mt-3">
                                    <input type="text" name="donation_fullname" id="donation_fullname" class="form-control" placeholder="ชื่อ-สกุล">
                                </div>
                                <div class="col-lg-5 col-12 mt-3">
                                    <input type="number" name="rec_idname" id="rec_idname" class="form-control" placeholder="เลขประจำตัวประชาชน">
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <input type="number" name="rec_tel" id="rec_tel" class="form-control" placeholder="เบอร์โทรศัพท์มือถือ">
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="ที่อยู่">
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <?php
                                    require_once 'config_th/connect.php';
                                    $sql = "SELECT * FROM provinces";
                                    $query = mysqli_query($conn, $sql);
                                    ?>
                                    <select name="provinces" id="province" class="form-control">
                                        <option value="">เลือกจังหวัด</option>
                                        <?php while ($result = mysqli_fetch_assoc($query)) : ?>
                                            <option value="<?= $result['id'] ?>"><?= $result['name_th'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <select name="amphures" id="amphure" class="form-control">
                                        <option value="">เลือกอำเภอ</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <select name="districts" id="district" class="form-control">
                                        <option value="">เลือกตำบล</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="form-control mt-4">ถัดไป</button>
                        </div>
                    </div>
                    <!-- <?php
                    echo '<pre>';
                    print_r($_POST);
                    echo '</pre>';
                    ?> -->
                </form>

            </div>
        </section>
    </main>
    <?php require_once('config_th/footer.php'); ?>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.sticky.js"></script>
    <script src="../js/click-scroll.js"></script>
    <script src="../js/counter.js"></script>
    <script src="../js/custom.js"></script>
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