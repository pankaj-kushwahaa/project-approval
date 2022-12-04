<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include 'config.php';

if(isset($_REQUEST['login'])){
  if(($_POST['email'] !== '')){
    
    $email = $_POST['email'];
   
    try{
      $sql = "SELECT stu_email, stu_password, stu_name FROM student WHERE stu_email = ?";
      $result = $conn->prepare($sql);
      $result->execute(array($email));
      if($result->rowCount() > 0){
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $password = $row['stu_password'];
        $stu_name = $row['stu_name'];
       if($row['stu_email'] == $email){
     

        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function
        
       require('PHPMailer/Exception.php');
       require('PHPMailer/PHPMailer.php');
       require('PHPMailer/SMTP.php');
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;*/                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $emailUsername;                  //SMTP username
            $mail->Password   = $emailPassword;                          //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($emailUsername, $emailName);
            $mail->addAddress($email);     //Add a recipient
            /*$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/
        
            //Attachments
           /* $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');*/    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Forgot Password';
            $mail->Body    = 'Dear '.$stu_name.',<br><br>Your Password for '.$websiteName.' is given below<br><br>Your Password is : <b>'.$password.'</b><br><br><br>Thanks & regards';
            $mail->AltBody = "Your Password is {$password}";
        
            $mail->send();
            $msg = '<div class="alert alert-success">Message has been sent</div>';
        } catch (Exception $e) {
            $msg = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }




       } else {
         $msg = '<div class="alert alert-danger">Invalid Email Id, Write correct Email Id</div>';
       }
      } else{
        $msg = '<div class="alert alert-warning w3-yellow">Invalid Email Id, Write correct Email</div>';
      }  
    } catch(PDOException $e){
      echo $e->getMessage();
    }
  } else{
    $msg = '<div class="alert alert-danger">Fill all fields</div>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap Css -->
  <link rel="stylesheet" href="css/bootstrap.css">
  <!-- Font awesome css -->
  <link rel="stylesheet" href="css/fontawesome.css">
  <!-- w3 css -->
  <link rel="stylesheet" href="css/w3css.css">
  <!-- Custome Css -->
  <link rel="stylesheet" href="css/style.css">
  <title>Forgot Password</title>
</head>
<body>
  <p class="text-center mt-5 mx-2" style="font-size:30px;">Forgot Password</p>
<div class="container-fluid">
  <div class="row justify-content-center mt-5">
    <div class="col-sm-5">
      <form action="" method="post" class="w3-light-grey shadow p-4">
        <div class="form-group my-2"><i class="fas fa-user"></i>
            <label for="email" class="font-weight-bold pl-2">&nbsp;Email</label>
            <input type="email" name="email" id="email" class="w3-input w3-border" required>
          <div class="d-grid gap-2"><br>
            <button type="submit" class="w3-red mt-3 font-weight-bold btn-block w3-btn shadow-sm" name="login" id="log1">Submit</button>
          </div><br>
          <div id="div1"><?php if(isset($msg)){ echo $msg; } ?></div>    
        </div>
      </form>
      <div class="text-center"><a href="index.php" class="btn btn-info mt-5 shadow-btn font-weight-bold">Back to Home</a></div>
    </div>
  </div>
</div>
<!-- JavaScript files start -->
  <script src="js/all.min.js"></script>
  <script src="js/bootstrapbundle.js"></script>
<!-- JavaScript files end -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
});
</script>
</body>
</html>