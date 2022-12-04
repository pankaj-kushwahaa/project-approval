<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<meta name="keywords" content="Project approval system, approval system, project approval system for colleges" />
<meta name="description" content="Project Approval System for Sri Sukhmani college, Dera Bassi, Dist: Mohali, Punjab. Approve your project, we will focus mainly on automating the process of project approval and submission" />
<meta name="google-site-verification" content="Vo-CsUAMQUlOfhAsJjzH1WuNpog6nsGpoT1OrCJqZRg" />
<mata name="robots" content="noindex" />
<link rel="stylesheet" href="../css/bootstrap.css" />
<link rel="stylesheet" href="../css/w3css.css" />
<link rel="stylesheet" href="../css/fontawesome.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="icon" type="image/x-icon" href="../favicon.ico" />
<!-- <link rel="stylesheet" href="../css/fontawesome2.css"> -->
<title><?php echo TITLE; ?></title>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4;">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i></button>
  <span class="w3-bar-item" style="text-align:center;">Project Approval System</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:250px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <?php
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
      <img src="./profilepic/<?php echo $img;  ?>" alt="Display Picture" class="w3-circle w3-margin-right mt-2" style="width:60px; height:60px;">
    </div>
    <div class="w3-col s8 w3-bar justify-content-center align-item-center mt-2">
    <strong id="welcome"><?php echo $row2['stu_name']."<br> ".$row2['stu_rollno']; ?></strong><br>
    </div>
  </div>
  <hr>
  <!-- Sidebar urls start -->
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-12 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="dashboard.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'Student Dashboard'){ echo 'w3-blue'; } ?>"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <?php
      $sql3 = "SELECT pro_id FROM project_request WHERE pro_stu_id = ? AND pro_approved = ?";
      $result3 = $conn->prepare($sql3);
      $result3->execute(array($stu_id, 1));
      if($result3->rowCount() >= 1){
      }else{ ?>
      <a href="submitproject.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'submitproject'){ echo 'w3-blue w3-btn'; } ?>"><i class="fa-solid fa-arrow-right mx-1"></i> Submit project</a>
    <?php } ?>
    <?php
      $sql = "SELECT pro_id FROM project_request WHERE pro_stu_id = ?";
      $result = $conn->prepare($sql);
      if($result->execute(array($_SESSION['s_id']))){
        if($result->rowCount()){
          ?>
        <a href="projectstatus.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'projectstatus'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-clock mx-1"></i>  Project status</a>
    <?php  }
      }
      $sql6 = "SELECT pro_id, pro_approved FROM project_request WHERE pro_stu_id = ?";
      $result6 = $conn->prepare($sql6);
      if($result6->execute(array($_SESSION['s_id']))){
        if($result6->rowCount()){
          $value6 = $result6->fetchAll(PDO::FETCH_ASSOC);
          /*echo '<pre>';
          echo print_r($value6);
          echo '</pre>';*/
          $arr = [];
          foreach($value6 as $row6){
            if($row6['pro_approved'] == 1){
              $arr[] = 1;
            }
          }
          /*echo '<pre>';
          echo print_r($arr);
          echo '</pre>';*/

          if($arr){
    ?>
    <a href="updateproject.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'updateproject'){ echo 'w3-blue'; } ?>"><i class="fa fa-users fa-fw"></i>  Update project</a>
    <?php }}} ?>
    <a href="enquery.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'enquery'){ echo 'w3-blue'; } ?>"><i class="fa fa-bullseye fa-fw"></i> Project enquery</a>
    <a href="addmember.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'addmember'){ echo 'w3-blue'; } ?>"><i class="fa fa-diamond fa-fw"></i>  Add members</a>
    <a href="updateprofile.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'updateprofile'){ echo 'w3-blue'; } ?>" id="updateEvent"><i class="fa fa-bell fa-fw"></i>  Update profile</a>
    <a href="changepassword.php" class="w3-bar-item w3-btn w3-padding <?php if(PAGE == 'changepassword'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-key"></i>  Change password</a>
    <a href="logout.php" class="w3-bar-item w3-btn w3-padding"><i class="fa fa-history fa-fw"></i>  Logout</a><br><br>
  </div>
</nav>
<!-- End Side bar urls -->
<!-- Sidebar Menu end -->

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px;margin-top:30px;">