<?php
//ミッション3-1データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);
//ミッション3-2データベース内へテーブルを作成
$sql="CREATE TABLE mission411"
."("
."number INT AUTO_INCREMENT NOT NUL PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."pass varchar(20)"
.");";
$stmt=$pdo->query($sql);


//編集番号に数字が入れられたとき編集モードにする
if(isset($_POST['hensyu'])){
	$id=$_POST['hensyu'];
	$sql="SELECT*FROM mission411 WHERE number='$id'";
	$res=$pdo->query($sql);
	foreach($res as $row){
		$password=$row['pass'];
		$hensyu1=$row['name'];
		$hensyu2=$row['comment'];
	}
	if($_POST['password2']==$password){
		$hensyuNo=$_POST['hensyu'];
		$hensyuname=$hensyu1;
		$hensyucomment=$hensyu2;
		echo '編集モード';
	}
}
?>

<!DOCTYPE html><!__入力フォーム作成__>
<html lang = "ja">
<head>
<link rel=“stylesheet” href=“style.css”>
<meta charset = "UFT-8"><!__文字コード設定__>
<title>苦みを抑えた、うまみ。　生茶掲示板</title>
</head>
<div><h1>生茶掲示板</h1></div>
<body text="blue" bgcolor="white">
<form action="mission_4-1.php" method="post"><!__post送信__>
<input type = "hidden" name="No"value=<?php echo $hensyuNo ?>><br/><!__編集フォーム番号__>
<input type = "text" name="name" value=<?php echo $hensyuname ?>><br/><!__テキストデータ入力__>
<input type = "text" name="comment"value=<?php echo $hensyucomment ?>><br/><!__テキストデータ入力__>
<input type = "text" name="password"placeholder="パスワード"><br/><!__パスワード入力フォーム__>
<input type = "submit" value ="送信"><!__送信ボタン__>
</form>
<form action="mission_4-1.php" method="post">
<input type = "text" name="delete"placeholder="削除対象番号"><br/><!__削除フォーム作成__>
<input type = "text" name="password1"placeholder="パスワード"><br/><!__パスワード入力フォーム__>
<input type = "submit" value ="削除"><!__送信ボタン__>
</form>
</form>
<form action="mission_4-1.php" method="post">
<input type = "text" name="hensyu"placeholder="編集対象番号"><br/><!__編集対象番号__>
<input type = "text" name="password2"placeholder="パスワード"><br/><!__パスワード入力フォーム__>
<input type = "submit" value ="編集"><!__送信ボタン__>
</form>
</body>
</html>

<?php




$name=$_POST["name"];//postでデータの受け取り
$comment = $_POST["comment"]; //postでデータの受け取り
$pass=$_POST['password'];
$date=date("Y/m/d H:i:s");





if(isset($_POST['delete'])){//削除
	$id=$_POST['delete'];
	$sql="SELECT*FROM mission411 WHERE number='$id'";
	$res=$pdo->query($sql);
	foreach($res as $row){
		$password=$row['pass'];
	}
	if($_POST['password1']==$password){//削除されましたと上書き
		$sql="update mission411 set name=null,comment='削除されました'where number=$id";
		$result=$pdo->query($sql);
	}
}


//編集モード
if(ctype_digit($_POST['No'])){
	$id=$_POST['No'];
	$nm=$_POST['name'];
	$kome=$_POST['comment'].'編集済み';//編集済みと記入してコメント
	$sql="update mission411 set name='$nm',comment='$kome'where number=$id";//上書き
	$result=$pdo->query($sql);

	$sql='SELECT*FROM mission411';
	$filename=$pdo->query($sql);
	foreach($filename as $row){
		echo $row['number'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	}
	
}else{



if(isset($_POST['name'])&&$_POST['comment']!=""){//コメントモード

	$sql=$pdo->prepare("INSERT INTO mission411 (number,name,comment,date,pass) VALUES (:number,:name,:comment,:date,:pass)");

	$sql->bindParam(':name',$dbname,PDO::PARAM_STR);
	$sql->bindParam(':comment',$dbcomment,PDO::PARAM_STR);
	$sql->bindParam(':number',$dbnumber,PDO::PARAM_STR);
	$sql->bindParam(':date',$dbdate,PDO::PARAM_STR);
	$sql->bindParam(':pass',$dbpass,PDO::PARAM_STR);

	$dbname=$name;
	$dbcomment=$comment;
	$dbnumber=$number;
	$dbdate=$date;
	$dbpass=$pass;

	$sql->execute();

	$sql='SELECT*FROM mission411';
	$filename=$pdo->query($sql);
	foreach($filename as $row){
		echo $row['number'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	}


}else{
	$sql='SELECT*FROM mission411';
	$filename=$pdo->query($sql);
	foreach($filename as $row){
		echo $row['number'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
	}
}
if($_POST["comment"]=="clear"){
	echo "clear";
	$sql="delete from mission411";
	$result=$pdo->query($sql);
	}

}

?>
