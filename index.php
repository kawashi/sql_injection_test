<!DOCTYPE html>
<html lang="en">

<?php
    if( isset($_POST['submit']) ){
        // DB接続・選択
        $link = mysql_connect('localhost', 'kawashi', 'yakisobameron');
        mysql_select_db('fjb', $link);
        $result = mysql_query("SELECT * FROM users WHERE users = '".$_POST['name']."'");
        while( $row = mysql_fetch_array($result) ){
            if( $_POST["pass"] == $row ){
                $_COOKIE["ok"] = 1;
                header("Location: http://google.com");
            }
        }
    }
?>


<head>
    <meta charset="UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="text-center"><h1>Hello, Kawashi!</h1></div>
    </header>
    
    <div class="container text-center main">
        <h1>Please Login.</h1>
        <div class="row">
            <form action="index.php" method="post" >
               <div>
                    <input type="text" name="name" class="form-control" placeholder="ユーザ名"/>
                </div>
                <div>
                    <input type="text" name="name" class="form-control" placeholder="パスワード"/>
                </div>
                <div>
                    <input type="submit" class="btn btn-primary btn-block" value="submit!" name="submit">
                </div>
            </form>
        </div>
        <hr>
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