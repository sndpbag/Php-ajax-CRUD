<?php
include("conection.php");

$sql = "SELECT * FROM users";

$data = $conn->prepare($sql);

// if($data == false)
// {
//     echo "preparer method failed:".$conn->error;
//     exit;
// }

if($data)
{
    $data->execute();
  $result =  $data->get_result();
  $record = $result->fetch_all(MYSQLI_ASSOC);
 
  echo json_encode($record);

}
else
{
    echo "preparer method failed:".$conn->error;
   
}

$data->close();
$conn->close();



?>