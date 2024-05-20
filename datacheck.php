<?php
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
$sMessage = '';
$response = [];
if ($data !== null) {
    $amount = $data['amount'];
    $id = $data['id'];
    $rec_date_s = $data['rec_date_s'];
    $ref1 = $data['ref1'];
    try {
        require_once 'config_th/connection.php';
        $sql = "SELECT * FROM json_confirm WHERE amount = :amount AND date = :rec_date_s AND billPaymentRef1 = :ref1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':rec_date_s', $rec_date_s);
        $stmt->bindParam(':ref1', $ref1);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $updateSql = "UPDATE receipt_offline SET resDesc = 'success' WHERE id = :id";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':id', $id);
            $updateResult = $updateStmt->execute();

            if ($updateResult) {
                // ตรวจสอบว่าข้อมูลซ้ำกันในตาราง receipt หรือไม่
                $checkDuplicateSql = "SELECT id FROM receipt WHERE id = :id";
                $checkStmt = $conn->prepare($checkDuplicateSql);
                $checkStmt->bindParam(':id', $id);
                $checkStmt->execute();

                if ($checkStmt->rowCount() === 0) {
                    // ไม่มีข้อมูลซ้ำกัน สามารถเพิ่มรายการใหม่ลงในตาราง receipt ได้

                    // คัดลอกข้อมูลจาก receipt_offline ไปยัง receipt
                    $insertSql = "INSERT INTO receipt (id, id_receipt, ref1, name_title, rec_name, rec_surname, rec_tel, rec_email, rec_idname, address, road, districts, amphures, provinces, zip_code, rec_date_s, amount, payby, edo_name, other_description, edo_pro_id, edo_description, edo_objective, comment, status_donat, status_user, status_receipt, resDesc, rec_time, pdflink, receipt_cc, dateCreate)
                                  SELECT id, id_receipt, ref1, name_title, rec_name, rec_surname, rec_tel, rec_email, rec_idname, address, road, districts, amphures, provinces, zip_code, rec_date_s, amount, payby, edo_name, other_description, edo_pro_id, edo_description, edo_objective, comment, status_donat, status_user, status_receipt, resDesc, rec_time, pdflink, receipt_cc, dateCreate
                                  FROM receipt_offline WHERE id = :id AND resDesc = 'success'
                                  ORDER BY dateCreate DESC
                                  LIMIT 1";
                    $insertStmt = $conn->prepare($insertSql);
                    $insertStmt->bindParam(':id', $id);
                    $insertResult = $insertStmt->execute();

                    if ($insertResult) {
                        // ค้นหา edo_pro_id และ receipt_id จากตาราง receipt
                        $selectProIdSql = "SELECT id_receipt, edo_pro_id, edo_description, payby, receipt_id, rec_email, name_title, rec_name, rec_surname, rec_date_s, rec_time, status_donat FROM receipt WHERE id = :id";
                        $selectProIdStmt = $conn->prepare($selectProIdSql);
                        $selectProIdStmt->bindParam(':id', $id);
                        $selectProIdStmt->execute();
                        $row = $selectProIdStmt->fetch(PDO::FETCH_ASSOC);

                        if ($row !== false) {
                            $edo_pro_id = $row['edo_pro_id'];
                            $receipt_id = $row['receipt_id']; // รับค่า receipt_id จากตาราง receipt
                            $email_receiver = $row['rec_email'];
                            $name_title = $row['name_title'];
                            $rec_name = $row['rec_name'];
                            $rec_surname = $row['rec_surname'];
                            $rec_date_s = $row['rec_date_s'];
                            $rec_time = $row['rec_time'];
                            $status_donat = $row['status_donat'];
                            $edo_description = $row['edo_description'];
                            $payby = $row['payby'];
                            $id_receipt = $row['id_receipt'];


                            // สร้าง id_receipt ใหม่
                            $id_year = "2567";
                            $id_suffix = $edo_pro_id . '-E' . str_pad($receipt_id, 4, '0', STR_PAD_LEFT);
                            $receipt = $id_year . '-' . $id_suffix;

                            // อัปเดตค่า id_receipt
                            $pdf_url = "https://app.nurse.cmu.ac.th/edonation/service/finance/invoice_confirm.php?receipt_id={$receipt_id}&ACTION=VIEW";
                            $updateIdSql = "UPDATE receipt SET id_receipt = :receipt, pdflink = :pdf_url WHERE id = :id";
                            $updateIdStmt = $conn->prepare($updateIdSql);
                            $updateIdStmt->bindParam(':receipt', $receipt);
                            $updateIdStmt->bindParam(':pdf_url', $pdf_url);
                            $updateIdStmt->bindParam(':id', $id);
                            $updateIdResult = $updateIdStmt->execute();
                            if ($updateIdResult) {
                                require_once "phpmailer/PHPMailerAutoload.php";
                                $mail = new PHPMailer;
                                $mail->CharSet = "UTF-8";
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->Port = 587;
                                $mail->SMTPSecure = 'tls';
                                $mail->SMTPAuth = true;

                                $gmail_username = "nursecmu.edonation@gmail.com";
                                $gmail_password = "hhhp ynrg cqpb utzi";

                                $sender = "noreply@NurseCMU E-Donation";
                                $email_sender = "nursecmu.edonation@gmail.com";
                                $email_receiver = $email_receiver;

                                $subject = "ระบบการแจ้งเตือน การบริจาคเงิน อัตโนมัติ ";

                                $mail->Username = $gmail_username;
                                $mail->Password = $gmail_password;
                                $mail->setFrom($email_sender, $sender);
                                $mail->addAddress($email_receiver);
                                $mail->Subject = $subject;
                                $email_content = "
                                <!DOCTYPE html>
                                <html>
                                <head>
                                <meta charset='utf-8'>
                                </head>
                                <body>
                                <h1 style='background: #FF6A00; padding: 10px 0 10px 10px; margin-bottom: 10px; font-size: 20px; color: white;'>
                                <p>NurseCMUE-Donation</p>
                                </h1>
                                <style>
                                .bold-text {
                                font-weight: bold;
                                }
                                </style>
                                <div style='padding: 20px;'>
                                <div style='margin-top: 10px;'>
                                <h3 style='font-size: 18px;'>ข้อความอัตโนมัติ : ยืนยันการชำระเงิน ผ่าน NurseCMUE-Donation</h3>
                                <h4 style='font-size: 16px; margin-top: 10px;'>รายละเอียด</h4>
                                <a class='bold-text'>โครงการ :</a> $edo_description<br>
                                <a class='bold-text'>เลขที่ใบเสร็จ :</a> $receipt<br>
                                <a class='bold-text'>ผู้บริจาค :</a> $name_title $rec_name<br>
                                <a class='bold-text'>จำนวนเงิน :</a> $amount บาท<br>
                                <a class='bold-text'>วันที่ :</a> $rec_date_s<br>
                                </div>                                    <div style='margin-top: 10px;'>
                                <a class='bold-text'>
                                    <a href='https://app.nurse.cmu.ac.th/edonation/pdf_maker.php?receipt_id=$receipt_id&ACTION=VIEW' download target='_blank' style='font-size: 20px; text-decoration: none; color: #3c83f9;'>ดาวน์โหลดใบเสร็จ (PDF)</a>
                                </a>
                                <h5></h5>
                                <a class='bold-text'>ขอแสดงความนับถือ</a>
                                <br>
                                <a class='bold-text'>คณะพยาบาลศาสตร์ มหาวิทยาลัยเชียงใหม่</a>
                            </div>
                            <div style='margin-top: 2px;'>
                                <hr>
                                <h4 class='bold-text'>หมายเหตุ:</h4>
                                <p class='bold-text'>- ใบเสร็จรับเงินจะมีผลสมบูรณ์ต่อเมื่อได้รับชำระเงินเรียบร้อยแล้วและมีลายเซ็นของผู้รับเงินครบถ้วน</p>
                                <p class='bold-text'>- อีเมลฉบับนี้เป็นการแจ้งข้อมูลโดยอัตโนมัติ กรุณาอย่าตอบกลับ หากต้องการสอบถามรายละเอียดเพิ่มเติม โทร. 053-949075 | นางสาวชนิดา ต้นพิพัฒน์ งานการเงิน การคลังและพัสดุ คณะพยาบาลศาสตร์ มหาวิทยาลัยเชียงใหม่</p>
                            </div>
                        </div>
                        <div style='text-align:center; margin-bottom: 50px;'>
                            <img src='https://app.nurse.cmu.ac.th/edonation/TCPDF/bannernav.jpg' style='width:100%' />
                        </div>
                        <div style='background: #FF6A00; color: #ffffff; padding: 30px;'>
                            <div style='text-align: center'>
                                2023 © NurseCMUE-Donation
                            </div>
                        </div>
                    </body>
                    </html>";
                                $mail->msgHTML($email_content);

                                if (!$mail->send()) {
                                    echo "Email sending failed: " . $mail->ErrorInfo;
                                } else {
                                    echo "Email sent successfully.";
                                }
                                function notify_message($sMessage, $Token)
                                {
                                    $chOne = curl_init();
                                    curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                                    curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
                                    curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
                                    curl_setopt($chOne, CURLOPT_POST, 1);
                                    curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
                                    $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $Token . '',);
                                    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                                    curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
                                    $result = curl_exec($chOne);
                                    if (curl_error($chOne)) {
                                        echo 'error:' . curl_error($chOne);
                                    }
                                    curl_close($chOne);
                                }
                                function thai_date($date)
                                {
                                    $months = [
                                        'ม.ค', 'ก.พ', 'มี.ค', 'เม.ย', 'พ.ค', 'มิ.ย',
                                        'ก.ค', 'ส.ค', 'ก.ย', 'ต.ค', 'พ.ย', 'ธ.ค'
                                    ];

                                    $timestamp = strtotime($date);
                                    $thai_year = date(' Y', $timestamp) + 543;
                                    $thai_date = date('j ', $timestamp) . $months[date('n', $timestamp) - 1] . ' ' . $thai_year;

                                    return $thai_date;
                                }
                                // 6GxKHxqMlBcaPv1ufWmDiJNDucPJSWPQ42sJwPOsQQL bot test
                                // VnaAYBFqNRPYNLKLeBA3Uk9kFFyFsYdUbw8SmU9HNWf 
                                $sToken = ["6GxKHxqMlBcaPv1ufWmDiJNDucPJSWPQ42sJwPOsQQL"]; // เพิ่ม Token ของคุณที่นี่
                                $sMessage = "\n";
                                $sMessage .= "โครงการ: " . $edo_description . "\n";
                                $sMessage .= "\n";
                                $sMessage .= "เลขที่ใบเสร็จ: " . $receipt . "\n";
                                $sMessage .= "ผู้บริจาค : " . $name_title . " " . $rec_name . " " . $rec_surname . "\n";
                                $sMessage .= "\n";
                                $sMessage .= "จำนวน: " . number_format($amount, 2) . " บาท\n";
                                $sMessage .= "วันที่โอน: " . thai_date($rec_date_s) . "\n";
                                $sMessage .= "ชำระโดย: " . $payby . "\n";
                                // เรียกใช้งานฟังก์ชัน notify_message สำหรับทุก Token
                                foreach ($sToken as $Token) {
                                    notify_message($sMessage, $Token);
                                }
                            } else {
                                $response = [
                                    'message' => 'ไม่สามารถอัปเดตค่า id_receipt ได้'
                                ];
                            }
                        } else {
                            $response = [
                                'message' => 'ไม่พบข้อมูล edo_pro_id และ receipt_id จากตาราง receipt'
                            ];
                        }
                    } else {
                        $response = [
                            'message' => 'ไม่สามารถบันทึกข้อมูลในตาราง receipt ได้'
                        ];
                    }
                } else {
                    $response = [
                        'message' => 'success'
                    ];
                }
            } else {
                $response = [
                    'message' => 'ไม่สามารถอัปเดตข้อมูลในฐานข้อมูลได้'
                ];
            }
        } else {
            $response = [
                'message' => 'ไม่พบข้อมูลที่ตรงกันในฐานข้อมูล'
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } catch (PDOException $e) {
        echo 'เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล: ' . $e->getMessage();
    }
} else {
    echo 'ไม่สามารถแปลงข้อมูล JSON ได้';
}
