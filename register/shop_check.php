<?php
include("../functions.php");
$pdo = connect_to_db();

$u_name = $_POST['u_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['都道府県'] . $_POST['市区町村'] . $_POST['番地'] . $_POST['建物名・部屋番号'];
$phone = $_POST['phone1'] . $_POST['phone2'] . $_POST['phone3'];
$p_name = $_POST['p_name'];
$birthday = $_POST['birthday_y'] . $_POST['birthday_m'] . $_POST['birthday_d'];
$sex = $_POST['sex'];
$s_id = $_POST['s_id'];
if (($_POST['d_type'] == NULL && $_POST['c_type'] == NULL) || ($_POST['d_type'] != NULL && $_POST['c_type'] != NULL)) {
  echo "<p>ペットの種類は、どちらか一方に入力してください．</p>";
} elseif ($_POST['d_type'] == NULL) {
  $type = $_POST['c_type'];
} else {
  $type = $_POST['d_type'];
}

if (
  $u_name == NULL ||
  $email == NULL ||
  $password == NULL || strlen($password) < 6 ||
  $address == NULL ||
  $phone == NULL ||
  $birthday == NULL ||
  $sex == NULL
) {
  echo "<p>入力内容に誤りがあります．</p>";
  exit();
}

$sql = 'SELECT * FROM store_table WHERE s_id=:s_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':s_id', $s_id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $store_data = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  $uploaded_file_name = $_FILES['upfile']['name']; //ファイル名を取得
  $temp_path = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所
  $directory_path = '../upload/'; //アップロード先ォルダ(自分で決める)
  $extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION);
  $unique_name = date('YmdHis') . md5(session_id()) . "." . $extension;
  $filename_to_save = $directory_path . $unique_name;
  if (is_uploaded_file($temp_path)) {

    if (move_uploaded_file($temp_path, $filename_to_save)) {
      chmod($filename_to_save, 0644);
    } else {
      exit('ERROR:アップロードできませんでした');
    }
  } else {
    exit('ERROR:画像がありません');
  }
} else {
  exit('error:画像が送信されていません');
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>編集内容確認</title>
</head>

<body>

  <main></main>

  <table>
    <tbody>
      <h2>お客様情報</h2>
      <tr>
        <td>お名前</td>
        <td>:</td>
        <td><?= $u_name ?></td>
      </tr>
      <tr>
        <td>住所</td>
        <td>:</td>
        <td><?= $address ?></td>
      </tr>
      <tr>
        <td>電話番号</td>
        <td>:</td>
        <td><?= $phone ?></td>
      </tr>
      <tr>
        <td>メールアドレス</td>
        <td>:</td>
        <td><?= $email ?></td>
      </tr>
    </tbody>
  </table>
  <table>
    <tbody>
      <h2>ペット情報</h2>
      <tr>
        <td>購入店舗</td>
        <td>:</td>
        <td><?= $store_data['store_name'] ?></td>
      </tr>
      <tr>
        <td>お名前</td>
        <td>:</td>
        <td><?= $p_name ?></td>
      </tr>
      <tr>
        <td>犬種／猫種</td>
        <td>:</td>
        <td><?= $type ?></td>
      </tr>
      <tr>
        <td>性別</td>
        <td>:</td>
        <td><?= $sex ?></td>
      </tr>
      <tr>
        <td>生年月日</td>
        <td>:</td>
        <td><?= $birthday ?></td>
      </tr>
      <tr>
        <td>写真</td>
        <td>:</td>
        <td> <img src="<?= $filename_to_save ?>" alt="" height="160px"></td>
      </tr>
    </tbody>
  </table>

  <div>
    <p><?= $store_data['store_name'] ?>様が<br>承認ボタンを押して下さい</p>
  </div>


  <form action="user_create.php" method="POST">

    <input type="hidden" name="u_name" value="<?= $u_name ?>">
    <input type="hidden" name="email" value="<?= $email ?>">
    <input type="hidden" name="password" value="<?= $password ?>">
    <input type="hidden" name="address" value="<?= $address ?>">
    <input type="hidden" name="phone" value="<?= $phone ?>">

    <input type="hidden" name="s_id" value="<?= $s_id ?>">
    <input type="hidden" name="p_name" value="<?= $p_name ?>">
    <input type="hidden" name="birthday" value="<?= $birthday ?>">
    <input type="hidden" name="sex" value="<?= $sex ?>">
    <input type="hidden" name="type" value="<?= $type ?>">
    <input type="hidden" name="p_image" value="<?= $filename_to_save ?>">

    <button type="submit">承認します</button>
  </form>
  <!-- POSTでデータ持って帰って前に戻るボタンを作る -->

  <footer></footer>

</body>

</html>