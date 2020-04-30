<?php
// セッションを開始
 session_start();

//  データーベースの読み込み
require_once("database.php");


 function findUserByEmail($dbh, $email){
    $sql = "SELECT * FROM users WHERE email = ? ";
        $stmt = $dbh->prepare($sql);
        $data[] = $email;
        $stmt->execute($data);
        return $stmt->fetch(PDO::FETCH_ASSOC);
 }
// Emailが合っているのか参照
if (!empty($_POST)) {
    // emailが合っている場合
    $user = findUserByEmail($dbh, $_POST["email"]) ;
        //passwordも合っている場合
        if(password_verify($_POST["password"], $user["password"])) {
            $_SESSION["login"] = true;
        // どのページでもログイン状態にする
            $_SESSION["user"] = $user;
        // ログインするとマイページへ飛ぶ
        header('Location: original.php');
        exit;
        }else {
            echo 'Invalid password.';
        }
}
// ログインしているのか表示
if ($_SESSION["login"]) {
    echo "ログインしています。";
  } else {
    echo "ログインしていません。";
  }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <h1>ログイン</h1>
    <!-- 自分に戻ってくる -->
        <form action="./login.php" method="POST">
            <div>
                メールアドレス
                <input type="Email" name="email" id="email">
            </div>
            <div>
                パスワード
                <input type="password" name="password" id="password">
            </div>
            <div>
                <button type="submit">ログイン</button>
            </div>

    </form>
    
</body>
</html>