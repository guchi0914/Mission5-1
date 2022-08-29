<!DOCTYPE html>
 <html lang="ja">
     <head>
         <meta charset="UTF-8">
         <title>tbtest1</title>
     </head>
     <body>
 <?php
$dsn = ʼデータベース名ʼ;
    $user = ʼユーザー名ʼ ;
    $password = ʼパスワードʼ;
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

 

  
     $sql = "CREATE TABLE IF NOT EXISTS tbtest1"
     ."("
     . "id INT AUTO_INCREMENT PRIMARY KEY,"
     ."name char(32),"
     ."comment TEXT,"
     ."date char(32),"
     ."pass char(32)"
     .");";
     $stmt=$pdo->query($sql);
     

             //編集-新規作成
         //editを受け取ったとき、編集フォームに代入する
         $sql="SELECT*FROM tbtest1";
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            foreach($results as $row){
     if(!empty($_POST["edit"])&& ($_POST["edit"]==$row["id"]) && ($_POST["editpass"])==$row["pass"]){
             $id=$_POST["edit"];
             $editpass=$_POST["editpass"];
             $sql="SELECT*FROM tbtest1";
             $stmt=$pdo->query($sql);
             $results=$stmt->fetchAll();
             
             foreach($results as $row){
                 if($row["id"]==$id){
                     $e_name=$row["name"];
                     $e_comment=$row["comment"];
                     $pass=$row["pass"];
                     $e_number=$row["id"];
                 }
             }
     }
            }

     ?>
     <form action="" method="post">
             <input id="pass"type="text"name="password"placeholder="パスワード"value=
             "<?php
             if(!empty($pass)){
                 echo $pass;
             }
             ?>">
                 
             <input type="hidden"name="e_number"value=
             "<?php
             if(!empty($e_number)){
             echo $e_number;
             }
             ?>">
             
             <input type="text"name="name"placeholder="名前を入力"value=
             "<?php
             if(!empty($e_name)){
                 echo $e_name;
             }
             ?>">
             <input type="text"name="comment"placeholder="コメントを入力"value=
             "<?php
             if(!empty($e_comment)){
                 echo $e_comment;
             }
             ?>">
            <input type="submit"name="submit"value="送信">
            <!--編集フォーム-->
            <br>
            <input id="pass"type="text"name="editpass"placeholder="編集パスワード">
            <input type="number"name="edit"placeholder="編集対象番号">
            <input type="submit"value="編集">
            <br>
                        <!--削除フォーム-->
            <input id="pass"type="text"name="delpass"placeholder="削除パスワード">
            <input type="number"name="delete"placeholder="削除対象番号">
             <input type="submit"value="削除">

            
     </form>
    <?php
    //新規投稿
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["e_number"])){
        $name = $_POST["name"];
        $comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
        $password=$_POST["password"];
         $date= date("Y年m月d日 H:i:s");
         $sql = $pdo -> prepare("INSERT INTO tbtest1 (name, comment,pass,date) VALUES (:name, :comment, :pass, :date)");
         $sql -> bindParam(':name', $name, PDO::PARAM_STR);
         $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
         $sql -> bindParam(':pass',$password, PDO::PARAM_STR);
         $sql -> bindParam(':date',$date, PDO::PARAM_STR);


     $sql -> execute();
     }
     
     
      //削除機能
     $sql="SELECT*FROM tbtest1";
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            foreach($results as $row){
        
     if(!empty($_POST["delete"]) && !empty($_POST["delpass"]) && ($_POST["delete"]==$row["id"]) && $_POST["delpass"]==$row["pass"]){
         $id = $_POST["delete"];
         $delpass=$_POST["delpass"];
         $sql = 'delete from tbtest1 where id=:id';
         $stmt = $pdo->prepare($sql);
         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
         $stmt->execute();
         }
     }
         

         //編集機能　送信された場合
            if(!empty($_POST["e_number"])){
             //editDataに番号～日付まで指定
              $id = $_POST["e_number"]; //変更する投稿番号
              $name = $_POST["name"];
              $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
              $password=$_POST["password"];
              $sql = 'UPDATE tbtest1 SET name=:name,comment=:comment,pass=:pass WHERE id=:id';
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':name', $name, PDO::PARAM_STR);
              $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
              $stmt->bindParam(':pass',$password,PDO::PARAM_STR);
              $stmt->bindParam(':id', $id, PDO::PARAM_INT);
              $stmt->execute();
                 
             
            }

            
            //表示機能
            $sql="SELECT*FROM tbtest1";
            $stmt=$pdo->query($sql);
            $results=$stmt->fetchAll();
            foreach($results as $row){
            echo $row["id"]."　";
            echo $row["name"]."　";
            echo $row["comment"]."　";
            echo $row["pass"]."※パスワード仮表示　";
            echo $row["date"];
            echo "<hr>";
            }
             ?>
             

     </body>
 </html>