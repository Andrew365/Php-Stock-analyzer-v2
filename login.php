<?php require 'templates/master.php';?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form class="form" action="functions/login.php" method="post">
      <table>
        <tr>
          <td>
            Username
          </td>
          <td>
            <input type="text" name="username" value="">
          </td>
        </tr>
        <tr>
          <td>
            Password
          </td>
          <td>
            <input type="password" name="password" value="">
          </td>
        </tr>
        <tr>
          <td>
            <input type="submit" name="submit" value="Submit">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
