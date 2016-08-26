<?php   //checkuser.php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/23
 * Time: 21:26
*/
include_once "functions.php";

if (isset($_POST['user']))
{
    $user = santizeString($db_server,$_POST['user']);
    echo $user;
    if (mysqli_num_rows(queryMysql($db_server,"SELECT * FROM members WHERE user = '$user'")))
        echo "<span class='taken'>&#x2718; Sorry, this username is taken</span>";
    else
        echo "<span class='available'>&nbsp;&#x2714; This username is avaliable</span>";
}
