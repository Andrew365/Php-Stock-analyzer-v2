<?php

function deleteStock(){
  if(isset($_POST['delete'])){

    require '../includes/connect.php';
    $file = "../tickerMaster.txt";
    $ticker = $_POST['ticker'];
     $sql = "DROP TABLE {$ticker}";
     $data = mysqli_query($connect, $sql);
     if(!data){
       echo mysqli_error($connect);
     }
     $sql2 = "DELETE FROM `analysis_a` WHERE ticker = '{$ticker}'";
     $data2 = mysqli_query($connect, $sql2);

     if($data){

       header('Location: ../dashboard.php');

     }
     else{
    echo  mysqli_error($connect);
     }
     if($data2){

     }else{
       echo  mysqli_error($connect);
     }
     $sql4 = "DELETE FROM `tickers` WHERE ticker = '{$ticker}'";
     $result4 = mysqli_query($connect, $sql4);
     if($result4){
       header('Location: ../dashboard.php');
     }elseif (!$result4) {
      echo mysqli_error($connect);
     }

 }
 }
 deleteStock();
