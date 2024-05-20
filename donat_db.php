<?php
if (isset($_POST['submit'])) {
    if (
        !empty($_POST['rec_email'])
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

            $edo_pro_id = $_POST['edo_pro_id'];

            $id_year = date('Y') + 543;
            $last_two_digits = substr($id_year, -2);
            $lastInsertedId = $conn->lastInsertId();
            $id_suffix = $edo_pro_id . str_pad($lastInsertedId, 7, '0', STR_PAD_LEFT); // แก้ไขตัวแปร $id เป็น $lastInsertedId
            $ref1 = "{$last_two_digits}{$id_suffix}";

            $status_receipt = isset($_POST['status_receipt']) ? 1 : 0;
            $payby = 'QR CODE';
            $status_donat = 'online';
            $status_user = 'person';
            $receipt_cc = 'no confirm';
            $id_receipt = '0';

            $stmt = $conn->prepare("INSERT INTO receipt_offline
                                (rec_email, rec_email2, amount, name_title, rec_name, rec_idname, rec_tel, address, provinces, amphures, districts, zip_code, status_receipt, edo_pro_id, edo_description, rec_date_s, edo_name, ref1, payby, status_donat, status_user, receipt_cc, id_receipt)
                                VALUES (:rec_email, :rec_email2, :amount, :name_title, :rec_name, :rec_idname, :rec_tel, :address, :province_name, :amphure_name, :district_name, :zip_code, :status_receipt, :edo_pro_id, :edo_description, :rec_date_s, :edo_name,:ref1, :payby, :status_donat, :status_user, :receipt_cc, :id_receipt)");
            $stmt->bindParam(':rec_email', $_POST['rec_email'], PDO::PARAM_STR);
            $stmt->bindParam(':rec_email2', $_POST['rec_email2'], PDO::PARAM_STR);
            $stmt->bindParam(':amount', $_POST['amount'], PDO::PARAM_STR);
            $stmt->bindParam(':name_title', $_POST['name_title'], PDO::PARAM_STR);
            $stmt->bindParam(':rec_name', $_POST['rec_name'], PDO::PARAM_STR);
            $stmt->bindParam(':rec_idname', $_POST['rec_idname'], PDO::PARAM_STR);
            $stmt->bindParam(':rec_tel', $_POST['rec_tel'], PDO::PARAM_STR);
            $stmt->bindParam(':address', $_POST['address'], PDO::PARAM_STR);
            $stmt->bindParam(':province_name', $province_name, PDO::PARAM_STR);
            $stmt->bindParam(':id_receipt', $id_receipt, PDO::PARAM_STR);
            $stmt->bindParam(':amphure_name', $amphures_name, PDO::PARAM_STR);
            $stmt->bindParam(':district_name', $districts_name, PDO::PARAM_STR);
            $stmt->bindParam(':zip_code', $zip_code, PDO::PARAM_STR);
            $stmt->bindParam(':status_receipt', $status_receipt, PDO::PARAM_INT);
            $stmt->bindParam(':edo_name', $_POST['edo_name'], PDO::PARAM_STR);
            $stmt->bindParam(':edo_pro_id', $_POST['edo_pro_id'], PDO::PARAM_STR);
            $stmt->bindParam(':edo_description', $_POST['edo_description'], PDO::PARAM_STR);
            $stmt->bindParam(':rec_date_s', $_POST['rec_date_s'], PDO::PARAM_STR);
            $stmt->bindParam(':ref1', $ref1, PDO::PARAM_STR);
            $stmt->bindParam(':payby', $payby, PDO::PARAM_STR);
            $stmt->bindParam(':status_donat', $status_donat, PDO::PARAM_STR);
            $stmt->bindParam(':status_user', $status_user, PDO::PARAM_STR);
            $stmt->bindParam(':receipt_cc', $receipt_cc, PDO::PARAM_STR);
            $result = $stmt->execute();

            if ($result) {
                $lastInsertedId = $conn->lastInsertId();
                $lang = isset($_GET['lang']) ? $_GET['lang'] : '';
                $edo_pro_id = $_POST['edo_pro_id'];
                $id_year = date('Y') + 543;
                $last_two_digits = substr($id_year, -2);
                $id_suffix = $edo_pro_id . str_pad($lastInsertedId, 7, '0', STR_PAD_LEFT);
                $ref1 = "{$last_two_digits}{$id_suffix}";
                $stmt_update_ref1 = $conn->prepare("UPDATE receipt_offline SET ref1 = :ref1 WHERE id = :id");
                $stmt_update_ref1->bindParam(':ref1', $ref1, PDO::PARAM_STR);
                $stmt_update_ref1->bindParam(':id', $lastInsertedId, PDO::PARAM_INT);
                $stmt_update_ref1->execute();
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
                            window.location.href = "qrgenerator.php?id=' . $lastInsertedId . '&amount=' . $_POST['amount'] . '&rec_date_s=' . $_POST['rec_date_s'] . '&ref1=' . $ref1 . '&lang=' . $_SESSION['lang'] . '";
                        });
                    </script>';
            } else {
                echo '
      <script>
        swal({
          title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
          type: "error"
        }, function() {
          window.location = "donate_no_receipt.php";
        });
      </script>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo '
      <script>
        swal({
          title: "เกิดข้อผิดพลาดในการบันทึกข้อมูล",
          type: "error"
        }, function() {
          window.location = "donate_no_receipt.php";
        });
      </script>';
    }
}
