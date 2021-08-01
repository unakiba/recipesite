<?php
require_once 'database.php';
$errors = [];
$registered = false;

$recipe_id = $_GET['recipe_id'];
// レシピを取得
$stmt = $dbh->prepare('SELECT * from recipes WHERE  recipe_id = ?');
$stmt->bindParam(1, $recipe_id,PDO::PARAM_INT);
$stmt->execute();
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare('SELECT * from tags');
$stmt->execute();
$tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {
    foreach($_POST['tag_ids'] as $tag_id) {
        // POSTデータは$data変数にいれる
        $data = [];
        $data['tag_id'] = $tag_id;
        $data['recipe_id'] = !empty($_POST['recipe_id']) ? $_POST['recipe_id'] : '';
 
        $insert_sql = "INSERT INTO recipe_tags(tag_id, recipe_id) VALUES (?,?)";
        $stmt = $dbh->prepare($insert_sql);
        $stmt->bindParam(1, $data['tag_id'], PDO::PARAM_INT);
        $stmt->bindParam(2, $data['recipe_id'], PDO::PARAM_INT);
        try {
            $stmt->execute();
            $registered = true;
        } catch (PDOException $e) {
            $errors[] = '登録時にエラーが発生しました。';
        }
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
    <h1>タグ付け</h1>
    <?php foreach($errors as $error): ?>
        <p><?php echo $error ?></p>
    <?php endforeach ?>

    <?php if($registered): ?>
        <p>タグを登録しました。</p>
    <?php endif ?>
 
    <div>
        <h2><?php echo $recipe['recipe_name']?></h2>
    </div>
    <form action="./new-recipe-tags.php?recipe_id=<?php echo $recipe_id?>" method="post">
        <input type="hidden" name="recipe_id" value="<?php echo $recipe_id?>">
        <?php foreach($tags as $tag): ?>
            <input type="checkbox" id="tag-<?php echo $tag['tag_id']?>" name="tag_ids[]" value="<?php echo $tag['tag_id']?>">
            <label for="tag-<?php echo $tag['tag_id']?>"><?php echo $tag['tag_name']?></label>
        <?php endforeach ?>
        <button type="submit">登録</button>
    </form>

    <div>
        <a href="./tag.php">タグ登録</a>
    </div>
</body>
</html>