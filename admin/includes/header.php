<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="Project approval system, approval system, project approval system for colleges" />
<meta name="description" content="Project Approval System for Sri Sukhmani college, Dera Bassi, Dist: Mohali, Punjab. Approve your project, we will focus mainly on automating the process of project approval and submission" />
<mata name="robots" content="noindex" />
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link rel="stylesheet" href="../css/bootstrap.css" />
<link rel="stylesheet" href="../css/w3css.css" />
<link rel="stylesheet" href="../css/fontawesomepro.css" />
<link rel="stylesheet" href="../css/fontawesome.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="icon" type="image/x-icon" href="../favicon.ico" />
<!-- <link rel="stylesheet" href="../css/fontawesome2.css"> -->


<title><?php echo TITLE; ?></title>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4; height:40px">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa-solid fa-bars"></i></button>
  <span class="w3-bar-item" style="text-align:center;">Project Approval System</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:250px;" id="mySidebar">
  
  <div class="w3-container mt-3">
    <div class="w3-col s12 w3-bar align-self-center mt-1">
      <span><strong><?php
      $sql50 = "SELECT role, email FROM admin_tb WHERE id = ?";
      $result50 = $conn->prepare($sql50);
      $result50->execute(array($s_id));
      $result50->bindColumn('email', $username);
      $result50->fetch(PDO::FETCH_ASSOC);
      echo $username.'<br>'; if($s_role == 0){ echo 'Admin';}else{ echo 'Teacher';} ?></strong></span>
    </div>
  </div>
  <hr>
  <!-- <div class="w3-container">
    <h5>Dashboard</h5>
  </div> -->
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-10 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="dashboard.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Home'){ echo 'w3-blue'; } ?>"><i class="fa fa-users fa-fw mx-1"></i> Overview</a>
    <a href="projects.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'All Projects'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-arrow-right mx-1"></i> Approval requests</a>
    <a href="approved-projects.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Approved Projects'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-check mx-1"></i> Approved projects</a>
    <a href="disapproved-projects.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Disapproved Projects'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-xmark mx-1"></i> Disapproved projects</a><a href="add-branch.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Add Branch'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-graduation-cap mx-1"></i> Add branch</a>
    <a href="project-status.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Project Status'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-clock mx-1"></i> Project status</a>
    <a href="student-enquery.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Enquery'){ echo 'w3-blue'; } ?>"><i class="fa fa-bullseye fa-fw"></i> Student enquery</a>
    <a href="registered-users.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Registered Users'){ echo 'w3-blue'; } ?>"><i class="fa fa-users mx-1"></i> Registered users</a>
    <a href="add-teachers.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Add Users'){ echo 'w3-blue'; } ?>"><i class="fa-solid fa-user mx-1"></i> Add users</a>
    <a href="add-projects.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Add Post'){ echo 'w3-blue'; } ?>"><i class="fa fa-bank fa-fw mx-1"></i> Add post</a>
    <a href="manage-post.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Manage Post'){ echo 'w3-blue'; } ?>"><i class="fa fa-dashboard mx-1"></i> Manage posts</a>
    <a href="manage-file.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Manage Files'){ echo 'w3-blue'; } ?>" target="_brank"><i class="fa fa-file mx-1"></i> Manage files</a>
    <a href="update-credential.php" class="w3-bar-item w3-button w3-padding <?php if(PAGE == 'Update Credential'){ echo 'w3-blue'; } ?>"><i class="fa fa-history fa-fw"></i> Update profile</a>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding"><i class="fa-solid fa-right-from-bracket mx-1"></i> Logout</a><br><br>
  </div>
</nav>
<!-- End Side bar -->

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:250px;margin-top:30px;">