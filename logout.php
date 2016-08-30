<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/30
 * Time: 19:40
 */
include_once "header.php";

if (isset($_SESSION['user']))
{
    destorySession();
    echo "<div class='main'> You have logged out.Please <a href='index.php'>click here</a> to refresh the screen";
}
else
{
    echo "<div class='main'><br/> You cannot logout because you are not logged in";

}

?>

<br></div></body></html>
