<?php require 'templates/master.php';?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
  </head>
  <body>
    <form class="form" action="functions/register.php" method="post">
      <table>
        <tr>
          <td>
            Username
          </td>
          <td>
            <input class="form-control" type="text" name="username" value="">
          </td>
        </tr>
        <tr>
          <td>
            Email
          </td>
          <td>
            <input class="form-control" type="email" name="email" value="">
          </td>
        </tr>
        <tr>
          <td>
            Password
          </td>
          <td>
            <input class="form-control" type="password" name="password" value="">
          </td>
        </tr>
        <tr>
          <td>
            Confirm Password
          </td>
          <td>
            <input class="form-control" type="password" name="password2" value="">
          </td>
        </tr>
        <tr>
          <td>
            <input class="form-control"  type="submit" name="submit" value="Submit">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
