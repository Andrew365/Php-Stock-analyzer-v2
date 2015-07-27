<?php
require'templates/master.php';
require 'templates/header.php';
?>

  <head>
    <link rel="stylesheet" href="public/stylesheets/dashboard.css"/>
    <meta charset="utf-8">
    <title></title>
    <script type="text/javascript">

    </script>
  </head>
  <body>
    <div id="error">

    </div>

        <h1>Dashboard</h1>
      <div class="container">
        <h3>Long-Term Stock Analysis</h3>
        <hr />
        <?php
          require 'functions/showTickers.php';
          showTickers('analysis_a');
          if(isset($_POST['TNF'])){
            echo '<script type="text/javascript">
              $("#error").html("That ticker doesnt exist");
            </script>';
          }
        ?>
      </div>
  </body>
</html>

<!--
-
-put PHP functions here
-
 -->
