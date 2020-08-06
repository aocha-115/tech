

<!DOUTYPE html>
<?php

$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
error_reporting(E_ALL & ~E_NOTICE);
$sql = "CREATE TABLE IF NOT EXISTS bbs"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "password char(32),"
. "date datetime "
.");";
$stmt = $pdo->query($sql);

?>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-01.php</title>
    </head>
    <body>
        <form action="" method="post">
          <?php 
            $editnumber=$_POST["editnumber"];
            $editpassword=$_POST["editpassword"];
            
            $filename="mission_5-01.txt";
       //もし編集番号が指定されていなければ名前とコメントのフォームに名前、コメントと表示
      //もし番号が指定されれば投稿番号の内容を名前とコメントフォームに反映
            if($editnumber==0){
                $name="名前";
                $comment="コメント";
            }else{
                //SQLでやるとするなら
              $sql = 'SELECT * FROM bbs WHERE id=:id ';  
              $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
              $stmt->bindParam(':id', $editnumber, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
              $stmt->execute();                             // ←SQLを実行する。
              $results = $stmt->fetchAll(); 
   if($editpassword==$results[0]["password"]){
       $editcon=$results[0]["id"];
       $name=$results[0]["name"];
       $comment=$results[0]["comment"];
   }
            }
echo "<input type='hidden' name='edited' value='$editcon'><br>";
echo "<input type='text' name='name' value='$name' placeholder='名前'><br>";
echo "<input type='text' name='comment' value='$comment' placeholder='コメント'><br>";
echo "<input type='text' name='sendpassword' placeholder='パスワード'><br>";
?>

 <input type="submit" name="submit">
<br><br>
  <input type="text" 
name="sakujo" value="削除番号"><br>
<input type="text" name="deletepassword" placeholder="パスワード"><br>
           <input type="submit" name="submit" value="削除">
        <br><br>
           <input type="text" name="editnumber" 
           value="<?php echo $taisyounum;?>" placeholder="編集対象番号"><br>
           <input type="text" name="editpassword" placeholder="パスワード"><br>
           <input type="submit" name="submit" value="編集">
           </form>

<?php
$password=$_POST["sendpassword"];
$deletepassword=$_POST["deletepassword"];
$taisyounum=$_POST["editnumber"];
$edited=$_POST["edited"];
$name=$_POST["name"];
$comment=$_POST["comment"];
$num=1;
$sakujo=$_POST["sakujo"];

            $date = date("Y-m-d H:i:s");
            if($comment!=""&&$comment!="コメント"){
                echo $comment."を受け付けました<br>";
           
         if($edited==0){
            //SQLの処理
            $sql = $pdo -> prepare("INSERT INTO bbs (name, comment, password, date) VALUES (:name, :comment, :password, :date)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':password', $password, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $sql -> execute();
         }
            }
         //SQLの確認
         $sql = 'SELECT * FROM bbs';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].'<>';
        echo $row['name'].'<>';
        echo $row['comment'].'<>';
        echo $row['password'].'<>';
        echo $row['date'].'<br>';
	}
	   
    
            //SQL処理削除
            $sql = 'SELECT * FROM bbs WHERE id=:id ';  
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $sakujo, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
            if($deletepassword==$results[0]["password"]){
            $sql = 'delete from bbs where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $sakujo, PDO::PARAM_INT);
            $stmt->execute();
            }
            //編集をファイルに書き込む
                   //フォーム欄の値が投稿番号と一致しなければ
                   //普通に書き込む
                   //一致すればファイルを空にして上書き
   
           //SQL編集
if($edited!=0){
           $sql = 'UPDATE bbs SET name=:name, comment=:comment, date=:date WHERE id=:id';
   echo $name;
   echo $comment;
   echo $password;
           $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $edited, PDO::PARAM_INT);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt-> bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->execute();
}
           ?>
                   </body>