<?php 
include 'loginredirect.php';
include('../config.php');

$date = date('d M Y');
// Show details 
if(isset($_POST['project_id'])){
  $pro_id = $_POST['project_id'];

$sql5 = "SELECT pro_approved, pro_review FROM project_request WHERE pro_id = ?";
$result5 = $conn->prepare($sql5);
$result5->execute(array($pro_id));
$row5 = $result5->fetch(PDO::FETCH_ASSOC);
if(($row5['pro_approved'] == 0) && ($row5['pro_review'] == 0)){
  define('TITLE', 'View Project');
  define('PAGE', 'All Projects');
}
if(($row5['pro_approved'] == 0) && ($row5['pro_review'] == 1)){
  define('TITLE', 'View Project');
  define('PAGE', 'Disapproved Projects');
}
if(($row5['pro_approved'] == 1) && ($row5['pro_review'] == 1)){
  define('TITLE', 'View Project');
  define('PAGE', 'Approved Projects');
}

include("includes/header.php");

// Reject button
if(isset($_POST['reject'])){
  if($_POST['comment'] !== ''){
    $comment3 = $_POST['comment'];
    $pro_id2 = $_REQUEST['project_id'];
    $sql4 = "UPDATE project_request SET pro_review = ?, pro_approved = ?, pro_comment = ?, pro_app_date = ? WHERE pro_id = ?";
    include '../config.php';
    $result4 = $conn->prepare($sql4);
    if($result4->execute(array(1, 0, $comment3, $date, $pro_id2))){
    echo '<script>location.href = "'.$hostname.'/admin/projects.php"</script>';
    }
  }else{
    $msg = '<div class="alert alert-danger">Fill comment field</div>';
  }
}

// Accept button
if(isset($_POST['accept'])){
  if($_POST['comment'] !== ''){
  $comment = $_POST['comment'];
  $pro_id5 = $_REQUEST['project_id'];
  include '../config.php';
  $sql2 = "UPDATE project_request SET pro_review = ?, pro_approved = ?, pro_comment = ?, pro_app_date = ? WHERE pro_id = ?";
  $result2 = $conn->prepare($sql2);
  if($result2->execute(array(1, 1, $comment, $date, $pro_id5))){
    echo '<script>location.href = `'.$hostname.'/admin/projects.php?q=a`</script>';
  }
  }else{
  $comment1 = 'Ok';
  $pro_id1 = $_REQUEST['project_id'];
  $sql3 = "UPDATE project_request SET pro_review = ?, pro_approved = ?, pro_comment = ?, pro_app_date = ? WHERE pro_id = ?";
  $result3 = $conn->prepare($sql3);
  if($result3->execute(array(1, 1, $comment1, $date, $pro_id1))){   
    echo '<script>location.href = `'.$hostname.'/admin/projects.php?q=a`</script>';
  }
}
}
?>

<div class="w3-container">
  <div class="row mt-3 justify-content-center mt-4">
    <div class="col-sm-12">
      <table class="w3-table w3-bordered w3-white w3-border">
<?php
        $sql = "SELECT pro_id, pro_title, pro_desc, pro_file, pro_date, stu_id, stu_name, stu_email, stu_id, stu_rollno, branch_name, stu_phone, pro_branch_id, pro_stu_id FROM project_request pr
        LEFT JOIN student s ON pr.pro_stu_id = s.stu_id
        LEFT JOIN branch b ON b.branch_id = s.stu_branch 
        WHERE pro_id = ?"; 
        $result = $conn->prepare($sql);
        $result->execute(array($pro_id));
        
        /*$row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        echo print_r($row);
        echo '</pre>';*/

        if($result->rowCount()){
        $value = $result->fetchAll(PDO::FETCH_ASSOC);
          foreach($value as $row){

           /* $pro_stu_id = $row['pro_stu_id'];
            $pro_title = $row['pro_title'];
            $pro_branch = $row['pro_branch_id'];
            $pro_id = $row['pro_id'];*/

            if($row['stu_id'])
            $sql1 = "SELECT * FROM members WHERE m_stu_id = ?";
            $result1 = $conn->prepare($sql1);
            $result1->execute(array($row['stu_id']));
            
            $Members = '';
            if($result1->rowCount() > 0){
            /* $row1 = $result1->fetchAll(PDO::FETCH_ASSOC);
              echo '<pre>';
              echo print_r($row1);
              echo '</pre>';*/
              $total_member = ($result1->rowCount() + 1);
              $Members = $row['stu_name'].' '.$row['stu_rollno'].", ";
              while($row1 = $result1->fetch(PDO::FETCH_ASSOC)){
              $Members .= $row1['m_name'].' '.$row1['m_rollno'].', ';
              } 
            }else{
              $Members .= $row['stu_name'].' '.$row['stu_rollno'];
            }
?>
          <tr><th>Email Id / Phone No</th><td><?php if(isset($row['stu_email'])){ echo $row['stu_email']." "; } ?><strong>/</strong><?php if(isset($row['stu_phone'])){ echo " ".$row['stu_phone']; } ?></td></tr>
          <?php if(isset($Members)){ echo '<tr><th>Team Members</th><td>'.$Members; }
          if(isset($total_member)){ echo '('.$total_member.')</td></tr>'; } else{ echo ' (1)</td></tr>'; } ?>
          <tr><th>Branch / Sem</th><td><?php if(isset($row['branch_name'])){ echo $row['branch_name']; } ?></td></tr>
      </table>
    </div>
  </div>
</div>

<div class="w3-container">
  <div class="row mt-2">
    <div class="col-sm-12">
      <div class="card">
          <div class="card-body">
            <h6>Date : <?php if(isset($row['pro_date'])){echo $row['pro_date'];}?></h6>
            <h5>Title : <?php if(isset($row['pro_title'])){echo $row['pro_title'];}?></h5>
            <h5 style="display:inline;">Summary : </h5>
            <span><?php if(isset($row['pro_desc'])){ echo $row['pro_desc']; } ?></span><br><br>
            <a href="<?php echo "{$hostname}/student/upload/".$row['pro_file']; ?>" target="_blank" rel="noopener noreferrer" class="w3-blue w3-btn shadow-btn">Download</a>
          </div>
      </div>
      <?php  
        $sql2 = "SELECT pro_id, pro_approved, pro_review FROM project_request
        WHERE pro_id = ?"; 
        $result2 = $conn->prepare($sql2);
        $result2->execute(array($pro_id));
        
        /*$row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo '<pre>';
        echo print_r($row);
        echo '</pre>';*/

        if($result2->rowCount()){
          $row2 = $result2->fetch(PDO::FETCH_ASSOC);
          if(($row2['pro_approved'] == 0)){
      ?>
      <div class="row">
        <div class="col-sm-12 col-md-12 mt-4">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <label for="comment">Suggetion : <?php if(isset($msg)){ echo $msg; } ?></label>
            <input type="text" name="comment" id="comment" class="w3-input">
            <input type="hidden" value="<?php echo $row['pro_id'] ?>" name="project_id">
            <div class="row justify-content-center">
              <div class="col-sm-3 mt-3">
                <button type="submit" name="accept" class="w3-btn btn w3-green w3-large shadow-btn mx-">Accept</button>
                <button type="submit" name="reject" <?php if(($row2['pro_review'] == 1) && $row2['pro_approved'] == 0){ echo ' disabled ';}?> class="w3-btn btn w3-red w3-large shadow-btn mx-2">Reject</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php }} ?>
    </div>
  </div>
</div>
<?php }}} ?>
<br><br><br>

<?php include("includes/footer.php");?>