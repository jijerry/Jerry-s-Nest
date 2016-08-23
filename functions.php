<?php   //functions.php
/** 包含数据库文件
 *  数据库连接
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/18
 * Time: 11:54
 */

//密码加密使用PASSWORD函数进行字符串16进制，或者AES——DESRCPT二进制加密

define("DB_HOSTNAME", 'localhost');
define("DB_DATABASE", 'Nest');
define("DB_USERNAME", 'root');
define("DB_PASSWORD", '');

//$db_hostname = "localhost";
//$db_database = "Nest";
//$db_username = "root";
//$db_password = "";
$appName = "Jerry's Nest";
$db_server = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
if (!$db_server) die("Unable to connect to MYSQL".mysqli_error($db_server));
mysqli_select_db($db_server, DB_DATABASE) or die("Unable to select database".mysqli_error($db_server));

//创建数据库表
function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "the $name is created success or existed";
}
//查询数据库
function queryMysql($db_server,$query)
{
    $result = mysqli_query($db_server,$query) or die(mysqli_error($db_server));
    return $result;
}
//销毁session会话
function destorySession()
{
    $_SESSION = array();
    if (session_id()!= "" || isset($_COOKIE['session_name']))
    {
        setcookie(sesson_name(),'',time()-2592000,'/');
        session_destroy();
    }
}
//删除用户输入的恶意代码
function santizeString($db_server ,$var)
{
    $var = strip_tags($var);    //字符串中删除php和html标记
    $var = ($var);  //将字符串转换为html实体
    $var = stripslashes($var);  //删除转译\
    return mysqli_real_escape_string($db_server,$var); //转译sql语句中的特殊字符,例如‘
}

//显示用户图像和关于文件
function showProfile($user)
{
    if (file_exists("user.jpg"))    //检查文件或者目录是否存在,括号内文件名或者路径
        echo "<img src = 'user.jpg' align = 'left'/>";  //插入图片

    $result = queryMysql("SELECT * FROM profiles WHERE user = '$user'");    //查询可以采用sprintf函数接收全部变量的值赋给%s
    if (mysqli_num_rows($result))
    {
        $row = mysqli_fetch_row($result);
        echo stripslashes($row[1])."<br clear = left /><br/>";
    }
}