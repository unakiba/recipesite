<?php
session_start();
require_once("./user-registration/database.php");

// エラー情報を表示する
// https://www.php.net/manual/ja/errorfunc.configuration.php#ini.error-reporting
ini_set('display_errors', "On");

// 出力する PHP エラーの種類を設定する
// https://www.php.net/manual/ja/function.error-reporting.php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// エラーを格納する変数
$errors = [];

/**
 * 実行結果を保持する。
 * 未完了: false
 * 完了: true
 */
$result = false;


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

/**
 * 画像かどうかをチェックする
 */
function is_image_file($file_path) {
    // 定数については以下のURLを参照してください。
    // https://www.php.net/manual/ja/function.exif-imagetype.php
    $allow_image_type = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];
  
    if (empty($file_path)) {
      return false;
    }
  
    //画像ファイルかのチェック
    $result = exif_imagetype($file_path); 
    if (in_array($result, $allow_image_type)) {
      return true;
    } else {
      return false;
    }
  }
  
  $uploaded = false;
  if (!empty($_FILES['uploaded_file'])) { 
    $upload_dir = './images/recipes/';
    $uploaded_file = $upload_dir . basename($_FILES['uploaded_file']['name']);

    //画像ファイルかのチェック
    if (is_image_file($_FILES['uploaded_file']['tmp_name'])) {
      move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploaded_file);
      $message = '画像をアップロードしました';

    } else {
      $message = '画像ファイルではありません';
    }
  
    $uploaded = true;
  }

  $images = glob('./images/recipes/*');

// POSTデータは$data変数にいれる
$data = [];
$data['recipe_name'] = !empty($_POST['recipe_name']) ? $_POST['recipe_name'] : '';
$data['number_of_materials'] = !empty($_POST['number_of_materials']) ? $_POST['number_of_materials'] : '';
$data['material_name'] = !empty($_POST['material_name']) ? $_POST['material_name'] : '';
$data['material_amount'] = !empty($_POST['material_amount']) ? $_POST['material_amount'] : '';

// POSTリクエストの場合はバリデーションを実行する
if (!empty($_POST)) {
    if (empty($_POST['recipe_name'])) {
      $errors['recipe_name'] = 'レシピ名を入力してください。';
    }
    if (empty($_POST['number_of_materials'])) {
      $errors['number_of_materials'] = '人数を入力してください。';
    }

  
    if (empty($errors)) {
        $insert_sql = "INSERT INTO recipes (recipe_name, number_of_materials, user_id) VALUES (?, ?, ?)";
        $stmt = $dbh->prepare($insert_sql);
        $stmt->bindParam(1, $data['recipe_name'], PDO::PARAM_STR);
        $stmt->bindParam(2, $data['number_of_materials'], PDO::PARAM_INT);
        $stmt->bindParam(3, $_SESSION['user']['id'], PDO::PARAM_INT);
        $stmt->execute();
        $recipe_id = $dbh->lastInsertId();
        $result = true;
    }
  }

// POSTデータがあればレシピをデータベースに登録する
if (!empty($_POST)) {

    

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
    <style>

    </style>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./user-registration/style.css">
</head>
  <?php include("./menu.php"); ?>
  <body>
      <h1>レシピ投稿</h1>
      <form action="./new-recipe.php" enctype="multipart/form-data" method="post">
          <div>
                <?php if ($uploaded): ?>
                    <p><?php echo $message; ?></p>
                <?php endif ?>
                    

                    <input type="hidden" name="name" value="value" />
                    アップロード: <input name="uploaded_file" type="file" />


                <div>
                    <?php foreach($images as $image): ?>
                        <img class="img" src="<?php echo $image; ?> " alt="" srcset="" width="200">
                    <?php endforeach ?>
                </div>
              レシピ名
                <input type="text" name="recipe_name" class="<?php echo !empty($errors['recipe_name'])? 'error': 'ok'?>" 
                value="<?php echo $data['recipe_name'] ?>">
                <p class="error" style="color:red"><?php echo $errors['recipe_name']?></p>
            </div>
          <div>
              人数
              <input type="text" name="number_of_materials" class="<?php echo !empty($errors['number_of_materials'])? 'error': 'ok'?>" 
            value="<?php echo $data['number_of_materials'] ?>">
            <p class="error" style="color:red"><?php echo $errors['number_of_materials']?></p>
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