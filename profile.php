<?php   //profile.php
/**个人简介
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/30
 * Time: 9:27
 */
require_once 'header.php';

if (!$loggedin) die();  //确认有用户登录，才能显示页面标题

echo "<div class='main'><h3>Your Profile</h3>";

$result = queryMysql($db_server, "SELECT * FROM profiles WHERE user='$user'");

if (isset($_POST['text']))
{
    //双重安全检查
    $text = santizeString($db_server,$_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);    //单个空格代替所有长空格

    if ($result->num_rows)
        queryMysql($db_server,"UPDATE profiles SET text='$text' where user='$user'");
    else queryMysql($db_server, "INSERT INTO profiles VALUES('$user', '$text')");
}
else
{
    if ($result->num_rows)
    {
        $row  = $result->fetch_array(MYSQLI_ASSOC);
        $text = stripslashes($row['text']);
    }
    else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

if (isset($_FILES['image']['name']))
{
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
        case "image/gif":   $src = imagecreatefromgif($saveto); break;
        case "image/jpeg":  // Both regular and progressive jpegs
        case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
        case "image/png":   $src = imagecreatefrompng($saveto); break;
        default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
        list($w, $h) = getimagesize($saveto);

        $max = 100;
        $tw  = $w;
        $th  = $h;

        if ($w > $h && $max < $w)
        {
            $th = $max / $w * $h;
            $tw = $max;
        }
        elseif ($h > $w && $max < $h)
        {
            $tw = $max / $h * $w;
            $th = $max;
        }
        elseif ($max < $w)
        {
            $tw = $th = $max;
        }

        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
        imageconvolution($tmp, array(array(-1, -1, -1),
            array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
        imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}

showProfile($db_server, $user);

//enctype参数同时上传多种类型数据
echo <<<_END
    <form method='post' action='profile.php' enctype='multipart/form-data'>
    <h3>Enter or edit your details and/or upload an image</h3>
    <textarea name='text' cols='50' rows='3'>$text</textarea><br>
_END;
?>

<!--input type = file:创建浏览按钮，完成文件上传-->
Image: <input type='file' name='image' size='14'>
<input type='submit' value='Save Profile'>
</form></div><br>
</body>
</html>