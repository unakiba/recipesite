<?php
require_once 'database.php';

// レシピを取得
$stmt = $dbh->prepare('SELECT * FROM `tags`');
$stmt->execute();
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>タグ一覧</h1>
    <ul>
        <?php foreach($tags as $tag): ?>
            <li><a href="./recipe-tags.php?tag_id=<?php echo $tag['tag_id']?>"><?php echo $tag['tag_name']?></a></li>
        <?php endforeach ?>
    </ul>
</body>
</html>