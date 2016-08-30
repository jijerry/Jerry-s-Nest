<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2016/8/30
 * Time: 12:37
 */
require_once 'header.php';

if (!$loggedin) die();

echo "<div class='main'>";


if (isset($_GET['view'])) {
    $view = santizeString($_GET['view']);

    if ($view == $user) $name = "Your";
    else                $name = "$view's";

    echo "<h3>$name Profile</h3>";
    showProfile($view);

    echo "<a class='button' href='messages.php?view=$view'>" .
        "View $name messages</a><br><br>";
    die("</div></body></html>");
}

if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);

    $result = queryMysql($db_server, "SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
        queryMysql($db_server, "INSERT INTO friends VALUES ('$add', '$user')");
}
elseif (isset($_GET['remove']))
{
    $remove = santizeString($db_server, $_GET['remove']);
    queryMysql($db_server, "DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = queryMysql($db_server, "SELECT user FROM members ORDER BY user");

$num    = $result->num_rows;

echo "<h3>Other Members</h3><ul>";

for ($j = 0 ; $j < $num ; ++$j)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;

    echo "<li><a href='members.php?view=" .
        $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryMysql($db_server,"SELECT * FROM friends WHERE
      user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql($db_server, "SELECT * FROM friends WHERE
      user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
    elseif ($t1)         echo " &larr; you are following";
    elseif ($t2)       { echo " &rarr; is following you";
        $follow = "recip"; }

    if (!$t1) echo " [<a href='members.php?add=".$row['user']."'>$follow</a>]";
    else      echo " [<a href='members.php?remove=".$row['user']."'>drop</a>]";
}
?>

</ul></div>
</body>
</html>
