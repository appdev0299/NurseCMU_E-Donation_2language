<?php
if (
    !empty($_POST['rec_email1'])
    && !empty($_POST['rec_email2'])
    && !empty($_POST['amount'])
) {
    try {
        require_once 'config_th/connection.php';

        $province_code = $_POST['provinces'];
        $stmt_province = $conn->prepare("SELECT name_th FROM provinces WHERE id = :province_code");
        $stmt_province->bindParam(':province_code', $province_code, PDO::PARAM_STR);
        $stmt_province->execute();
        $province_result = $stmt_province->fetch(PDO::FETCH_ASSOC);
        $province_name = $province_result ? $province_result['name_th'] : '';

        $amphures_code = $_POST['amphures'];
        $stmt_amphures = $conn->prepare("SELECT name_th FROM amphures WHERE id = :amphures_code");
        $stmt_amphures->bindParam(':amphures_code', $amphures_code, PDO::PARAM_STR);
        $stmt_amphures->execute();
        $amphures_result = $stmt_amphures->fetch(PDO::FETCH_ASSOC);
        $amphures_name = $amphures_result ? $amphures_result['name_th'] : '';

        $districts_code = $_POST['districts'];
        $stmt_districts = $conn->prepare("SELECT name_th, zip_code FROM districts WHERE id = :districts_code");
        $stmt_districts->bindParam(':districts_code', $districts_code, PDO::PARAM_STR);
        $stmt_districts->execute();
        $districts_result = $stmt_districts->fetch(PDO::FETCH_ASSOC);
        $districts_name = $districts_result ? $districts_result['name_th'] : '';
        $zip_code = $districts_result ? $districts_result['zip_code'] : '';

        $status_receipt = isset($_POST['status_receipt']) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO receipt_2567
            (rec_email1, rec_email2, amount, name_title, donation_fullname, rec_idname, rec_tel, address, province, amphure, district, zip_code, status_receipt)
            VALUES (:rec_email1, :rec_email2, :amount, :name_title, :donation_fullname, :rec_idname, :rec_tel, :address, :province_name, :amphure_name, :district_name, :zip_code, :status_receipt)");

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

        $result = $stmt->execute();

        if ($result) {
            echo "บันทึกข้อมูลเรียบร้อยแล้ว";
        } else {
            echo "มีข้อผิดพลาดในการบันทึกข้อมูล";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ไม่มีข้อมูลที่จำเป็นสำหรับการบันทึก";
}
