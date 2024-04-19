<?php
require_once 'config_th/connection.php';

$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);
if ($data !== null) {
    $id = $data['id'];
    $amount = $data['amount'];
    $rec_date_s = $data['rec_date_s'];
    $ref1 = $data['ref1'];
    try {
        $sql = "SELECT * FROM json_confirm WHERE amount = :amount AND date = :rec_date_s AND billPaymentRef1 = :ref1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':rec_date_s', $rec_date_s);
        $stmt->bindParam(':ref1', $ref1);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $response = [
                'status' => 'success',
                'message' => 'Matching record found in the database',
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No matching record found in the database'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid JSON data'
    ];
}
header('Content-Type: application/json');
echo json_encode($response);
