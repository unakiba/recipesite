<header>
  <div class="left">
    <a href="../index.php"><h1>レシピサイト</h1></a>
  </div>
  <div class="center">
    <input type="text" name="search" placeholder="検索">
    <button>詳細検索</button>
  </div>


  <ul>
    <?php if(empty($_SESSION['login'])): ?> 
      <li><a href="/recipe/user-registration/index.php">ユーザー登録</a></li>
      <li><a href="/recipe/user-registration/login.php">ログイン</a></li>
      <li><a href="">レシピ投稿</a></li>
    <?php else: ?> 
      <li><a href="/recipe/user-registration/logout.php">ログアウト</a></li>
    <?php endif ?> 
  </ul>
</header> 
