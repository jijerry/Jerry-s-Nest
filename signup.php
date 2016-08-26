<?php   //signup.php
/**注册模块
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/23
 * Time: 12:02
 */
include_once "header.php";
echo <<<_END
<script>
function checkUser(user)
{
    if (user.value =='')
    {
//        O('info').innerHtml = ''
        document.getElementById('info').innerHTML = ''
        return
    }
param = "user=" + user.value
request = new ajaxRequest()
request.open("POST","checkuser.php",true)
request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
request.setRequestHeader("Content_length",param.length)
request.setRequestHeader("Connection","close")

request.onreadystatechange = function ()
 {
        if (this.readyState == 4)
        {
            if (this.status == 200)
            {
                if (this.responseText!= null)
                {          
//                    O('info').innerHTML = this.responseText
                      document.getElementById('info').innerHTML = this.responseText
                }
                else alert("Ajax error:NO data received")
            }
            else alert("Ajax error:" + this.statusText)
        }
         
    }

request.send(param)
}

function ajaxRequest()
    {
        try //NON-IE brower?
        {
            var request = new XMLHttpRequest()
        }
        catch(e1)
        {
            try //IE 6+
            {
                request = new ActiveXObject("Msxml2.XMLHTTP")
            }
            catch(e2)
            {
                try //IE 5?
                {
                    request = new ActiveXObject("Microsoft.XMLHTTP")
                }
                catch (e3)  //This is no Ajax support
                {
                    request = false
                }


            }
        }
        return request;
    }
</script>
<div class = 'main'><h3>Please enter your detail to Sign up</h3>
_END;

$error = $user = $pass = "";
if (isset($_SESSION['user'])) destorySession();

if (isset($_POST['user']))
{
    $user = santizeString($db_server,$_POST['user']);
    $pass = santizeString($db_server,$_POST['pass']);

    if ($user == '' || $pass == '')
    {
        $error = "not all fields were entered<br/><br/>";
    }
    else
    {
        if (mysqli_num_rows(queryMysql($db_server,"SELECT * FROM members WHERE user = '$user'")))
        {
            $error = "That username is aleady existed";
        }
        else
        {
            queryMysql($db_server,"INSERT INTO members VALUES ('$user','$pass')");
            die("<h4>account created</h4>Please Log in.<br>");
        }
    }
}

echo <<<_END
<form method = 'POST' action = signup.php>$error<br/>
<span class = 'fieldname'>Username</span>
<input type = 'text' maxlength = '16' name = 'user' value = '$user' onBlur = 'checkUser(this)'/><span id = 'info'></span><br/>
<span class = 'fieldname'>Password </span>
<input type = 'text' maxlength = '16'name = 'pass' value = '$pass'/><br/>

<span class = 'fieldname'>&nbsp;</span>
<input type = 'submit' value = 'Sign up'/>
</form></div></br></body></html>
_END;

?>