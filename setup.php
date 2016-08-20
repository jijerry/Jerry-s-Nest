<!--/**创建数据库表-->
<!-- * Created by PhpStorm.-->
<!-- * User: jerry-->
<!-- * Date: 2016/8/20-->
<!-- * Time: 16:49-->
<!-- */-->

<html>
    <head><title> Setting up database</title></head>
    <body>

    <h3> Setting up ......</h3>

    <?php   //setup.php
    include_once "functions.php";

//    成员表
    createTable('members',
                'user VARCHAR(16),
                 pass VARCHAR(16),
                 INDEX(user(6))');

//    消息表
    createTable('messages',
                'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                 auth VARCHAR(16),
                 recip VARCHAR(16),
                 pm CHAR(1),
                 time INT UNSIGNED,
                 message VARCHAR(4096),
                 INDEX(auth(6)),
                 INDEX(recip(6))');

//    朋友表
    createTable('friends',
                 'user VARCHAR(16),
                 friend VARCHAR(16),
                 INDEX(user(6)),
                 INDEX(friend(6))');

//    用户信息表
    createTable('profile',
                 'user VARCHAR(16),
                  text VARCHAR(4096),
                  INDEX(user(6))');
?>
<br>...DONE

    </body>
</html>