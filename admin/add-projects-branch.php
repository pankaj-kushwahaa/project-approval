<?php 
include 'loginredirect.php';
define('TITLE', 'Add Project');
define('PAGE', 'Add Post');
include("includes/header.php");
include '../config.php';

if(isset($_REQUEST['branch_id'])){
$branch_id = $_REQUEST['branch_id'];

// Pagination code
$limit = 2;
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
    <a href="add-projects.php" class="w3-button w3-white"><i class="fa-solid fa-graduation-cap mx-1"></i> All Approved<?php $sql8 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request pr INNER JOIN branch b ON pr.pro_branch_id = b.branch_id
    WHERE pr.pro_approved = ?";
            $result8 = $conn->prepare($sql8);
              if($result8->execute(array(1))){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo ' ('.$row8['total_pro'].')';
              } ?></a>
    <?php
      $sql3 = "SELECT DISTINCT branch_id, branch_name FROM branch b 
      INNER JOIN project_request pr ON b.branch_id = pr.pro_branch_id WHERE pr.pro_approved = ?";
      $result3 = $conn->prepare($sql3);
      $result3->execute(array(1));
      if($result3->rowCount()){
        $value3 = $result3->fetchAll(PDO::FETCH_ASSOC);
          /*echo '<pre>';
          echo print_r($value3);
          echo '</pre>';*/
          foreach($value3 as $row3){
            $sql4 = "SELECT pro_id, COUNT(pro_id) total_pro FROM project_request WHERE pro_branch_id = ? AND pro_approved = ? ORDER BY pro_id";
            $result4 = $conn->prepare($sql4);
              if($result4->execute(array($row3['branch_id'], 1))){
                $row4 = $result4->fetch(PDO::FETCH_ASSOC);
                $total_pro = $row4['total_pro'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row4);
                echo'</pre>';*/
                if($row3['branch_id'] == $branch_id){  
                  $black = 'w3-black';
                  }else{
                    $black = '';
                  }
              }
    ?>
    <a href="approved-branch.php?branch_id=<?php echo $row3['branch_id'] ?>" class="w3-button w3-white <?php echo $black; ?>"><?php echo $row3['branch_name'].' ('.$total_pro.')';; ?></a>
    <?php }} ?>
    <a href="add-post.php" class="w3-button w3-white"><i class="fa fa-diamond w3-margin-right"> Add Manually</i></a>
  </div>
</div>
<!-- Filter section end -->

<!-- Conatainer Start -->
<div class="w3-container"><?php 
  $sql6 = "SELECT branch_name FROM branch WHERE branch_id = ?";
  $result6 = $conn->prepare($sql6);
  $result6->execute(array($branch_id));
  if($result6->rowCount()){
    $row6 = $result6->fetch(PDO::FETCH_ASSOC);
  }
  ?>
  <h5>All <?php echo $row6['branch_name']; ?> Projects</h5>
    <!-- Table Start -->
  <table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
    <thead>
      <tr>
          <th>S.No</th>
          <th>Title</th>
          <th>Members</th>
          <th>Action</th>
      </tr>
    </thead>
    <?php
        $sql = "SELECT pro_id, pro_title, stu_id, stu_name, stu_id, stu_rollno, branch_name, pro_branch_id FROM project_request pr
        INNER JOIN student s ON pr.pro_stu_id = s.stu_id
        LEFT JOIN branch b ON b.branch_id = s.stu_branch
        WHERE pro_branch_id = ? AND pr.pro_approved = ?
        ORDER BY pro_id DESC LIMIT ?, ?"; 
        $result = $conn->prepare($sql);
        $result->execute(array($branch_id, 1, $offset, $limit));
        
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
          <td><?php if(isset($row['pro_title'])){ echo $row['pro_title']; } ?></td>
          <?php if(isset($Members)){echo $Members;}  ?>
          <td><a href="add-post.php?pro_id=<?php echo $row['pro_id']; ?>" class="w3-btn w3-green">Add</a></td>
          <?php  $num++; }
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
    WHERE pr.pro_branch_id = ? AND pr.pro_approved = ?";

    $result2 = $conn->prepare($sql2);
    $result2->execute(array($branch_id, 1));
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-grey mx-1"><a href="add-projects-branch.php?branch_id='.$branch_id.'&page='.($page-1).'">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-grey mx-1 '.$active.'"><a href="add-projects-branch.php?branch_id='.$branch_id.'&page='.$i.'" class="w3-blue" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-grey mx-1"><a href="add-projects-branch.php?branch_id='.$branch_id.'&page='.($page + 1).'">Next</a></li>';
      }
      echo '</ul>';
    }
  }
?>

</div>
    <!-- Pagination End -->
</div> 
  <!-- container end -->

<?php include("includes/footer.php"); ?>