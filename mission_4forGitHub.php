<!DOCTYPE html>
<html>
<head>
<title>Mission_4</title>

<meta charset =http-equiv="Content-Type" content="text/html; utf-8">
</head>
<body>
<form action = "mission_4.php" method="post">

<?php
/*
$dsn = 'mysql:dbname=tt_612_99sv_coco_com;host=localhost';
$user = 'tt-612.99sv-coco';
$password = 'Rb7dpMeN';
*/
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));



date_default_timezone_set('Asia/Tokyo');
$name = $_POST['name'];
$comment = $_POST['comment'];
$id = NULL;
$time = date("Y/m/d H:i:s");
$pass = $_POST["pass"];
$delete =intval($_POST['delete']);
$inputpassE = $_POST["inputpass"];
$inputpassD = $_POST["inputpassD"];
$edit = intval($_POST['edit']);
$display = intval($_POST['display']);
//print_r($_POST['display']);

//3-2テーブルの作成
/*$sql=  "CREATE  TABLE tbl3"
."  ("
.  "id  INT auto_increment,"
.  "name  char(32),"
.  "comment  TEXT,"
.  "time  char(50),"
.  "pass  char(32),"
.  "PRIMARY KEY(id)"
.");";
$stmt  =  $pdo->query($sql);
*/

//3-3が作成できたか確認
/*
$sql  ='SHOW  TABLES';
$result  =  $pdo  ->  query($sql);
foreach  ($result  as  $row){
  echo  $row[0];
  echo  '<br>';
}
echo  "<hr>";

//3-4テーブルの中身を確認
$sql  ='SHOW  CREATE  TABLE  tbl3';
$result  =  $pdo  ->  query($sql);
foreach  ($result  as  $row){
  print_r($row);
}
echo  "<hr>";

*/

//3-5データの入力【新規投稿】
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["display"])){

//パスワード入力されたら
	if(!empty($_POST["pass"])){

$sql =  $pdo  ->  prepare("INSERT INTO tbl3 (id,name,comment,time,pass) VALUES(:id,:name,:comment,:time,:pass)");
$sql -> bindValue(':id',  $id,  PDO::PARAM_INT);
$sql -> bindParam(':name',  $name,  PDO::PARAM_STR);
$sql -> bindParam(':comment',  $comment,  PDO::PARAM_STR);
$sql -> bindParam(':time',  $time,  PDO::PARAM_STR);
$sql -> bindParam(':pass',  $pass,  PDO::PARAM_STR);

$sql -> execute();
	}
//パスワード未入力
	else{
	echo "！パスワードが入力されていません！";
	}

}


//【編集対象選択】

if(isset($_POST["edit"])){

$sql  =  'SELECT  *  FROM  tbl3';
$results  =  $pdo  ->  query($sql);
 foreach($results  as  $row){
	if($edit == $row['id']){
	 if($inputpassE == $row['pass']){
	 $editName = $row['name'];
	 $editCom = $row['comment'];
	 echo "編集中…";
	 }
	//パスワードが異なる場合
	 else{
	 echo "！パスワードが違います！";	
	 }
	}
	else{
	}
 }
}


//【編集実行機能】3-7

if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["display"])){

//新しいパスワードの入力を求める
	if(!empty($_POST["pass"])){

//編集
$id = $display;
$nm = $name;
$kome = $comment;
$ps = $pass;
$tm = $time;
$sql = "update tbl3 set name = '$nm', comment='$kome', pass = '$ps', time = '$tm' where id = $id";
$result = $pdo ->query($sql);

	echo "☆投稿番号".$id."番を編集しました！☆";
	}
	else{
	echo "新しいパスワードを入力してください";
	 }
}
//【削除フォームに入力が入ったとき】3-8

if(!empty($_POST["delete"])){


$sql  =  'SELECT  *  FROM  tbl3';
$results  =  $pdo  ->  query($sql);
 foreach($results  as  $row){
	if($delete == $row['id']){		//入力された削除対象番号を一致させる
	 if($inputpassD == $row['pass']){	//パスワードの確認
	 $sql  =  "delete  from  tbl3  where  id=$delete";
	 $result  =  $pdo->query($sql);
	 echo "★投稿番号".$delete."番を削除しました★";
	 }
	 else{
	echo "パスワードが違います";
	 }
	}
	
 }
}

?>

<!-- 「名前」「コメント」の入力フォーム -->
<p>名前:
<input type = "text" name="name" value="<?php echo $editName;?>"></br>
 コメント:
<input type = "text" name="comment" value="<?php echo $editCom;?>" ></br>
<!-- パスワード入力フォーム -->
Pass:
<input type = "text" name="pass"></p>
<!-- 編集番号の表示 -->
<p><input type = "hidden" name="display" value="<?php echo $edit;?>"></p>

<p><input type="submit" value="送信"></p>


<!-- 削除用フォーム -->
<p>【削除する番号を入力】
<input type = "text" name="delete"</br>
<input type = "text" name="inputpassD" placeholder = "パスワード">
<input type="submit" value="削除"></p>

<!-- ここまで削除用フォーム -->

<!-- 「編集」用入力フォーム -->
<p>【編集する番号を入力】
<input type = "text" name="edit">
<input type = "text" name="inputpass" placeholder = "パスワード">
<input type="submit" value="編集"></p>


<!-- ここまで「編集」用入力フォーム -->




<?php
//3-6入力データの表示
$sql  =  'SELECT  *  FROM  tbl3 ORDER BY id';
$results  =  $pdo  ->  query($sql);
foreach  ($results  as  $row){

	echo  $row['id'].',';
	echo  $row['name'].',';
	echo  $row['comment'].',';
	echo  $row['time'].'<br>';
/*パスワードの確認
	echo  $row['time'].',';
	echo  $row['pass'].'<br>';*/
}




?>
</body>
</html>
