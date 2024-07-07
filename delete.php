<?php
include("conection.php");

if($_SERVER["REQUEST_METHOD"] =="POST" && isset($_POST["id"]))
{
    $id = $_POST["id"];
    $sql =  "DELETE FROM users WHERE `users`.`id` = ?";
    $data = $conn->prepare($sql);
    $data->bind_param("i", $id);
    if($data->execute())
    {
        echo json_encode(["success"=>true, "msg"=>"Data Deleted successfully"]);
    }
    else
    {
        echo json_encode(["success"=>false, "msg"=>"Data not Deleted successfully"]);  
    }
$data->close();

}

$conn->close();

?>