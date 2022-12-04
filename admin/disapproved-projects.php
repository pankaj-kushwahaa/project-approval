<?php 
include 'loginredirect.php';
define('TITLE', 'All Disapproved Projects');
define('PAGE', 'Disapproved Projects');
include("includes/header.php"); 
include '../config.php';

// Pagination code
$limit = 5;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;
?>
<!-- Filter Section start -->
<div class="w3-container">
  <div class="w3-section w3-bottombar w3-padding-16">
    <span class="w3-margin-right">Filter:</span> 
    <a href="disapproved-projects.php" class="w3-button w3-black"><i class="fa-solid fa-graduation-cap mx-1"></i> All Disapproved<?php $sql8 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request pr INNER JOIN branch b ON pr.pro_branch_id = b.branch_id
    WHERE pr.pro_approved = ? AND pr.pro_review = ?";
            $result8 = $conn->prepare($sql8);
              if($result8->execute(array(0, 1))){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo ' ('.$row8['total_pro'].')';
              } ?></a>
    <?php
      $sql3 = "SELECT DISTINCT branch_id, branch_name FROM branch b 
      INNER JOIN project_request pr ON b.branch_id = pr.pro_branch_id WHERE pr.pro_approved = ? AND pr.pro_review = ?";
      $result3 = $conn->prepare($sql3);
      $result3->execute(array(0, 1));
      if($result3->rowCount()){
        $value3 = $result3->fetchAll(PDO::FETCH_ASSOC);
          /*echo '<pre>';
          echo print_r($value3);
          echo '</pre>';*/
          foreach($value3 as $row3){
            $sql4 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request WHERE pro_branch_id = ? AND pro_approved = ? AND pro_review = ? ORDER BY pro_id";
            $result4 = $conn->prepare($sql4);
              if($result4->execute(array($row3['branch_id'], 0, 1))){
                $row4 = $result4->fetch(PDO::FETCH_ASSOC);
                $total_pro = $row4['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row4);
                echo'</pre>';*/
              }
    ?><a href="disapproved-branch.php?branch_id=<?php echo $row3['branch_id'] ?>" class="w3-button w3-white"><?php echo $row3['branch_name'].' ('.$total_pro.')'; ?></a>

    <?php }} ?>
  </div>
</div>
<!-- Filter section end -->

<!-- Conatainer Start -->
<div class="w3-container">
  <h5>All Disapproved Projects</h5>
    <!-- Table Start -->
  <table class="w3-table w3-bordered w3-border w3-white">
    <thead>
      <tr>
          <th>S.No</th>
          <th>Members</th>
          <th>Title</th>
          <th>Branch/Sem</th>
          <th>Date</th>
          <th>File</th>
          <?php if($_SESSION['role'] == 0){ ?>
          <th>Action</th>
          <?php } ?>
      </tr>
    </thead>
    <?php
        include '../config.php';
        $sql = "SELECT pro_id, pro_title, pro_file, pro_date, stu_id, stu_name, stu_id, stu_rollno, branch_name, pro_branch_id FROM project_request pr
        LEFT JOIN student s ON pr.pro_stu_id = s.stu_id
        LEFT JOIN branch b ON b.branch_id = s.stu_branch WHERE pro_approved = ? AND pro_review = ?
        ORDER BY pro_id DESC LIMIT ?, ?"; 
        $result = $conn->prepare($sql);
        $result->execute(array(0, 1, $offset, $limit));
        
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
          <td><?php if(isset($row['pro_title'])){ echo $row['pro_title']; } ?></td>
          <td><?php if(isset($row['branch_name'])){ echo $row['branch_name']; } ?></td>
          <td><?php if(isset($row['pro_date'])){ echo $row['pro_date']; } ?></td>
          <td><a href="<?php if(isset($row['pro_file'])){ echo "{$hostname}/student/upload/".$row['pro_file']; } ?>" target="_blank" class="w3-btn w3-blue w3-small"><i class="fa-solid fa-circle-down"></i> Download</a></td>
          <?php if($_SESSION['role'] == 0){ ?>
          <td><form action="view-project.php" method="post"> <input type="hidden" name="project_id" value="<?php echo $row['pro_id'] ?>"><button type="submit" class=" w3-green w3-btn w3-small"><i class="fa-solid fa-eye"></i></button></form></td><td><label for="modalbox" id="modal-label<?php echo $row['pro_id'] ?>" class="w3-btn w3-red w3-small"><i class='fa-solid fa-trash'></i></label>
          <!-- Custom modal box -->
            <div class="cus-modal" id="modalbox<?php echo $row['pro_id'] ?>">
              <div class="cus-modal-box">
                <h5 style="display:inline">Confirm ?</h5><span style="float:right;" id="modal-span" onclick="document.getElementById('modalbox<?php echo $row['pro_id']; ?>').style.display='none'" >x</span><hr>
                <p>Do you want to delete ?</p>
                <!-- Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display:inline">
                  <input type="hidden" name="delete-approved" value="<?php echo $row['pro_id']; ?>">
                  <input type="hidden" name="del-branch" value="<?php echo $row['pro_branch_id']; ?>">
                  <input type="hidden" name="del-file" value="<?php echo $row['pro_file']; ?>">
          <!-- End Form -->
                <button type="submit" class="btn w3-green w3-btn" name="delete-pro"> Delete</button></form>
                <button class="btn w3-grey w3-btn" onclick="document.getElementById('modalbox<?php echo $row['pro_id']; ?>').style.display='none'">Close</button>
              </div>
            </div>
            <script>
              document.getElementById('modal-label<?php echo $row['pro_id']; ?>').addEventListener('click', () => {
                document.getElementById('modalbox<?php echo $row['pro_id']; ?>').style.display = 'block';
                (this).preventDefault();
              });
            </script>
<!-- Custom modal box end -->
</td>
<?php
// Project delete code

if(isset($_REQUEST['delete-approved'])){
  $delete = $_REQUEST['delete-approved'];
  $delete_file = $_REQUEST['del-file'];
  $branch_pro = $_REQUEST['del-branch'];
  //echo '<script> alert("button")</script>';
  $sql5 = "DELETE FROM project_request WHERE pro_id = ?";
  $result5 = $conn->prepare($sql5);
  unlink('../student/upload/'.$delete_file);
  if($result5->execute(array($delete))){
    $sql6 = "UPDATE branch SET total_pro_req = total_pro_req - ? WHERE branch_id = ?";
    $result6 = $conn->prepare($sql6);
    if($result6->execute(array(1, $branch_pro))){
      echo '<script> location.href = "'.$hostname.'/admin/disapproved-projects.php"</script>';
    }
  }
}
?>
          <?php } $num++;
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
    $sql2 = "SELECT pro_id FROM project_request pr
    INNER JOIN student s ON pr.pro_stu_id = s.stu_id
    WHERE pr.pro_review = ? AND pr.pro_approved = ?";

    $result2 = $conn->prepare($sql2);
    $result2->execute(array(1, 0));
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-grey mx-1"><a href="disapproved-projects.php?page='.($page-1).'">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-grey mx-1 '.$active.'"><a href="disapproved-projects.php?page='.$i.'" class="w3-blue" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-grey mx-1"><a href="disapproved-projects.php?page='.($page + 1).'">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
    <!-- Pagination End -->
</div> 
  <!-- container end -->

<?php include("includes/footer.php"); ?>