<header>
  <div class="left">
    <a href="./index.php"><h1>レシピサイト</h1></a>
  </div>
  <div class="center">
    <input type="text" name="search" placeholder="検索">
    <button>詳細検索</button>
  </div>


  <ul>
    <?php if(empty($_SESSION['login'])): ?> 
      <li><button onclick="location.href='./user-registration/index.php'">新規登録</button></li>
      <li><button onclick="location.href='./user-registration/login.php'">ログイン</button></li>
    <?php else: ?> 
      <li><button onclick="location.href='./user-registration/logout.php'">ログアウト</li>
      <li><button onclick="location.href='/recipe/new-recipe.php'">レシピ投稿</button></li>
    <?php endif ?> 
  </ul>
</header> 
