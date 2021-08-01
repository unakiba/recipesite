<?php
require_once 'database.php';

$errors = [];
$registered = false;
if(!empty($_POST)) {
    // POSTデータは$data変数にいれる
    $data = [];
    $data['tag_name'] = !empty($_POST['tag_name']) ? $_POST['tag_name'] : '';
    $insert_sql = "INSERT INTO tags(tag_name) VALUES (?)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->bindParam(1, $data['tag_name'], PDO::PARAM_STR);
    try {
        $stmt->execute();
        $registered = true;
    } catch (PDOException $e) {
        $errors[] = '登録時にエラーが発生しました。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>タグ登録</h1>
    <?php foreach($errors as $error): ?>
        <p><?php echo $error ?></p>
    <?php endforeach ?>

    <?php if($registered): ?>
        <p>タグを登録しました。</p>
    <?php endif ?>
    <form action="./tag.php" method="post">
        <input type="text" name="tag_name" placeholder="タグ名">
        <button type="submit">登録</button>
    </form>
</body>
</html>