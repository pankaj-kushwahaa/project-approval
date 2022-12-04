<?php 
include 'loginredirect.php';
define('TITLE', 'Update Profile');
define('PAGE', 'updateprofile');
include("header.php");
include '../config.php';
?>

<?php
  if(isset($_REQUEST['update'])){
  if(($_POST['phone'] !== '') && ($_REQUEST['name'] !== '')){  
    if(empty($_FILES['profilepic']['name'])){
      $image_name = $_REQUEST['old-image'];
      $name = trim($_REQUEST['name']);
       $phone = trim($_REQUEST['phone']);
       $sql = "UPDATE `student` SET `stu_img` = ?,  stu_name = ?, stu_phone = ? WHERE `student`.`stu_id` = ?";
       $result = $conn->prepare($sql);
       if($result->execute(array($image_name, $name, $phone, $stu_id))){
         $msg = '<div class="alert alert-success" id="msgupdate">Updated Successfully</div>'; }
    } else{
      /*echo '<br><br><br><pre>';
      echo print_r($_FILES);
      echo '</pre>';*/
      $errors = array();
     
      $file_name = $_FILES['profilepic']['name'];
      $file_size = $_FILES['profilepic']['size'];
      $file_tmp = $_FILES['profilepic']['tmp_name'];
      $file_type = $_FILES['profilepic']['type'];
      $file_e = explode('.', $file_name);
      $file_ext = end($file_e);
      $extensions = array('jpeg', 'jpg','png','JPG');
    
      if(in_array($file_ext, $extensions) == FALSE){
        $errors[] = "This file extension is not allowed, Please choose a .jpg or .png file";
      }
    
      if($file_size > 512000){
        $errors[] = "File size must be less than 500 KB";
      }
      
      $new_name = time()."--".basename($file_name);
      $target = "profilepic/".$new_name;
      $image_name = $new_name;
    
      if(empty($errors) == TRUE){
        $sql = "SELECT stu_img FROM student WHERE stu_id = ?"; 
        $result = $conn->prepare($sql);
        $result->execute(array($stu_id));
        
        /*$value = $result->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        echo print_r($value);
        echo '</pre>';*/

        if($result->rowCount() >= 1){
          $value = $result->fetch(PDO::FETCH_ASSOC);
          if($value['stu_img'] !== 'image'){
            unlink('profilepic/'.$value['stu_img']);
          }          
          move_uploaded_file($file_tmp, $target);
          $name = trim($_REQUEST['name']);
          $phone = trim($_REQUEST['phone']);
          $sql = "UPDATE `student` SET `stu_img` = ?,  stu_name = ?, stu_phone = ? WHERE `student`.`stu_id` = ?";
          $result = $conn->prepare($sql);
          if($result->execute(array($image_name, $name, $phone, $stu_id))){
            $msg = '<div class="alert alert-success" id="msgupdate">Updated Successfully</div>';
         
           }
        }      
      }else{
        $msg = '';
        foreach($errors as $error_msg){
          $msg .= '<div class="alert alert-danger">'.$error_msg.'</div>';
        }
        /*print_r($errors);
        die();*/
      }
    }
       
      }else{
        $msg = '<div class="alert alert-danger" id="msgupdate">Fill all fields</div>';
      }
  }

  $sql2 = "SELECT stu_img, stu_name, stu_rollno, stu_email, stu_phone FROM student WHERE stu_id = ?";
  $result2 = $conn->prepare($sql2);
  if($result2->execute(array($stu_id))){ 
    if($row2 = $result2->fetch(PDO::FETCH_ASSOC)){
      if($row2['stu_img'] == 'image'){
        $img = 'projectpic.png';
      }else{
        $img = $row2['stu_img'];
      }  
    }else{
      $img = 'projectpic.png';
    }
  }
    
?>

<header class="w3-container" style="padding-top:15px">
    <h4 class="w3-center"><b>Update profile</b></h4>
</header>

<!-- Update Profile Form start -->
<div class="w3-container">
  <div class="row justify-content-center">
      <div class="col-md-6 col-sm-6 shadow">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
      <div class="w3-section">
        <label for="name">Name</label>
        <input type="text" class="w3-input w3-border" id="name" name="name" required value="<?php echo $row2['stu_name']; ?>">
      </div>
      <div class="w3-section">
        <label for="email">Email</label>
        <input type="email" class="w3-input w3-border" id="email" name="email" required value="<?php echo $row2['stu_email']; ?>" disabled>
      </div>
      <div class="w3-section">
        <label for="phone">Phone Number</label>
        <input type="number" class="w3-input w3-border" id="phone" name="phone" required value="<?php echo $row2['stu_phone']; ?>">
      </div>
      <div class="w3-section">
        <label for="roleno">Roll No</label>
        <input type="number" class="w3-input w3-border" id="roleno" name="roleno" required value="<?php echo $row2['stu_rollno']; ?>" disabled>
      </div>
      <div class="w3-section">
        <label for="profilepic">Profile Picture <small> (Note : Image size should be less than 500 KB) </small></label>
        <input type="hidden" name="old-image" value="<?php if(isset($img)){ echo $img; }  ?>">
        <input type="file" class="w3-input w3-border w3-white" id="profilepic" name="profilepic">
        <img src="./profilepic/<?php if(isset($img)){ echo $img; }  ?>" alt="Profile Picture" width="100px" height="100px">
      </div>
      <?php if(isset($msg)){ echo $msg; } ?>
      <div class="row justify-content-center">
        <div class="col-sm-1 col-md-2">
            <button type="submit" class="w3-btn w3-green text-center" name="update" ><i class="fa-solid fa-check"></i> Update</button>
        </div>
      </div>      
    </form><br>
    </div>
    </div>
  </div><br><br><br><br>
<!-- Update Profile Form end -->
<noscript>Enable JavaScript to access this application.</noscript>
<script>
  if(document.getElementById('msgupdate')){
    setTimeout(() => {
      document.getElementById('msgupdate').remove();
      refresh();
    }, 100);

    function refresh(){
   location.href = "<?php echo $hostname; ?>/student/updateprofile.php";
    }
  }
</script>
<?php include("footer.php"); ?>