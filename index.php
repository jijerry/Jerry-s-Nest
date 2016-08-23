<?php   //index.php
/** 创建首页
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/20
 * Time: 17:28
 */
include_once "header.php";
echo "<br><span class='main'>Welcome to Jerry's Nest, ";

if ($loggedin)
    echo "$user, you are logged in.";
else
    echo "Please sign up and/or in to join in.";

?>
</span></body></html>