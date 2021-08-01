<?php
require_once 'database.php';
$tag_id = $_GET['tag_id'];

$stmt = $dbh->prepare('SELECT * from tags WHERE tag_id = ?');
$stmt->bindParam(1, $tag_id,PDO::PARAM_INT);
$stmt->execute();
$tag = $stmt->fetch(PDO::FETCH_ASSOC);

// レシピを取得
$stmt = $dbh->prepare('SELECT recipes.* FROM `recipe_tags` INNER JOIN recipes ON recipes.recipe_id = recipe_tags.recipe_id WHERE tag_id = ?');
$stmt->bindParam(1, $tag_id,PDO::PARAM_INT);
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <h1>「<?php echo $tag['tag_name']?>」のレシピ一覧</h1>
    <ul>
        <?php foreach($recipes as $recipe): ?>
            <li><a href="./recipe.php?recipe_id=<?php echo $recipe['recipe_id']?>"><?php echo $recipe['recipe_name']?></a></li>
        <?php endforeach ?>
    </ul>
</body>
</html>