<?php
include("conection.php");
$id = $_POST["id"];
$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];




if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {

    $photo_name = $_FILES['photo']['name'];
    $photo_tmp_name =  $_FILES['photo']['tmp_name'];
    $folder = "upload/";
    $photo_path = $folder . $photo_name;
    if (move_uploaded_file($photo_tmp_name, $photo_path)) {
        $photo_uploaded = true;
    } else {
        $photo_uploaded = false;
    }
} else {
    $photo_uploaded = false;
}


$sql = "UPDATE users SET name=?, email=?, password = ?";

if ($photo_uploaded) {
    $sql .= ", photo=?";
}

$sql .= " WHERE id=?";


if ($data = $conn->prepare($sql)) {

    if ($photo_uploaded) {
        $data->bind_param("ssssi", $name, $email, $password, $photo_path, $id);
    } else {
        $data->bind_param("sssi", $name, $email, $password, $id);
    }

    if ($data->execute()) {
        echo json_encode(['success' => true, "msg" => "updated successfully"]);
    } else {
        echo json_encode(['success' => false, "msg" => "updated not successfully"]);
    }
    $data->close();
}
 else 
 {
    echo "prepared statement failed".$conn->error;
}

$conn->close();