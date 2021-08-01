<?php
session_start();

/**
 * データベースの接続
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'recipe');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '3306');

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

// データベースの接続
try {
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// POSTデータは$data変数にいれる
$data = [];
$data['recipe_name'] = !empty($_POST['recipe_name']) ? $_POST['recipe_name'] : '';
$data['number_of_materials'] = !empty($_POST['number_of_materials']) ? $_POST['number_of_materials'] : '';
$data['material_name'] = !empty($_POST['material_name']) ? $_POST['material_name'] : '';
$data['material_amount'] = !empty($_POST['material_amount']) ? $_POST['material_amount'] : '';

// POSTデータがあればレシピをデータベースに登録する
if (!empty($_POST)) {
    $insert_sql = "INSERT INTO recipes (recipe_name, number_of_materials, user_id) VALUES (?, ?, ?)";
    $stmt = $dbh->prepare($insert_sql);
    $stmt->bindParam(1, $data['recipe_name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $data['number_of_materials'], PDO::PARAM_INT);
    $stmt->bindParam(3, $_SESSION['user']['id'], PDO::PARAM_INT);
    $stmt->execute();
    $recipe_id = $dbh->lastInsertId();

    // 材料を登録する
    foreach ($data['material_name'] as $index => $row) {
        if (!empty($data['material_name'][$index]) && !empty($data['material_amount'][$index])) {
            $material_insert_sql = "INSERT INTO materials (material_name, material_amount, recipe_id) VALUES (?, ?, ?)";
            $stmt = $dbh->prepare($material_insert_sql);
            $stmt->bindParam(1, $data['material_name'][$index], PDO::PARAM_STR);
            $stmt->bindParam(2, $data['material_amount'][$index], PDO::PARAM_STR);
            $stmt->bindParam(3, $recipe_id, PDO::PARAM_INT);
            $stmt->execute();
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
    <title>レシピ投稿</title>
</head>

<body>
    <h1>レシピ投稿</h1>
    <form action="./new-recipe.php" method="post">
        <div>
            レシピ名
            <input type="text" name="recipe_name">
        </div>
        <div>
            人数
            <input type="text" name="number_of_materials">
        </div>

        <h2>材料</h2>
        <div class="template">
            材料名
            <input type="text" name="material_name[]">
            分量
            <input type="text" name="material_amount[]">
        </div>
        <button id="add-input">フォームを追加</button>
        <div id="input-box"></div>

        <button type="submit">レシピ登録</button>
    </form>

    <script>
        document.querySelector('#add-input').addEventListener('click', function(event) {
            // フォーム送信の動きを無効にする
            event.preventDefault();
            // template要素を取得
            const template = document.querySelector('.template');
            // template要素の内容を複製
            const clone = template.cloneNode(true);
            // #input-boxの中に追加
            document.querySelector('#input-box').appendChild(clone);
        })
    </script>
</body>

</html>