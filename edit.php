<?php
include("conection.php");

$id = $_POST["id"];

$sql = "SELECT * FROM  users WHERE id=?";

$data = $conn->prepare($sql);

if($data)
{
 $data->bind_param("i", $id);
 $data->execute();
$result = $data->get_result();
$record = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($record);

}
else
{
    echo "prepare failed".$conn->error;
}





?>