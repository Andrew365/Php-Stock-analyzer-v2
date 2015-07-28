<?php
session_start();
$user = $_SESSION['username'];
include('../includes/connect.php');
require '../functions/stockDownloader.php';

//Algorithm that checks if price goes up after going down
function masterLoop(){
  $user = $_SESSION['username'];

  require '../includes/connect.php';
    $mainTickerSQL = "SELECT * FROM {$user}tickers";
    $ticker_result = mysqli_query($connect, $mainTickerSQL);
    if(!$ticker_result){
      echo mysqli_error($connect);
      return false;
    }
    if($ticker_result = false){
      echo "No Tickers";
    }

    while($row = mysqli_fetch_array($ticker_result)){
      $ticker = $row['ticker'];


        $nextDayIncrease = 0;
        $nextDayDecrease = 0;
        $nextDayNoChange = 0;

        $sumOfIncreases = 0;
        $sumOfDecreases = 0;

        $total = 0;

        require '../includes/connect.php';

        $sql = "SELECT date, amount_change, percent_change FROM {$ticker}"; //WHERE percent_change < '0' ORDER BY date AS ASC";
        $data = mysqli_query($connect, $sql);
        if(!$data){
          echo mysqli_error($connect);
          return false;
        }

        if($data){
                        $total = 1;
            while($row = mysqli_fetch_array($data)){

                $date = $row['date'];
                $percent_change = $row['percent_change'];
                $sql2 = "SELECT date, percent_change FROM {$ticker} WHERE date > {$date} ORDER BY date ASC LIMIT 1";

                $data2 = mysqli_query($connect, $sql2);
                $numberOfRows = mysqli_num_rows($data2);


                if($numberOfRows == 1) {

                    $row2 = mysqli_fetch_row($data2);
                    $tom_date = $row2[0];
                    $tom_percent_change = $row[1];

                    if ($tom_percent_change > 0) {
                        $nextDayIncrease ++;
                        $sumOfIncreases += $tom_percent_change;

                        $total++;
                    } elseif ($tom_percent_change < 0) {
                        $nextDayDecrease++;
                        $sumOfDecreases += $tom_percent_change;

                        $total++;
                    } else {
                        $nextDayNoChange++;

                        $total++;
                    }
                }elseif($numberOfRows==0){
                    //no more data after today
                }else{
                    echo "you have an error in analysis_a";
                }
            }
        }
        else{
            echo "unable to select blah {$ticker} <br />" .  mysqli_error($connect);
        }
        $nextDayIncreasePercent = ($nextDayIncrease/$total) * 100;
        $nextDayDecreasePercent = ($nextDayDecrease/$total) * 100;

        $averageIncreasePercent = ( $nextDayIncreasePercent/$nextDayIncrease);
        $averageDecreasePercent = ($sumOfDecreases/$nextDayDecrease);


        insertIntoResultTable($ticker, $nextDayIncrease, $nextDayIncreasePercent, $averageIncreasePercent, $nextDayDecrease, $nextDayDecreasePercent, $averageDecreasePercent);
        header('Location: ../dashboard.php');
    }
}



//insert data into the result table
function  insertIntoResultTable($ticker, $nextDayIncrease, $nextDayIncreasePercent, $averageIncreasePercent, $nextDayDecrease, $nextDayDecreasePercent, $averageDecreasePercent){

    require '../includes/connect.php';
    $table_sql = "CREATE TABLE IF NOT EXISTS analysis_a (
                  ticker VARCHAR(8),
                  daysInc INTEGER,
                  pctOfDaysInc FLOAT,
                  avgIncPct FLOAT,
                  daysDec INTEGER,
                  pctOfDaysDec FLOAT,
                  avgDecPct FLOAT,
                  BuyValue FLOAT,
                  SellValue FLOAT
                   )";
    $table = mysqli_query($connect, $table_sql);
    if(!$table){
      echo 'cant create table' . mysqli_error($connect);
    }

    $BuyValue = $nextDayIncreasePercent * $averageIncreasePercent;
    $SellValue = $nextDayDecreasePercent * $averageDecreasePercent;

    $query="SELECT * FROM analysis_a WHERE ticker='$ticker' ";
    $result=mysqli_query($connect, $query);
    $numberOfRows = mysqli_num_rows($result);

    if($numberOfRows==1){
        $sql = "UPDATE analysis_a SET ticker='$ticker',daysInc='$nextDayIncrease',pctOfDaysInc='$nextDayIncreasePercent',avgIncPct='$averageIncreasePercent',daysDec='$nextDayDecrease',pctOfDaysDec='$nextDayDecreasePercent',avgDecPct='$averageDecreasePercent',BuyValue='$BuyValue',SellValue='$SellValue' WHERE ticker='$ticker' ";
        $res = mysqli_query($connect, $sql);
        if(!$res){
          echo mysqli_error($connect);
        }
    }else{
        $sql=  "INSERT INTO `analysis_a` (`ticker`, `daysInc`, `pctOfDaysInc`, `avgIncPct`, `daysDec`,
           `pctOfDaysDec`, `avgDecPct`, `BuyValue`, `SellValue`) VALUES ('$ticker', '$nextDayIncrease', '$nextDayIncreasePercent', '$averageIncreasePercent', '$nextDayDecrease', '$nextDayDecreasePercent', '$averageDecreasePercent', '$BuyValue', '.SellValue')";
           $res = mysqli_query($connect, $sql);
           if(!$res){
             echo mysqli_error($connect);
           }
    }

}
//call your function
masterLoop();

?>
