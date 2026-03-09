<?php
// saveSensor.php
header('Content-Type: application/json');

include '../config/config.php'; // adjust path to your config.php

// Get raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if(isset($input['marker_id'], $input['temperature'], $input['humidity'])) {
    $marker_id = $input['marker_id'];
    $temperature = $input['temperature'];
    $humidity = $input['humidity'];

    $stmt = $conn->prepare("INSERT INTO sensor (marker_id, temperature, humidity) VALUES (?, ?, ?)");
    $stmt->bind_param("idd", $marker_id, $temperature, $humidity);

    if($stmt->execute()) {
        echo json_encode(['status'=>'success','reading_id'=>$stmt->insert_id]);
    } else {
        echo json_encode(['status'=>'error','message'=>$stmt->error]);
    }

} else {
    echo json_encode(['status'=>'error','message'=>'Invalid input']);
}
?>