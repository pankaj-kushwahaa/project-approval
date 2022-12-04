<?php 
include 'loginredirect.php';
define('TITLE', 'Project Status'); 
define('PAGE', 'projectstatus');
include("header.php"); 

if(isset($_REQUEST['delete_Btn'])){
  $pro_id = $_REQUEST['project_id'];
  $sql2 = "DELETE FROM project_request WHERE pro_id = ?";
  $result2 = $conn->prepare($sql2);
  if($result2->execute(array($pro_id))){
  $msg = '<div class="alert alert-success mx-2" id="rem">Deleted successfully</div>';
  }
}
?>
<header class="w3-container" style="padding-top:15px">
    <h4 class="w3-center"><b>Approval status</b></h4>
</header>


<?php
include '../config.php';
$sql9 = "SELECT pro_id, pro_title, pro_desc, pro_file, pro_date, pro_approved, pro_app_date, pro_review, pro_comment  FROM project_request 
WHERE pro_stu_id = ?"; 
$result9 = $conn->prepare($sql9);
$result9->execute(array($stu_id));
if($result9->rowCount()){
  while($row9 = $result9->fetch(PDO::FETCH_ASSOC)){
?>
<div class="container">
 <div class="row">
    <div class="col-md-10 col-sm-12 my-2">
      <div class="card">
        <div class="card-header w3-white">
          <h4><?php if(isset($row9['pro_title'])){ echo $row9['pro_title']; } ?></h4>          
        </div>
        <div class="card-body">
          <p class="card-text"><?php if(isset($row9['pro_desc'])){ echo substr($row9['pro_desc'], 0 , 100).'...'; } ?></p>
              <?php if($row9['pro_approved'] == 1){ $alert = '<div class="alert alert-success">Approved,<br>'.$row9['pro_comment'].'</div>';}else{
                if($row9['pro_comment'] !== 'empty'){ $alert = '<div class="alert alert-danger">Disapproved,<br>Reply : '.$row9['pro_comment'].'<br></div>'; }else{
                  $alert = '<div class="alert alert-warning w3-pale-yellow">Pending for approval...<br></div>';
                } }
              if(isset($alert)){ echo $alert;}
              if($row9['pro_approved'] == 0){ 
            ?>
            <form action="">
              <input type="hidden" name="project_id" value="<?php echo $row9['pro_id']; ?>">
              <button type="submit" name="delete_Btn" class="w3-btn"><i class='fa-solid fa-trash'></i> Delete</button>
            </form>

            <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php  }} if(isset($msg)){echo $msg; } ?>
<script>
  if(document.getElementById('rem')){
    setTimeout(() => {
      document.getElementById('rem').remove();
    }, 1500);
  }
</script>

<?php include "footer.php"; ?>