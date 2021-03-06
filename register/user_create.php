<?php
include("../functions.php");
$pdo = connect_to_db();

$u_name = $_POST['u_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$s_id = $_POST['s_id'];
$p_name = $_POST['p_name'];
$birthday = $_POST['birthday'];
$sex = $_POST['sex'];
$type = $_POST['type'];
$filename_to_save = $_POST['p_image'];

$sql = 'INSERT INTO users_table (u_id, u_name, email, password, address, phone, created_at, updated_at, deleted_at) VALUES (NULL, :u_name, :email, :password, :address, :phone, sysdate(), sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_name', $u_name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':address', $address, PDO::PARAM_STR);
$stmt->bindValue(':phone', $phone, PDO::PARAM_INT);
$status = $stmt->execute();


if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  $sql = 'SELECT * FROM users_table WHERE email=:email';
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $status = $stmt->execute();

  if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
  } else {
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $u_id = $user_data['u_id'];
  }
}

$sql = 'INSERT INTO pet_table(p_id, s_id, u_id, p_name, birthday, sex, type, alive, p_image, created_at, change_info_at, change_alive_at, deleted_at) VALUES (NULL, :s_id, :u_id, :p_name, :birthday, :sex, :type, 1, :p_image, sysdate(), sysdate(), sysdate(), sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':s_id', $s_id, PDO::PARAM_INT);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$stmt->bindValue(':p_name', $p_name, PDO::PARAM_STR);
$stmt->bindValue(':birthday', $birthday, PDO::PARAM_STR);
$stmt->bindValue(':sex', $sex, PDO::PARAM_STR);
$stmt->bindValue(':type', $type, PDO::PARAM_STR);
$stmt->bindValue(':p_image', $filename_to_save, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  header("Location:.php");
  exit();
}
