<?php 
include 'loginredirect.php';
define('TITLE', 'Update Project Status'); 
define('PAGE', 'updateproject');
include("header.php"); 
include '../config.php';
?>
<header class="w3-container" style="padding-top:15px">
    <h4 class="w3-center"><b>Update project status</b></h4>
</header>

<div class="w3-container">
  <div class="row justify-content-center">
      <div class="col-md-12 col-sm-12">
      <form action="" >
        <div class="w3-section">
          <?php  
            $sql = "SELECT pro_id, pro_title FROM project_request WHERE pro_stu_id = ? AND pro_approved = ?";
            $result = $conn->prepare($sql);
            $result->execute(array($stu_id, 1));
            $row = $result->fetch(PDO::FETCH_ASSOC);
              /*echo '<pre>';
              echo print_r($row);
              echo '</pre>';*/
          ?>
          <label for="title">Title</label>
          <input type="text" class="w3-input w3-border" id="title" disabled name="title" value="<?php echo $row['pro_title']; ?>">
        </div>
      <div class="w3-section">
        <label for="description">How much project has completed?</label>
        <textarea class="w3-input w3-border" rows="10"  id="description" required name="description"><?php  $sql3 = "SELECT sta_status FROM project_status WHERE sta_stu_id = ?";
        $result3 = $conn->prepare($sql3);
        $result3->execute(array($stu_id));
        
        $row3 = $result3->fetch(PDO::FETCH_ASSOC);
        /*echo '<pre>';
              echo print_r($row3);
              echo '</pre>';*/

         if(isset($row3['sta_status'])){ echo $row3['sta_status'];} ?></textarea>  
      </div>
      <button type="submit" class="w3-btn w3-center w3-green" name="update">Update</button>
    </form><br>
<?php 
  if(isset($_REQUEST['update'])){

    if(isset($row3['sta_status']) && $_REQUEST['description'] !== ''){
      $desc = trim($_REQUEST['description']);
      $sql3 = "UPDATE project_status SET sta_status = ?, sta_title = ? WHERE sta_stu_id = ?";
      $result3 = $conn->prepare($sql3);
      if($result3->execute(array($desc, $row['pro_title'],$stu_id))){
        echo '<script>location.href = "'.$hostname.'/student/updateproject.php"</script>';
      }
     }else{
      $desc = trim($_REQUEST['description']);
      $title = $row['pro_title'];
      $pro_id = $row['pro_id'];

      $sql2 = "INSERT INTO `project_status` (`sta_stu_id`, `sta_pro_id`, `sta_branch_id`, `sta_title`, `sta_status`, `sta_review`) VALUES (?, ?, ?, ?, ?, ?)";
      $result = $conn->prepare($sql2); 
      if($result->execute(array($stu_id, $pro_id, $stu_branch, $title, $desc, 0))){
        echo '<script>location.href = "'.$hostname.'/student/updateproject.php"</script>';
      }
  }
}

?>
    </div>
    </div>
  </div>

<div class="w3-conatainer">
    <div class="row">
        <div class="col-sm-12">
            
        </div>
    </div>
</div>
   



<?php include('footer.php'); ?>