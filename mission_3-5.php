<!DOUTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-05.php</title>
    </head>
    <body>
        <form action="" method="post">
          <?php 
            $editnumber=$_POST["editnumber"];
            $editpassword=$_POST["editpassword"];
            echo $editpassword;
            
            $filename="mission_3-05.txt";
       //もし編集番号が指定されていなければ名前とコメントのフォームに名前、コメントと表示
      //もし番号が指定されれば投稿番号の内容を名前とコメントフォームに反映
            if($editnumber==0){
                $name="名前";
                $comment="コメント";
            }else{
               $lines =file($filename,FILE_IGNORE_NEW_LINES);
               foreach($lines as $l){
                $expr = explode("<>",$l);
   if($editnumber==$expr[0]&&$editpassword==$expr[4]){
       $editcon=$expr[0];
       $name=$expr[1];
       $comment=$expr[2];
       echo "inn";
       break;
   }
     }
 }
echo "<input type='text' name='edited' value='$editcon'><br>";
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
if(file_exists($filename)){
    $lines=file($filename,FILE_IGNORE_NEW_LINES);
    $num=count($lines)+1;
    }
    
            $date = date("Y年m月d日 H時i分s秒");
            if($comment!=""&&$comment!="コメント"){
                echo $comment."を受け付けました";
                $s="";
                foreach(array($num,$name,$comment,$date,$password) as $i){
                $s=$s.$i;
                    $s=$s."<>";
            }
            $s=$s."\n";
         if($edited==0){
            $f=fopen($filename,"a");
            fwrite($f,$s);
            fclose($f);
         }
            }
            if(file_exists($filename)){
                $lines=file($filename,FILE_IGNORE_NEW_LINES);
                foreach($lines as $l){
                    echo $l;
                    echo"<br>";
                }
                   }
                   //削除フォーム
                       if($sakujo!=0){
                 $lines=file($filename,FILE_IGNORE_NEW_LINES);
                 //password分岐
               foreach($lines as $l){
                     $exp=explode("<>",$l);
                if($sakujo==$exp[0]&&$deletepassword==$exp[4]){
                 $f=fopen($filename,"w");
                 fclose($f);
                 $f=fopen($filename,"a");
                 foreach($lines as $l){
                     $exp=explode("<>",$l);
                     if($sakujo!=$exp[0]){
                         fwrite($f,$l.PHP_EOL);
                     }
                 }
                    fclose($f);
                    echo "削除しました";
                }
               }
                       }
                   //編集をファイルに書き込む
                   //フォーム欄の値が投稿番号と一致しなければ
                   //普通に書き込む
                   //一致すればファイルを空にして上書き
               if($edited!=0){
                            $lines=file($filename,FILE_IGNORE_NEW_LINES);
                 $f=fopen($filename,"w");
                 fclose($f);
                 $f=fopen($filename,"a");
                foreach($lines as $l){
                     $exp=explode("<>",$l);
                     if($edited==$exp[0]){
                         fwrite($f,$exp[0]."<>".$name."<>".$comment."<>".
                         $date."<>".$password.PHP_EOL);
                     }else{
                   fwrite($f,$l.PHP_EOL);
                     }
                }
                     fclose($f);
                     echo "編集しました";
               }
           
                   ?>
                   </body>