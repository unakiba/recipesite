<?php
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

$recipe_id = $_GET['recipe_id'];


// レシピを取得
$stmt = $dbh->prepare('SELECT * from recipes WHERE  recipe_id = ?');
$stmt->bindParam(1, $recipe_id,PDO::PARAM_INT);
$stmt->execute();
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);


// 材料を取得
  $stmt = $dbh->prepare('SELECT * from materials WHERE recipe_id = ?');
  $stmt->bindParam(1, $recipe['recipe_id'], PDO::PARAM_INT);
  $stmt->execute();
  $recipe['materials'] = $materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

  

// 手順を取得

  $stmt = $dbh->prepare('SELECT * from processes WHERE recipe_id = ?');
  $stmt->bindParam(1, $recipe['recipe_id'], PDO::PARAM_INT);
  $stmt->execute();
  $recipe['prosesses'] = $processes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>レシピ詳細</title>
</head>

<body>
  <header>
    <div class="left">
      <h1>レシピサイト</h1>
    </div>
    <div class="center">
      <input type="text" name="serch" placeholder="検索">
      <button>詳細検索</button>
    </div>
    <div class="right">
      <button onclick="location.href='./user-registration/index.php'">新規登録</button>
      <button onclick="location.href='./user-registration/login.php'">ログイン</button>
      <button>レシピ投稿</button>
    </div>
  </header>
  <main>
    <ul id="menu">
      <li>HOME</li>
      <li>ランキング</li>
      <li>コラム</li>
    </ul>

    <div class="title">
      <h2><?php echo $recipe['recipe_name']; ?></h2>
    </div>
    <div id="top">
      <div class="images">
        <img src="./images/recipes/<?php echo $recipe['recipe_image'];  ?>" alt="">
      </div>
      <div class="various">
        <div class="users">
          <p>投稿者 : unknown</p>
        </div>
 
        <div class="materials">
          <h3>材料(<?php echo $recipe['number_of_materials']; ?>人前)</h3>
          <?php  foreach($recipe['materials'] as $material): ?>
          <div class="material-box">
            
                  <div class="box-left"><?php echo $material['material_name'] ; ?></div> 
                  <div class="box-right"><?php echo $material['material_amount']; ?></div> 
                
          </div>
          <?php endforeach ?>
        
        </div>


      </div>
    </div>
    <div id="process">
      <h3>作り方</h3>
      <div class="single">
      <?php  foreach($processes as $process): ?>
        <div class="order">
          
              <h3><?php echo $process['process_number']; ?></h3>
              <p><?php echo $process['process_content']; ?></p>
             
        </div>
        <?php if (!empty($process['trick'])): ?>
        <div class="comment">
          <h3>コツ・コメント</h3>
          <p><?php echo $process['trick'] ?></p>
        </div>
        <?php endif ?>
        <?php endforeach ?>
        

      </div>
    </div>
    <div class="user_rev">
      <h2>ユーザーレビュー</h2>
      <div class="rev_con">
        <p>コメント本文ああああああああああああああああああああああああああああ<br>
          ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
        </p>
        <div class="user_date">
          <div class="rev_user">
            unknown さん
          </div>
          <div class="rev_date">
            2021/06/30
          </div>
        </div>

      </div>
      <div class="rev_con">
        <p>コメント本文ああああああああああああああああああああああああああああ<br>
          ああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああああ
        </p>
        <div class="user_date">
          <div class="rev_user">
            unknown さん
          </div>
          <div class="rev_date">
            2021/06/30
          </div>
        </div>

      </div>

    </div>
    




  </main>



</body>

</html>