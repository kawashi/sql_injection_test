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
        $query  = "SELECT * FROM users WHERE name = '".$_POST['name']."' AND pass = '". $_POST['pass'] ."'";
        echo '<script>alert("'.$query.'");</script>';
        $result = mysql_query($query);
        if(!$result) exit(mysql_error()."クエリ失敗奴");
        
        // 結果照合
        // while( $row = mysql_fetch_array($result) ){
        if(mysql_num_rows($result) > 0){
            setcookie('login', 'true', time() + 3600);
            setcookie('name', $_POST['name'], time() + 3600);
            header("Location: show.php");
            exit;
        }else{
            header("Location: index.php?flag=danger&message=miss");
        }
    }
    /* サインアップ */
    if( isset($_POST['signup']) ){
        
        // DB接続・選択 TODO:要リファクタ
        $link = mysql_connect('mysql.hostinger.jp', 'u554433119_fjb', 'password');
        if(!$link) exit(mysql_error()."コネクトできてないやつ");
        if(!mysql_select_db('u554433119_fjb', $link)) exit(mysql_error()."選択できてないやつ"); 
        
        // バリデーションチェック
        // 空白チェック
        if( empty($_POST["name"]) || empty($_POST["pass"]) ){
            header("Location: index.php?flag=danger&message=require");
            exit;
        }
        // 新規作成は1時間に3つまで
        if( isset($_COOKIE["create_count"]) ){
            if( $_COOKIE["create_count"] > 3 ){
                header("Location: index.php?flag=danger&message=max");
                exit;
            }
        }
        // 重複チェック
        $result = mysql_query("SELECT * FROM users WHERE name ='". $_POST["name"] ."'");
        if(mysql_num_rows($result) > 0){
            header("Location: index.php?flag=danger&message=overlap");
            exit;
        }
        
        // SQL発行
        $query  = "INSERT INTO users VALUES(null, '". $_POST["name"] ."', '". $_POST["pass"] ."')";
        // echo '<script>alert("'.$query.'");</script>';
        $result = mysql_query($query);
        if(!$result){
            exit(mysql_error()."クエリ失敗奴");
        }else{
            // 一時間に3つまで1
            if(isset($_COOKIE["create_count"])){
                setcookie("create_count", $_COOKIE["create_count"]+1, time()+3600);
            }else{
                setcookie("create_count", 1, time()+3600);
            }
            header("Location: index.php?flag=success&name=".empty($_POST["name"]));
            exit;
        }
    }
    
    ?>
</head>
<body>
    <header>
        <div class="text-center"><h1>Hello, Kawashi!</h1></div>
    </header>
    
    <div class="container text-center">
        <div class="row main">
            <?php 
            if(isset($_GET["flag"])){
                if($_GET["flag"] == "success"){
                    echo '<div class="bg-success text-success success-message"><p>Success, Please login!</p></div>';
                }
                if($_GET["flag"] == "danger"){
                    if($_GET["message"] == "require"){
                        echo '<div class="bg-danger text-danger danger-message"><p>Not space for name or pass!</p></div>';
                    }
                    if($_GET["message"] == "max"){
                        echo '<div class="bg-danger text-danger danger-message"><p>No!　1ジカン　デ　3ツマデ!</p></div>';
                    }
                    if($_GET["message"] == "overlap"){
                        echo '<div class="bg-danger text-danger danger-message"><p>No! Please another name.</p></div>';
                    }
                    if($_GET["message"] == "miss"){
                        echo '<div class="bg-danger text-danger danger-message"><p>This user or pass not found.</p></div>';
                    }
                }
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