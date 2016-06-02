<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="show.css">
    <title>MainPage</title>
    <?php
        // ログインしてなかったら弾き出す
        if(empty($_COOKIE["login"]) || $_COOKIE["login"] != "true"){
            header("Location: index.php");
            exit;
        }
    
        // ログアウト処理
        if(isset($_POST["logout"])){
            setcookie('login', 'false', time()-1800);
            header("Location: index.php");
            exit;
        }
    ?>
</head>
<body>
    <div class="container">
        <header class="text-center"><h1>Hello, Kawashi!</h1></header>
        <div class="main text-center">
            <h1>ログイン成功</h1>
            <form action="show.php" method="post">
                <input type="submit" name="logout" value="Logout" class="btn btn-default">
            </form>
        </div>
        
        <!-- 簡易的な投稿ができるようにする -->
        <div class="messages">
           <div class="post-form"></div>
           <div class="message-list"></div>            
        </div>
    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>