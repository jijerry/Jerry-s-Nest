<?php   //header.php
/** 相同特征集
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/18
 * Time: 20:26
 */
require_once "functions.php";
echo "<!DOCTYPE html>
<html>
    <head>
        <script src='OSC.js'></script>";

session_start();

$userstr = ' (Guest)';


if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "($user)";
}
else
{
    echo $loggedin = FALSE;
}
//  链接外部样式表
echo "<title>$appName$userstr</title>
      <link rel='stylesheet' href='style.css' type='text/css'>
      </head>
      <body>
      <canvas id='logo' width='624' height='96'>$appName</canvas>
      <div class='appname'>$appName$userstr</div></body>
      <script src='javascript.js'></script>";

if ($loggedin)
{
    echo "<br><ul class='menu'>.
          <li><a href='member.php?view=$user'></a></li>
          <li><a href='member.php'>Members</a> </li>
          <li><a href='frends.php'>Frends</a> </li>
          <li><a href='messages.php'>Messages</a></li>
          <li><a href='profile.php'>Edit Profile</a></li>
          <li><a href='logout.php'>Log out</a> </li>
              </ul>
          </br>";
}
else
{
    echo"<br><ul class='menu'>
        <li><a href='index.php'>Home</a></li>             
        <li><a href='signup.php'>Sign up</a></li>
        <li><a href='login.php'>Log in</a></li></ul><br>
        <span class='info'>&#8658; You must be logged in to view this page</span><br/><br/>";
}
?>
