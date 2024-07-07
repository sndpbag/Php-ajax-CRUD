<?php
$conn = new mysqli("localhost","root","","m_form");

if($conn->connect_error)
{
    die("Connection failed: ". $conn->connect_error);
}

?>