<?php
session_start();
require_once("./user-registration/database.php");

$errors = [];

/**
 * データベースの接続
 */
define('DB_HOST', '127.0.0.1');
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
// レシピを取得
$stmt = $dbh->prepare('SELECT * from recipes');
$stmt->execute();
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);



// 材料を取得
foreach($recipes as  $index => $recipe) {
  $stmt = $dbh->prepare('SELECT * from materials WHERE recipe_id = ?');
  $stmt->bindParam(1, $recipe['recipe_id'], PDO::PARAM_INT);
  $stmt->execute();
  $recipes[$index]['materials'] = $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レシピサイト</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./user-registration/style.css">
</head>
<body>
    <?php include("./menu.php"); ?>
    <main>
        <ul id="menu">
            <li>HOME</li>
            <li>ランキング</li>
            <li>コラム</li>
        </ul>
        <div class="container">
            <div id="main">
                <?php foreach($recipes as $recipe): ?>
                <div class="box recipe">
                    <h2>新着レシピ</h2>
                    <div class="container">
                        <div class="left">
                            <img src="./images/recipes/<?php echo $recipe['recipe_image'];  ?>" alt="" srcset="">
                            
                        </div>
                        <div class="right">
                            <p><?php echo $recipe['recipe_name'];  ?></p>
                            <p>材料</p>
                            <ul>
                                <?php foreach($recipe['materials'] as $material): ?>
                                <li><?php echo $material['material_name']; ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
                <div class="box ranking">
                    <h2>ランキング</h2>
                    <div class="container">
                        <div class="left">
                            <img src="./images/emanuel-ekstrom-qxvhDhjFy4o-unsplash 1.jpg" alt="" srcset="">
                        </div>
                        <div class="right">
                            <p>料理名</p>
                            <p>材料</p>
                            <ul>
                                <li>マカロニ</li>
                                <li>パセリ</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box column">
                    <h2>新着コラム</h2>
                    <div class="container">
                        <div class="left">
                            <img src="./images/alexander-mils-6HPLJLe2mX8-unsplash 1.jpg" alt="" srcset="">
                        </div>
                        <div class="right">
                            <p>タイトル</p>
                            <p>本文ああああああああああああああ</p>
                        </div>
                    </div>
                    <div class="container">
                        <div class="left">
                            <img src="./images/alexander-mils-6HPLJLe2mX8-unsplash 1.jpg" alt="" srcset="">
                        </div>
                        <div class="right">
                            <p>タイトル</p>
                            <p>本文ああああああああああああああ</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="side">
                <div class="box">
                    <h2>お知らせ</h2>
                    <p>日付</p>
                    <p>あああああああああああああああああ</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>