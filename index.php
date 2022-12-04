<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include 'config.php';

// Pagination code
$limit = 10;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;

// Registration
if(isset($_POST['register'])){
  if(($_POST['Name'] !== '') && ($_POST['Email'] !== '') && ($_POST['Phone'] !== '') && ($_POST['Branch'] !== '') && ($_POST['Rollno'] !== '') && ($_POST['Password'] !== '')){
    
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $branch = $_POST['Branch'];
    $rollno = $_POST['Rollno'];
    $password = $_POST['Password'];
    $random = $_POST['random'];

    // Checking student already registered or not
    $sql4 = "SELECT stu_email, stu_rollno FROM student WHERE stu_email = ?";
    $result4 = $conn->prepare($sql4);
    $result4->execute([$email]);
    if($result4->rowCount() > 0){
      unset($random);
      $msg3 = '<div class="alert alert-warning">User Already Registered</div>';
    } else{

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
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
           // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
           // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Email Verification';
            $mail->Body    = 'Code for verification is : <b>'.$random.'</b>';
            $mail->AltBody = 'Code for verification is : <b>'.$random.'</b>';
        
            $mail->send();

            $message2 =  '<script>
            document.addEventListener("DOMContentLoaded", () => {
            var rand_btn_toggle = document.getElementById("login2");
              //setTimeout(() => {
                rand_btn_toggle.click();
             // }, 1000); 
            });
            </script>';

        } catch (Exception $e) {
            $msg3 = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    }
  } else{
    $msg3 = '<div class="alert alert-danger">Fill all fields</div>';
  }
}


// Registration
if(isset($_POST['Submit'])){
  
  $randomCode = $_POST['randomCode'];

  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $branch = $_POST['branch'];
  $rollno = $_POST['rollno'];
  $password = $_POST['password'];
  $random = $_POST['random'];

  if($random == $randomCode){

    $sql3 = "INSERT INTO student (stu_name, stu_email, stu_phone, stu_branch, stu_rollno, stu_password, stu_img) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $result3 = $conn->prepare($sql3);
      if($result3->execute(array($name, $email, $phone, $branch, $rollno, $password, "image"))){

        $sql5 = "UPDATE branch SET total_stu = total_stu + ? WHERE branch_id = ?";
        $result5 = $conn->prepare($sql5);
        $increment = 1;
        $result5->bindParam(1, $increment, PDO::PARAM_INT);
        $result5->bindParam(2, $branch, PDO::PARAM_INT); 
        if($result5->execute()){
          unset($random);
          $msg3 = '<div class="alert alert-success">Registered Successfully</div>';
        }else{
          unset($random);
            $msg3 = '<div class="alert alert-success">Unable to regiser, there some technical error</div>';       
        }
      }  
  } else {
    $message3 = '<div class="alert alert-danger">Wrong code, enter right code</div>';
    $message2 =  '<script>
            var rand_btn_toggle = document.getElementById("login2");
              //setTimeout(() => {
                rand_btn_toggle.click();
             // }, 1000); 
             
            </script>';
  }
}

