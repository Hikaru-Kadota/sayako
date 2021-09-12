<?php
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>利用規約</title>
  <link rel="stylesheet" type="text/css" href="../style.css">

</head>

<style>
  h1 {
    margin: 0;
  }

  .desc {
    font-size: 12px;
  }

  .terms {
    width: 300px;
    height: 200px;
    margin-bottom: 10px;
    margin-left: auto;
    margin-right: auto;
    padding: 0.5em;
    overflow-y: scroll;
    box-sizing: border-box;
    border: 1px solid #ccc;
    font-size: 12px;
  }
</style>

<body>

  <main></main>
  <h1>利用規約</h1>
  <p class="desc">
    以下の内容を全てお読み頂き、同意頂ける場合のみ会員登録へお進み下さい。
  </p>
  <div class="terms">
    <strong>第１条</strong><br>
    テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br>

    <strong>第２条</strong><br>
    テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト<br>


    <strong>第３条</strong><br>
    テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
    <div id="end"></div>
  </div>

  <form action="user_input.php" method="POST">
    <p><label><input type="checkbox" name="agreed" value="OK" id="agree" disabled> 利用規約に同意します</label></p>
    <input type="hidden" name="s_id" value="<?= $_GET['s_id'] ?>">
    <button id="next" type="submit" disabled>ユーザー登録へ</button>
  </form>
  <script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver"></script>

  <script>
    end = document.getElementById('end');
    var agree = document.getElementById('agree');
    var next = document.getElementById('next');
    agree.addEventListener('click', function() {
      next.disabled = !next.disabled;
    });
    var observer = new IntersectionObserver(function(changes) {
      if (changes[0].intersectionRatio === 1) {
        observer.disconnect();
        agree.disabled = false;
      }
    });
    observer.observe(end);
  </script>

  <footer></footer>

</body>

</html>