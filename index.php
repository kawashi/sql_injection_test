<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title>SQL Injection - Test Server</title>
    <?php
    /* サインイン */
    if( isset($_POST['signin']) ){
        // DB接続・選択 TODO:要リファクタ
        $link = mysql_connect('mysql.hostinger.jp', 'u554433119_fjb', 'password');
        if(!$link) exit(mysql_error()."コネクトできてないやつ");
        if(!mysql_select_db('u554433119_fjb', $link)) exit(mysql_error()."選択できてないやつ"); 
        
        // SQL発行
        $query  = "SELECT * FROM users WHERE name = '".$_POST['name']."'";
        echo '<script>alert("'.$query.'");</script>';
        $result = mysql_query($query);
        if(!$result) exit(mysql_error()."クエリ失敗奴");
        
        // 結果照合
        while( $row = mysql_fetch_array($result) ){
            if( $_POST["pass"] == $row["pass"] ){
                setcookie('login', 'true', time() + 3600);
                header("Location: show.php");
                exit;
            }
        }
    }
    /* サインアップ */
    if( isset($_POST['signup']) ){
        // DB接続・選択 TODO:要リファクタ
        $link = mysql_connect('mysql.hostinger.jp', 'u554433119_fjb', 'password');
        if(!$link) exit(mysql_error()."コネクトできてないやつ");
        if(!mysql_select_db('u554433119_fjb', $link)) exit(mysql_error()."選択できてないやつ"); 
        
        // SQL発行
        $query  = "INSERT INTO users VALUES(null, '". $_POST["name"] ."', '". $_POST["pass"] ."')";
        echo '<script>alert("'.$query.'");</script>';
        $result = mysql_query($query);
        if(!$result) exit(mysql_error()."クエリ失敗奴");
        else         header("Location: index.php?flag=success");
    }
    
    ?>
</head>
<body>
    <header>
        <div class="text-center"><h1>Hello, Kawashi!</h1></div>
    </header>
    
    <div class="container text-center">
        <div class="row main">
           <?php if($_GET["flag"] == "success"){
                echo '<div class="bg-success text-success success-message"><p>Success, Please Login!</p></div>';
            } ?>
            <div class="signup col-md-8">
                <h1>Create Account.</h1>
                <form action="index.php" method="post">
                    <div>
                        <input type="text" name="name" class="form-control" placeholder="username">
                    </div>
                    <div>
                        <input type="password" name="pass" class="form-control" placeholder="password">
                    </div>
                    <div>
                        <input type="submit" class="btn btn-primary btn-block" name="signup" value="signup">
                    </div>
                </form>
            </div> 
            <div class="signin col-md-4">
                <h1>Login Form.</h1>
                <form action="index.php" method="post" >
                   <div>
                        <input type="text" name="name" class="form-control" placeholder="username"/>
                    </div>
                    <div>
                        <input type="password" name="pass" class="form-control" placeholder="password"/>
                    </div>
                    <div>
                        <input type="submit" class="btn btn-default btn-block" value="signin" name="signin">
                    </div>
                </form>
            </div> 
            <hr>
        </div>
        <div class="message">
            <h1 class="ok">やってもゆるされること(自己責任)</h1>
            <ul class="list-unstyled">
                <li>SQLインジェクション</li>
                <li>パスワードクラック</li>
                <li>クッキー改ざん</li>
            </ul>
            <h1 class="ng">やっちゃだめなこと</h1>
            <ul class="list-unstyled">
                <li>ディレクトリトラバーサル</li>
                <li>Dos攻撃系統</li>
                <li>その他不正アクセスと思われるもの</li>
            </ul>
        </div>
    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>