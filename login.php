<?php   //login.php
/** 登录模块
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/26
 * Time: 20:30
 */
include_once "header.php";
echo "<div class='main'><h3>Please enter your details to log in</h3>";

$error = $user = $pass = "";
//if (isset($_SESSION['user'])) destorySession();

if (isset($_POST['user']))
{
    $user = santizeString($db_server, $_POST['user']);
    $pass = santizeString($db_server, $_POST['pass']);

    if ($user == "" || $pass == "")
    {
        $error = "Not all fields were entered<br/>";
    }
    else
    {
        $query = "SELECT * FROM members WHERE user = '$user' AND pass ='$pass'";

        if (mysqli_num_rows(queryMysql($db_server, $query)) == 0)
        {
            $error = "<span class='error'> Username/Password invalid</span><br/><br>";
        }
        else
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die("You are now logged in,please <a href = 'members.php? view =$user'>click here</a> to continue<br/><br/>");
        }
    }
}

echo <<<_END

<form method = 'POST' action = 'login.php'>$error<br/>
<span class = 'fieldname'>Username</span><input type = 'text' maxlength = '16' name = 'user' value = '$user'/><br/>
<span class = 'fieldname'>Password</span><input type = 'password' maxlength = '16' name = 'pass' value = '$pass'/>
<br/>
<span class="fieldname">&nbsp;</span>
<input type="submit" value="Login"/>
</form></div></body></html>

_END
?>