<?php
require '../includes/connect.php';
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$tablemake = "CREATE TABLE IF NOT EXISTS users(
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(120) NOT NULL,
  email VARCHAR(60) NOT NULL,
  password VARCHAR(120) NOT NULL,
  reg_date TIMESTAMP,
  activated ENUM('0','1') DEFAULT '0',
  user_level ENUM('1', '2') DEFAULT '1'
)";
$table_create = mysqli_query($connect, $tablemake);
if(!$table_create){
  echo mysqli_error($connect);
}
  if(!empty($username) && !empty($password2) && !empty($password) && !empty($email)){
    $sql2 = "SELECT 8 FROM users WHERE username = '$username'";
    $sql_res = mysqli_query($connect, $sql2);
    if(!$sql_res){
      echo mysqli_error($connect);
    }
    if(mysqli_fetch_array($sql_res)> 0){
      echo "that username already exists";
    }else{
      if($password == $password2){

        $password = sha1($password);
        $password = md5($password);
        $password = $password -7;

        $sql3 = "INSERT INTO users (username, email, password, activated)  VALUES ('$username', '$email', '$password', '1')";
        $sql_res = mysqli_query($connect, $sql3);
        if(!$sql_res){
          echo mysqli_error($connect);
        }
          if($sql_res){
            session_start();
            $_SESSION['logged'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            require 'authController.php';
          }

        }
      else{
        echo "passwords dont match";
      }
    }
  }