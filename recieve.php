<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    if ($data !== null) {
        require_once 'config_th/connection.php';

        $stmt = $conn->prepare("INSERT INTO json_confirm 
            (payeeProxyId, payeeProxyType, payeeAccountNumber, payeeName, 
            payerAccountNumber, payerAccountName, payerName, sendingBankCode, 
            receivingBankCode, amount, transactionId, transactionDateandTime, 
            billPaymentRef1, billPaymentRef2, currencyCode, channelCode, 
            transactionType)
            VALUES
            (:payeeProxyId, :payeeProxyType, :payeeAccountNumber, :payeeName, 
            :payerAccountNumber, :payerAccountName, :payerName, :sendingBankCode, 
            :receivingBankCode, :amount, :transactionId, :transactionDateandTime, 
            :billPaymentRef1, :billPaymentRef2, :currencyCode, :channelCode, 
            :transactionType)");

        $stmt->bindParam(':payeeProxyId', $data->payeeProxyId, PDO::PARAM_STR);
        $stmt->bindParam(':payeeProxyType', $data->payeeProxyType, PDO::PARAM_STR);
        $stmt->bindParam(':payeeAccountNumber', $data->payeeAccountNumber, PDO::PARAM_STR);
        $stmt->bindParam(':payeeName', $data->payeeName, PDO::PARAM_STR);
        $stmt->bindParam(':payerAccountNumber', $data->payerAccountNumber, PDO::PARAM_STR);
        $stmt->bindParam(':payerAccountName', $data->payerAccountName, PDO::PARAM_STR);
        $stmt->bindParam(':payerName', $data->payerName, PDO::PARAM_STR);
        $stmt->bindParam(':sendingBankCode', $data->sendingBankCode, PDO::PARAM_STR);
        $stmt->bindParam(':receivingBankCode', $data->receivingBankCode, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $data->amount, PDO::PARAM_STR);
        $stmt->bindParam(':transactionId', $data->transactionId, PDO::PARAM_STR);
        $stmt->bindParam(':transactionDateandTime', $data->transactionDateandTime, PDO::PARAM_STR);
        $stmt->bindParam(':billPaymentRef1', $data->billPaymentRef1, PDO::PARAM_STR);
        $stmt->bindParam(':billPaymentRef2', $data->billPaymentRef2, PDO::PARAM_STR);
        $stmt->bindParam(':currencyCode', $data->currencyCode, PDO::PARAM_STR);
        $stmt->bindParam(':channelCode', $data->channelCode, PDO::PARAM_STR);
        $stmt->bindParam(':transactionType', $data->transactionType, PDO::PARAM_STR);

        $result = $stmt->execute();

        if ($result) {
            $response = array(
                "resCode" => "00",
                "resDesc" => "success",
                "transactionId" => $data->transactionId,
                "confirmId" => $conn->lastInsertId()
            );
            echo json_encode($response);
        } else {
            http_response_code(500);
            echo "Failed to save data to the database.";
        }
    } else {
        http_response_code(400);
        echo "Invalid JSON data received.";
    }
} else {
    http_response_code(405);
    echo "Invalid request method.";
}