// Login
if(isset($_POST['login'])){
  //session
  if(isset($_SESSION['s_email']) && isset($_SESSION['s_name'])){
    include('config.php');
    header("Location: {$hostname}/student/dashboard.php");
  }
  if(($_POST['Emaillogin'] !== '') && ($_POST['Passwordlogin'] !== '')){

    $Email = $_POST['Emaillogin'];
    $Password = $_POST['Passwordlogin'];

    include 'config.php';
    $sql2 = "SELECT * FROM student WHERE stu_email = ? AND stu_password = ?";
    $result2 = $conn->prepare($sql2);
    $result2->execute([$Email, $Password]);
    if($result2->rowCount() > 0){
      $row2 = $result2->fetch(PDO::FETCH_ASSOC);
     // session 
      $_SESSION['s_id'] = $row2['stu_id'];
      $_SESSION['s_email'] = $row2['stu_email'];
      $_SESSION['s_name'] = $row2['stu_name'];
      $_SESSION['s_rollno'] = $row2['stu_rollno'];
      $_SESSION['s_branch'] = $row2['stu_branch'];
      $_SESSION['s_img'] = $row2['stu_img'];
      $_SESSION['s_phone'] = $row2['stu_phone'];
      $msg2 = '<div class="alert alert-dangerw3-panel w3-pale-red w3-border">valid Credential</div>';
      echo '<script>location.href = "'.$hostname.'/student/dashboard.php?q=w";</script>';
      //header("Location: {$hostname}/student/dashboard.php?q=w");
    }else{
      $msg2 = '<div class="alert alert-dangerw3-panel w3-pale-red w3-border">Invalid Credential</div>';
    }
  } else{
    $msg2 = '<div class="w3-panel w3-pale-red w3-border">Fill All Fields</div>';
  }
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="keywords" content="Project approval system, approval system, project approval system for colleges, SSIET, Sri Sukhmani Institute of Engineering & Technology" />
<meta name="description" content="Project Approval System for Sri Sukhmani college, Dera Bassi, Dist: Mohali, Punjab. Approve your project, This is a place where students can approve their minor and major projects" />
<meta name="google-site-verification" content="Vo-CsUAMQUlOfhAsJjzH1WuNpog6nsGpoT1OrCJqZRg" />
<link rel="canonical" href="<?php echo $hostname; ?>" />
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/w3css.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="icon" type="image/x-icon" href="favicon.ico" />
<title>Approve Your Project</title>
</head>
<body>

<!-- Header -->
<header class="w3-container w3-theme w3-margin-top w3-padding" id="myHeader">
  <div class="w3-center">
  <h4>Coding is today's language of creativity</h4>
    <h1 class="w3-xxlarge w3-animate-bottom sm">Approve Your Project</h1>
    <h3 class="w3-large w3-animate-bottom" id="reg"><?php if(isset($msg3)){ echo $msg3; } ?></h3>
    <h3 class="w3-large w3-animate-bottom" id="log"><?php if(isset($msg2)){ echo $msg2; } ?></h3>
    
    <div class="w3-padding-16">      
      <a href="#registration" class="w3-btn w3-xlarge w3-red w3-hover-light-grey shadow-btn" style="font-weight:900;">Register</a>
      <a href="" class="w3-btn w3-xlarge w3-blue w3-hover-light-grey shadow-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="font-weight:900;" id="login1"> Login</a>
      <small id="sm"></small>
    </div>
    <?php if(isset($random)){ ?>
    <div class="w3-padding">
      <button class="w3-btn w3-blue w3-hover-light-grey shadow-btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop1" style="font-weight:900;" id="login2"> Verify Email</button>
    </div>
    <?php } ?>
  </div>
</header>


<!-- Modal box start -->
<!-- Modal -->
<div class="container">
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable w3-animate-zoom">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Log In</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="row">
    <div class="col-sm-12">
      <form action="" method="post">
      <?php 
        // session
        if(isset($_SESSION['s_email']) && isset($_SESSION['s_name']) && isset($_SESSION['s_id']) ){
          include('config.php');

          $Em = $_SESSION['s_email'];
          $Na = $_SESSION['s_name'];

          $sql1 = "SELECT stu_email, stu_password FROM student WHERE stu_email = ? AND stu_name = ?";
          $result1 = $conn->prepare($sql1);
          $result1->execute([$Em, $Na]);
          if($result1->rowCount() > 0){
            $row1 = $result1->fetch(PDO::FETCH_ASSOC);

            $message = '<div class="alert alert-success">'.$Na.' you are already logged in, press Login button to redirect Dashboard.</div>';
          }
        }
      ?>
      <?php if(isset($message)){ echo $message; } ?>
      <div class="w3-section">
        <label for="emaillogin">E-mail</label>
        <input type="text" class="w3-input w3-border" id="emaillogin" required name="Emaillogin" value="<?php if(isset($row1['stu_email'])){ echo $row1['stu_email']; } ?>" placeholder="E-mail">
      </div>
      <div class="w3-section">
        <label for="passwordlogin">Password</label>
        <input type="password" class="w3-input w3-border" id="passwordlogin" value="<?php if(isset($row1['stu_password'])){ echo $row1['stu_password']; } ?>" required name="Passwordlogin" placeholder="Password">
      </div><br>
      <input type="submit" value="Log In" name="login" class="w3-btn w3-block w3-red modal-btn">
     </form><br><a href="forgot-password.php" style="float:right;font-size:16px;text-decoration:none;">Forgot password ?</a>
  </div>
</div><br>
      </div>
      
    </div>
  </div>
</div>
</div>
<!-- Modal box end -->




<!-- Modal box start for confirmation-->
<!-- Modal -->
<div class="container">
<div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable w3-animate-zoom">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Log In</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
      <div class="row">
    <div class="col-sm-12">
      <form action="" method="post">

      <div class="w3-section">
        <?php if(isset($message3)){ echo $message3; } ?>
        <label for="rand_num">Code sent on your E-mail</label>
        <input type="number" class="w3-input w3-border" id="rand_num" required name="randomCode" value="" placeholder="6-digit code" />
        <input type="hidden" name="name" value="<?php echo $name; ?>">
        <input type="hidden" name="email" value="<?php echo $email;  ?>">
        <input type="hidden" name="phone" value="<?php echo $phone;  ?>">
        <input type="hidden" name="branch" value="<?php echo $branch;  ?>">
        <input type="hidden" name="rollno" value="<?php echo $rollno;   ?>">
        <input type="hidden" name="password" value="<?php echo $password;  ?>">
        <input type="hidden" name="random" value="<?php echo $random;  ?>">
        
      </div><br>
        <input type="submit" value="Confirm" name="Submit" class="w3-btn w3-block w3-red modal-btn" id="confirmBTN" disabled="disabled" />
      </form>
    </div>
</div><br>
      </div>
      
    </div>
  </div>
</div>
</div>

<script>
  var rand_code = document.getElementById('rand_num');
  rand_code.addEventListener('keyup', () => {
    rand_value = rand_code.value;
    var confirmBtn = document.getElementById('confirmBTN');
    if(rand_value.length >= 6){
      confirmBtn.removeAttribute('disabled');
    }
  });
</script>
<!-- Modal box end for confirmation -->


<!-- bootstrap card start -->
<div class="w3-container">
  <div class="row justify-content-center">
<?php
include 'config.php';  
  $sql6 = "SELECT * FROM post LIMIT ?, ?";
  $result6 = $conn->prepare($sql6);
  $result6->execute(array($offset, $limit));
  if($result6->rowCount() > 0){
    while($row6 = $result6->fetch(PDO::FETCH_ASSOC)){
?>

    <div class="col-sm-10 my-2">
      <div class="card">
        <h3 class="card-header"> <a href="single.php?post=<?php echo $row6['post_slug']; ?>" style="text-decoration:none;"><?php echo $row6['post_title']; ?></a></h3>
        <div class="card-body">
          <p class="card-text" style="font-size:18px"><?php echo substr($row6['post_desc'], 0, 200).'...'; ?></p>
          <a href="single.php?post=<?php echo $row6['post_slug']; ?>" class="w3-btn w3-orange" style="font-size:15px">READ</a>
        </div>
      </div>
    </div>
<?php }} ?>

<div class="col-sm-3 my-3 pagination">
  <?php
    $sql7 = "SELECT post_id FROM post";

    $result7 = $conn->prepare($sql7);
    $result7->execute();
    
    $row7 = $result7->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result7->rowCount()){

      $total_records = $result7->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-btn w3-green mx-1"><a href="index.php?page='.($page-1).'"><--</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-green';
        }else{
          $active = '';
        }

        echo '<li class="w3-btn w3-green mx-1 '.$active.'"><a href="index.php?page='.$i.'" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-btn w3-green mx-1"><a href="index.php?page='.($page + 1).'">--></a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
  </div>
