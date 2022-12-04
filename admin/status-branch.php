<?php 
include 'loginredirect.php';
define('TITLE', 'Project Status');
define('PAGE', 'Project Status');
include("includes/header.php"); 
include '../config.php';

if(isset($_REQUEST['branch_id'])){

$branch_id = $_REQUEST['branch_id'];

$limit = 5;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;

if(isset($_REQUEST['del-sta-btn'])){
  $sta_id = $_REQUEST['del-status'];
  $sql5 = "DELETE FROM project_status WHERE sta_id = ?";
  $result5 = $conn->prepare($sql5);
  if($result5->execute(array($sta_id)) == TRUE){
    echo '<script> location.href = "'.$hostname.'/admin/project-status.php"; </script>';
  }
}
?>

<div class="w3-container">
  <div class="w3-section w3-bottombar w3-padding-16">
    <span class="w3-margin-right">Filter:</span> 
    <a href="project-status.php" class="w3-button w3-white">All Projects<?php $sql8 = "SELECT sta_id, COUNT(sta_id) total_pro FROM project_status ps INNER JOIN branch b ON ps.sta_branch_id = b.branch_id";
            $result8 = $conn->prepare($sql8);
              if($result8->execute()){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo ' ('.$row8['total_pro'].')';
              } ?></a>
    <?php
      $sql3 = "SELECT DISTINCT branch_id, branch_name FROM branch b 
      INNER JOIN project_status ps ON b.branch_id = ps.sta_branch_id";
      $result3 = $conn->prepare($sql3);
      $result3->execute();
      if($result3->rowCount()){
        $value3 = $result3->fetchAll(PDO::FETCH_ASSOC);
          /*echo '<pre>';
          echo print_r($value3);
          echo '</pre>';*/
          foreach($value3 as $row3){
            $sql4 = "SELECT sta_id, COUNT(sta_id) total_sta FROM project_status WHERE sta_branch_id = ? ORDER BY sta_id";
            $result4 = $conn->prepare($sql4);
              if($result4->execute(array($row3['branch_id']))){
                $row4 = $result4->fetch(PDO::FETCH_ASSOC);
                $total_pro = $row4['total_sta'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row4);
                echo'</pre>';*/
                if($row3['branch_id'] == $branch_id){  
                  $black = 'w3-black';
                  }else{
                    $black = '';
                  }
                
    ?><a href="status-branch.php?branch_id=<?php echo $row3['branch_id'] ?>" class="w3-button w3-white <?php echo $black; ?>"><?php echo $row3['branch_name'].' ('.$total_pro.')'; ?></a>
    <?php }} ?>
  </div>
</div>

<!-- Conatainer Start -->
<div class="w3-container">
  <h5>All <?php echo $row3['branch_name']; ?> Status</h5>
    <!-- Table Start -->
  <table class="w3-table w3-bordered w3-border w3-white">
    <thead>
      <tr>
          <th>S.No</th>
          <th>Members</th>
          <th>Title</th>
          <th>Branch</th>
          <th>Action</th>
      </tr>
    </thead>
<?php
    $sql = "SELECT sta_id, sta_status, sta_title, stu_id, stu_name, stu_id, stu_rollno, branch_name FROM project_status ps
    LEFT JOIN student s ON ps.sta_stu_id = s.stu_id
    LEFT JOIN branch b ON b.branch_id = s.stu_branch WHERE sta_branch_id = ?
    ORDER BY sta_id DESC LIMIT ?, ?"; 
    $result = $conn->prepare($sql);
    $result->execute(array($branch_id, $offset, $limit));
    
    /*$row = $result->fetchAll(PDO::FETCH_ASSOC);
    echo '<pre>';
    echo print_r($row);
    echo '</pre>';*/

    if($result->rowCount()){
      $num = $offset + 1;
      $value = $result->fetchAll(PDO::FETCH_ASSOC);
      foreach($value as $row){
      ?>
    <tbody>
      <tr>
          <td><?php echo $num; ?></td>
          <?php  
            $sql1 = "SELECT * FROM members WHERE m_stu_id = ?";
            $result1 = $conn->prepare($sql1);
            $result1->execute(array($row['stu_id']));
            
            if($result1->rowCount()){
             /* $row1 = $result1->fetchAll(PDO::FETCH_ASSOC);
              echo '<pre>';
              echo print_r($row1);
              echo '</pre>';*/
              $Members = '<td>';
              $Members .= $row['stu_name'].' '.$row['stu_rollno']."<br>";
              while($row1 = $result1->fetch(PDO::FETCH_ASSOC)){
              $Members .= $row1['m_name'].' '.$row1['m_rollno'].'<br>';
              } 
              $Members .= '</td>';
            }else{
              $Members = '<td>'.$row['stu_name'].' '.$row['stu_rollno'].'</td>';
            }
          ?>
        <?php if(isset($Members)){echo $Members;}  ?>
         <td><?php if(isset($row['sta_title'])){ echo $row['sta_title']; } ?></td>
         <td><?php if(isset($row['sta_status'])){ echo $row['sta_status']; } ?></td>
         <td><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><input type="hidden" name="del-status" value="<?php if(isset($row['stu_id'])){ echo $row['sta_id']; }  ?>"> <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>"><input type="submit" value="Delete" name="del-sta-btn" class="w3-btn w3-green"></form></td>

          <?php  $num++;
           }
          } else{
            $msg = '<td class="w3-white" style="font-size:20px;">No records</td>';
          }
         ?>
         <?php if(isset($msg)){ echo $msg; } ?>
         </tr>
        </tbody>
  </table><br>
  <!-- Table End -->

    <!-- Pagination Start -->
<div class="w3-row pagination">
  <?php
    $sql2 = "SELECT sta_id FROM project_status ps
    INNER JOIN student s ON ps.sta_stu_id = s.stu_id WHERE sta_branch_id = ?";

    $result2 = $conn->prepare($sql2);
    $result2->execute(array($branch_id));
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-grey mx-1"><a href="status-branch.php?branch_id='.$branch_id.'&page='.($page-1).'">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-grey mx-1 '.$active.'"><a href="status-branch.php?branch_id='.$branch_id.'&page='.$i.'" class="w3-blue" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-grey mx-1"><a href="status-branch.php?branch_id='.$branch_id.'&page='.($page + 1).'">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
    <!-- Pagination End -->
</div> 
<?php }} ?>
  <!-- container end -->


<?php include("includes/footer.php"); ?>