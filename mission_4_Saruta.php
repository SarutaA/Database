<?php
$dsn = 'データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);
 //接続完了

//テーブル作成
$sql="CREATE TABLE mission4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,"
."name char(32),"
."message TEXT,"
."date DATETIME,"
."password TEXT"
.");";
$stmt=$pdo->query($sql);
?>

<html>
<?php
 $name=$_POST['name'];
 $message=$_POST['message'];
 $date=date("Y-m-d H:i:s");
 $delete=$_POST['delete'];
 $editnum=$_POST['editnum'];
 $password1=$_POST['password1'];
 $password2=$_POST['password2'];
 $password3=$_POST['password3'];

//データ入力
 if( !(empty($name)) && !(empty($message)) && !(empty($password1)) ){
 	$sql=$pdo->prepare("INSERT INTO mission4 (name,message,date,password) VALUES (:name, :message, :date, :password)");
 	$sql->bindParam(':name', $name, PDO::PARAM_STR);
 	$sql->bindParam(':message', $message, PDO::PARAM_STR);
	$sql->bindParam(':date', $date, PDO::PARAM_STR);
	$sql->bindParam(':password', $password1, PDO::PARAM_STR);
 	$sql->execute();
 }

//削除機能
 if( !(empty($delete)) && !(empty($password2)) ){
	$sql="DELETE FROM mission4 where id='$delete' and password='$password2'";
	$result=$pdo->query($sql);
 }

//編集機能
 if( !(empty($editnum)) && !(empty($password3)) ){
 	$sql="SELECT * FROM mission4 where id='$editnum'";
	$results=$pdo->query($sql);
	foreach($results as $row){
		if($password3==$row['password']){
			$edit_num=$row['id'];
			$edit_name=$row['name'];
			$edit_message=$row['message'];
		}
 	}
 }
 $edit=$_POST['edit'];
 if( !(empty($edit)) ){
 	$sql=$pdo->prepare("UPDATE mission4 SET name=:name, message=:message, date=:date where id=:edit");
 	$sql->bindParam(':name', $name, PDO::PARAM_STR);
 	$sql->bindParam(':message', $message, PDO::PARAM_STR);
	$sql->bindParam(':date', $date, PDO::PARAM_STR);
	$sql->bindParam(':edit', $edit, PDO::PARAM_STR);
 	$sql->execute();
 }
?>

<form action="mission_4.php" method="post">
 <p><input type="text" name="name" placeholder="名前" value="<?php echo $edit_name;?>"><p/>
 <p><input type="text" name="message" placeholder="コメント" value="<?php echo $edit_message;?>"><p/>
 <p><input type="text" name="password1" placeholder="パスワード">
 <input type="submit" value="送信"><p/>
 <p><input type="hidden" name="edit" value="<?php echo $edit_num;?>"><p/>
 <br>
 <p><input type="text" name="delete" value="削除対象番号"></p>
 <p><input type="text" name="password2" placeholder="パスワード">
 <input type="submit" value="削除"><p/>
 <br>
 <p><input type="text" name="editnum" placeholder="編集対象番号"></p>
 <p><input type="text" name="password3" placeholder="パスワード">
 <input type="submit" value="編集"><p/>
</form>

<?php
 $sql='SELECT * FROM mission4 order by id';
 $results=$pdo->query($sql);
 foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['message'].',';
	echo $row['date'].'<br>';
 }
?>