</div>

<!-- bootsrap card end -->

<!-- Registration Section Start -->
  <div class="w3-container" id="registration">
    <div class="row justify-content-center"><div class="col-md-8">
  <div class="w3-light-grey w3-padding-large w3-padding-32 w3-margin-top  shadow" id="contact">
    <h3 class="w3-center">Registeration</h3>
    <form action="" method="post">
      <div class="w3-section">
        <label for="name">Name</label>
        <input type="text" class="w3-input w3-border" id="name" required name="Name" placeholder="Full Name">
      </div>
      <div class="w3-section">
        <label for="email">Email</label>
        <input type="email" class="w3-input w3-border" id="email" required name="Email" placeholder="E-mail Address">
        <small>We will never share your Email with anyone.</small>
      </div>
      <div class="w3-section">
        <label for="phone">Phone Number</label>
        <input type="number" class="w3-input w3-border" id="phone" required name="Phone" placeholder="Phone Number">
      </div>
      <div class="w3-section">
        <label for="branch">Branch/Semester</label>
        <select name="Branch" id="branch" class="w3-input w3-border select-height" required>
        <option value="">Select</option>
        <?php 
          include 'config.php';
          $sql = "SELECT branch_name, branch_id FROM branch";
          $result = $conn->prepare($sql);
          $result->execute();
          if($result->rowCount() > 0){
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
              echo '<option value="'.$row['branch_id'].'">'.$row['branch_name'].' sem</option>';
            }         
          }
        ?>
        </select>
      </div>
      <div class="w3-section">
        <label for="rollno">Roll No</label>
        <input type="number" class="w3-input w3-border" id="rollno" required name="Rollno" placeholder="Roll Number">
      </div>
      <div class="w3-section">
        <label for="password">Password</label>
        <input type="password" class="w3-input w3-border" id="password" required name="Password" placeholder="Password">
        <input type="hidden" name="random" value="<?php echo mt_rand(100000,999999);  ?>">
      </div><br>
      <?php if(isset($msg3)){ echo $msg3; } ?><br>
      <button type="submit" class="w3-btn w3-block w3-red" name="register">Register</button>
      <em style="font-size:10px;">Note - By clicking Register button, you agree to our Terms, Data policy and Cookies policy</em><br>
    </form>
    </div>
    </div>
  </div>
</div>  
  <br><br><br>

<!-- Footer Start -->
<footer>
  <div class="w3-container w3-dark-grey w3-large">
  <h5 style="text-align:center;"> <a href="adminlogin.php" style="text-decoration:none;">Copyright</a> &copy; 2022</h5> 
 </div>
</footer>
<!-- Footer End -->

<!-- Bootstrap JS File -->
<script src="js/bootstrapbundle.js"></script>
<!-- FontAwesome JS File -->
<script src="js/all.min.js"></script>\
<?php if(isset($message2)){ echo $message2; } ?>
<script>

if(document.getElementById('reg')){
        setTimeout((e) => {
          const reg = document.getElementById('reg');
          reg.remove();
        }, 4000);
      }
      
      if(document.getElementById('log')){
        setTimeout((e) => {
          const logi = document.getElementById('log');
          logi.remove();
        }, 4000);
      }
document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
});

</script>
</body>
</html>