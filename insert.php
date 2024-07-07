<?php
include("conection.php");

$errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST")
{

$name = $_POST["name"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
$photo = $_FILES["photo"];



// photo extraction
$photo_name = $photo["name"];
$photo_size = $photo["size"];
$photo_tmp_name = $photo["tmp_name"];

// photo folder path
$folder = "upload/";
$photo_path = $folder.$photo_name;


// data validation
if(empty($name))
{
  $errors["name"] = "name field required";
}
if(empty($email))
{
    $errors["email"]  = "email field required";
}

if(!empty($errors))
{
 echo json_encode(["success" =>false,"errors" =>$errors]);
 exit;
}



// end data validation


$sql = "INSERT INTO users(name,email,password,photo) VALUES(?,?,?,?)";

$data =  $conn->prepare($sql);

if($data==false)
{
    echo "prepared statement failed".$conn->error;
    exit;
}

$data->bind_param("ssss",$name,$email,$password,$photo_path);

if($data->execute())
{
    move_uploaded_file($photo_tmp_name,$photo_path);
     echo json_encode(["success"=>true, "msg"=>"Data Save successfully"]);
}

$data->close();

}


$conn->close();



?>