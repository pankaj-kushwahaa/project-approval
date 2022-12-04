<?php
include 'loginredirect.php';
define('TITLE', 'Project Approval System');
define('PAGE', 'Home');
include("includes/header.php");
include '../config.php';
?>

  <header class="w3-container" style="padding-top:10px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>


<div class="w3-row-padding w3-margin-bottom">
  <div class="w3-quarter">
    <a href="projects.php" style="text-decoration:none;">
      <div class="w3-container w3-pink w3-padding-16">
        <div class="w3-left"><i class="fa-solid fa-arrow-right mx-1 w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
            <?php $sql8 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request pr INNER JOIN branch b ON pr.pro_branch_id = b.branch_id
            WHERE pr.pro_review = ?";
            $result8 = $conn->prepare($sql8);
              if($result8->execute(array(0))){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo $row8['total_pro'];
              } ?>
            </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Requests</h4>
      </div>
    </a>
  </div>
  
  <div class="w3-quarter">
    <a href="student-enquery.php" style="text-decoration:none;">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php $sql8 = "SELECT DISTINCT en_stu_id, COUNT(en_stu_id) total_en FROM enquery e INNER JOIN branch b ON e.en_branch_id = b.branch_id GROUP BY en_stu_id HAVING COUNT(en_stu_id) >= ?";
            $result8 = $conn->prepare($sql8);
            $result8->execute([1]);
              if($rownum = $result8->rowCount() > 0){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_en'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo $row8['total_en'];
              }else{ echo 0;} ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Enqueries</h4>
      </div>
    </a>
  </div>
  
  <div class="w3-quarter">
    <a href="project-status.php" style="text-decoration:none;">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php $sql8 = "SELECT sta_id, COUNT(sta_id) total_pro FROM project_status ps INNER JOIN branch b ON ps.sta_branch_id = b.branch_id";
            $result8 = $conn->prepare($sql8);
              if($result8->execute()){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo $row8['total_pro'];
              } ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Statuses</h4>
      </div>
    </a>
  </div>
  <div class="w3-quarter">
    <a href="registered-users.php" style="text-decoration:none;">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">       
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php $sql8 = "SELECT stu_id, COUNT(stu_id) total_pro FROM student s INNER JOIN branch b ON s.stu_branch = b.branch_id";
            $result8 = $conn->prepare($sql8);
              if($result8->execute()){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                echo $row8['total_pro'];
              } ?>
            </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </a>
  </div> 
</div>
<!-- Next container -->
<div class="w3-row-padding w3-margin-bottom">
  <div class="w3-quarter">
    <a href="approved-projects.php" style="text-decoration:none;">
      <div class="w3-container w3-green w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa-solid fa-check w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php $sql8 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request pr INNER JOIN branch b ON pr.pro_branch_id = b.branch_id
    WHERE pr.pro_approved = ?";
            $result8 = $conn->prepare($sql8);
              if($result8->execute(array(1))){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                echo $row8['total_pro'];
              } ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Approved</h4>
      </div>
    </a>
  </div>
  
  <div class="w3-quarter">
    <a href="disapproved-projects.php" style="text-decoration:none;">
      <div class="w3-container w3-red w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa-solid fa-xmark w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
            <?php $sql8 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request pr INNER   JOIN branch b ON pr.pro_branch_id = b.branch_id
            WHERE pr.pro_approved = ? AND pr.pro_review = ?";
            $result8 = $conn->prepare($sql8);
              if($result8->execute(array(0, 1))){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                echo $row8['total_pro'];
              } ?>
            </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Disapproved</h4>
      </div>
    </a>
  </div>
  
  <div class="w3-quarter">
    <a href="manage-post.php" style="text-decoration:none;">
      <div class="w3-container w3-purple w3-padding-16">
        <div class="w3-left"><i class="fa fa-blog w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php $sql8 = "SELECT post_id, COUNt(post_id) total_post FROM post";
            $result8 = $conn->prepare($sql8);
            $result8->execute();
              if($rownum = $result8->rowCount() > 0){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_post'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo $row8['total_post'];
              }else{ echo 0;} ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Posts</h4>
      </div>
    </a>
  </div>
  
   <div class="w3-quarter">
    <a href="manage-file.php" style="text-decoration:none;">
      <div class="w3-container w3-indigo w3-padding-16">
        <div class="w3-left"><i class="fa fa-file w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php $sql8 = "SELECT file_id, COUNt(file_id) total_file FROM file";
            $result8 = $conn->prepare($sql8);
            $result8->execute();
              if($rownum = $result8->rowCount() > 0){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_file'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo $row8['total_file'];
              }else{ echo 0;} ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Files</h4>
      </div>
    </a>
  </div>
  
  </div> 
  <!--End of container-->

</div>
  

  

<?php include("includes/footer.php"); ?>