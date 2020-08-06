<?php

$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$id = 1;
$name = "うちのコーギーは";
$comment = "エースという名前だ";
$sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
    echo $row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].'<br>';
echo "<hr>";
}
?>