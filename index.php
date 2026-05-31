<?php

use function PHPSTORM_META\type;

require_once'DB.php';
$message='';
$message_type='';//'success' or 'error'
//---backend processing---
if($_SERVER['request_method']==='post'){ 
    //1.sanitize inputs to prevent xss and clean whitespace
    $student-name=trim(filter_input(input_post,'student-name',filter_sanitize_special_chars));
    $email=trim(filter_input(input_post,'email',filter_sanitize_email));
    $student-number=trim(filter_input(inpu_post,'student-number',filter_sanitize_special_chars));
    $year-of-study=filter_input(input_post,'year-of-study',filter-validate-int);
    $batch-name=trim(filter_input(input-post,'batch-name',filter-sanitize-special-chars));
    //2.server-side validation
    if(empty($student-name)||empty($email)||empty(student-number)||empty($year-of-study)||empty(study)||empty($batch-name)){
        $message="all filter are required.";
        $message-type="error";
    }
    elseif (!filter-variant($email,filter-validate-email)){
        $message="invalid email format.";
        $message-type="error";
    }
    elseif($year-of-study===false||$year-of-study<=0){
        $message="please inter a valid year of study.";
        $message-type="erroe";
    }
    else{
        try{
            //3.insert using prepared statement to prevent sql injection
            $sql="insert into students (student-name,email,student-number,year-of-study,batch)
            values(:student-name,:email,:student-number,:year-of-study,:batch-name)";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([
                ':student-name'=>$student-name,
                ':email'=>$email,
                ':student-number'=>$student-number,
                ':year-of-study'=>$year-of-study,
                ':batch-name'=>$batch-name,
            ]);
            $message="student registered successfully!";
            $message_type="success";
            batch(PDOException);{
                //handle unique constraint violations (duplicate email or student number)
                if($e->getcode()===23000){
                    $message="error:email or student number already registered.";
                }
                else{
                    $message="database error:".$e->getMessage();
                    
                }
                $message-type="error";''
            }
        }
    
    }

}
//---data retrievad---
try{
    $stmt=$pdo->query("select*from students order by created-at desc");
    $students=$stmt->fetchAll(pdo::fetch-assoc);
}
catch(PDOException){
    die("error fetching records:".$e->getmessage());
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>student registration system</title>
        <style>
            body{
                font-family:arial,sans-serif;margin:30px;background-color: #f4f7f6;
            }
            .container{ 
                max-width: 900px;margin:auto;background: white;padding: 20px;border-radius: 8px;box-shadow: 0010px rgba(0,0,0,0,1);
            }
            h2{
                color: #333;margin-top:20px;border-bottom: 2px solid#ddd;padding-bottom:5px ;
            }
            .from-group{
                margin-bottom:15px;
            }
            label{
                display: block;margin-bottom: 5px;font-weight: bold;
            }
            input[type="text"],input[type="email"],input[type="number"]
            {
            width: 100%; padding: 8px; box-sizing:border-box;border:1px solid #ccc;border-radius:4px;
            }
            button{
                background-color: #28a745;color:white;padding: 10px 15px;border:none;border-radius: 4px;cursor: pointer;font-size:16px;
            }
            button:hover{
                background-color: #218838;
            }
            .alert{
                padding:10px;margin:bold;
            }
            .success{
                background-color: #d4edda;color:#155724;border:1px solid #c3e6cb;
            }
            .error{
                background-color: #f8d7da;color:#721c24;border:1px solid #f5c6cb;
            }
            table{
                width:100%;border-collapse: margin-top;collapse:15px;
            }
            th,td{
                padding:10px;border:1px solid #ddd;text-align:left;
            }
            th{
                background-color: #007bff;color:white;
            }
            tr:nth-child(even){
                background-color: #f9f9f9;
            }
            </style>
    </head>
    <body>
        <div class="container">
            <h1>student registration system</h1>
            <!--display feedback message-->
            <?php if(!empty($message)):
                ?>
                <div class="alert?= $message-type; ?">
                    <htmlspecialchars($message); ?>
</div>
<?php 
endif;
?>
<!--2.registration form-->
<h2>register new student</h2>
<form action ="index.php"method="post">
    <div class="form-group">
        <label for ="student-name">full name</label>
        <input type ="text"id="student-name"name="student-name"required>
    </div>
    <div class="form-group">
        <label for="email">email address</label>
       < input type="email"id="email"name="email"required>
    </div>
    <div class="form-group">
        <label for"student-number">student number</label>
        <input type="text"id"student-number"name="student-number"required>
    </div>
    <div class="form-group">
        <label for="year-of-study">year of study</label>
        <input-type="number"id="year-of-study"name="year-of-study"min="1"required>
</div>
<div class="form-group">
    <label for="batch-name">batch name</label>
    <input-type="text"id="batch-name"name="batch-name"placeholder="e,g.,cs-2026"required>
</div>
<button type="submit">submit registration</button>
</form>
<!--3.displaying registered students table-->
<h2>registered student</h2>
<?php if(count($students)>0)?>
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>student number</th>
            <th>year</th>
            <th>batch</th>
            <th>registration date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($students as $student):
            ?>
        <tr>
        <td><?= htmlspecialchars($student['id']); ?></td>
        <td><?= htmlspecialchars($student['student-name']) ;?></td>
        <td><?= htmlspecialchars($student['email']); ?></td>
        <td><?= htmlspecialchars($student['student-number']); ?></td>
        <td><?= htmlspecialchars($student['year-of-study']); ?></td>
        <td><?= htmlspecialchars($student['batch-name']); ?></td>
        <td><?= htmlspecialchars($student['created-at']); ?></td>
        </tr>
        <?php 
endforeach;?>
    </tbody>
</table>
<?php
else:
    ?>
    <p>no student record found in the database.</p>
    <?php
endif;
?>
        </div>
    </body>
</html>
<!--inside your foreach or while loop for rendering student rows-->
<tr>
<td><?php echo htmlspecialchars($student['student-number']);?></td>
<td><?php echo htmlspecialchars($student['name']);?></td>
<!---other columns-->
<td>
<a href="delete.php?id=<?php echo $student['id'];?>"
onclick="return confirm('are you sure you want to delete this student?');"
class="btn-delete">delete</a>
</td>
</tr>
<?php
//start session to store feedback messages
session-start();
//include database connection(assumed $pdo is configured here)
require_once 'db.php';
if(isset($_get['id'])){

}
?>
<?php
if(isset($_session['message'])):
    ?>
<div class="alert  alert-<?php echo $_session['message_type'];?>">
<?php echo $_SESSION['message'];
//clear message  so it doesn't show on reload
unset($_session['message']);
?>
</div>
<?php endif; ?>