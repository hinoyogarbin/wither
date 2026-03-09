<?php
header('Content-Type: application/json');
include '../config/config.php';

$input = json_decode(file_get_contents('php://input'), true);

if(isset($input['marker_name'], $input['latitude'], $input['longitude'])) {
    $stmt = $conn->prepare("INSERT INTO markers (marker_name, latitude, longitude) VALUES (?, ?, ?)");
    $stmt->bind_param("sdd", $input['marker_name'], $input['latitude'], $input['longitude']);
    if($stmt->execute()){
        echo json_encode(['status'=>'success', 'marker_id'=>$stmt->insert_id]);
    } else {
        echo json_encode(['status'=>'error','message'=>$stmt->error]);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid input']);
}
?>