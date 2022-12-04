<?php 
include 'loginredirect.php';
define('TITLE', 'Enquery');
define('PAGE', 'Enquery');
include("includes/header.php"); 
include '../config.php';

$limit = 5;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;
?>
<!-- Filter Section start-->
<div class="w3-container">
  <div class="w3-section w3-bottombar w3-padding-16">
    <span class="w3-margin-right">Filter:</span> 
    <a href="student-enquery.php" class="w3-button w3-black">All Enqueries
<?php $sql8 = "SELECT DISTINCT en_stu_id, COUNT(en_stu_id) total_en FROM enquery e INNER JOIN branch b ON e.en_branch_id = b.branch_id GROUP BY en_stu_id HAVING COUNT(en_stu_id) >= ?";
            $result8 = $conn->prepare($sql8);
            $result8->execute([1]);
              if($rownum = $result8->rowCount() > 0){
                $row8 = $result8->fetch(PDO::FETCH_ASSOC);
                $total_pro1 = $row8['total_en'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row8);
                echo'</pre>';*/
                echo ' ('.$row8['total_en'].')';
              } ?></a>
    <?php
      $sql3 = "SELECT DISTINCT b.branch_id, b.branch_name FROM branch b 
      INNER JOIN enquery e ON b.branch_id = e.en_branch_id";
      $result3 = $conn->prepare($sql3);
      $result3->execute();
      if($result3->rowCount()){
        $value3 = $result3->fetchAll(PDO::FETCH_ASSOC);
          /*echo '<pre>';
          echo print_r($value3);
          echo '</pre>';*/
          foreach($value3 as $row3){
            $sql4 = "SELECT DISTINCT COUNT(en_stu_id) total_en FROM enquery WHERE en_branch_id = ? GROUP BY en_branch_id HAVING COUNT(en_stu_id) >= ?";
            $result4 = $conn->prepare($sql4);
              if($result4->execute(array($row3['branch_id'],1))){
                $row4 = $result4->fetch(PDO::FETCH_ASSOC);
                $total_en = $row4['total_en'];
                /*echo '<br><br><Br><pre>';
                echo print_r($row4);
                echo'</pre>';*/
              }
    ?><a href="enquery-branch.php?branch_id=<?php echo $row3['branch_id'] ?>" class="w3-button w3-white"><?php echo $row3['branch_name'].' ('.$total_en.')'; ?></a>

    <?php }} ?></a>
  </div>
</div>
<!-- Filter section end -->

<div class="w3-container">
  <div class="row">
    <div class="col-sm-10 my-2 mt-2">
      <div class="card">
        <div class="card-header">
          <h5>All Enqueries</h5>          
        </div>
        <div class="card-body">
          <!-- Chat person start -->
<?php
  $sql = "SELECT DISTINCT en_stu_id, stu_name, stu_rollno, stu_img FROM enquery e
  INNER JOIN student s ON s.stu_id = e.en_stu_id ORDER BY en_id DESC LIMIT ?, ?"; 
  $result = $conn->prepare($sql);
  $result->execute(array($offset, $limit));

  if($result->rowCount()){
    $i = 1;
    $num = $offset + 1;
    $value = $result->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<br><br><Br><pre>';
                echo print_r($value);
                echo'</pre>';*/
    foreach($value as $row){
    ?>

    <?php  
      $sql1 = "SELECT m_name, m_rollno FROM members WHERE m_stu_id = ?";
      $result1 = $conn->prepare($sql1);
      $result1->execute(array($row['en_stu_id']));
      
      if($result1->rowCount()){
        $Members = '';
        $Members .= $row['stu_name'].' '.$row['stu_rollno'];
        while($row1 = $result1->fetch(PDO::FETCH_ASSOC)){
        $Members .= ', '.$row1['m_name'].' '.$row1['m_rollno'];
        } 
        $Members .= '';
      }else{
        $Members = $row['stu_name'].' '.$row['stu_rollno'];
      }
      /*echo '<pre>';
      echo print_r($row);
      echo '</pre>';*/
      $sql5 = "SELECT en_id, en_user, en_user_date FROM enquery WHERE en_stu_id = ? ORDER BY en_id DESC";
      $result5 = $conn->prepare($sql5);
      $result5->execute(array($row['en_stu_id']));
      $row5 = $result5->fetch(PDO::FETCH_ASSOC);
     
      /*echo '<pre>';
      echo print_r($row5);
      echo '</pre>';*/
    
    ?>
          <a href="enquery-page.php?en_id=<?php echo $row5['en_id'] ?>" class="" style="text-decoration:none;">
            <div class="w3-section">
              <div class="row">
                <div class="col-3 col-md-1">
                  <?php if($row['en_stu_id']){} ?>
                  <img src="<?php if($row['stu_img'] !== 'image'){ echo '../student/profilepic/'.$row['stu_img'];}else{echo '../student/profilepic/projectpic.png'; } ?>" alt="Display Picture" class="w3-circle" style="width:75px;height:75px;">
                </div>
                <div class="col-9 col-md-11">
                  <div class="row">
                    <div class="col-12">
                      <span><?php if($Members){ echo $Members; } ?></span> (<?php echo $row3['branch_name']; ?>) <small class="w3-right"><em><?php if($row5['en_user_date']){ echo $row5['en_user_date']; } ?></em></small><br>
                      <small class="card-text"><?php if($row5['en_user']){ echo substr($row5['en_user'],0, 75).'...'; } ?></small>
                    </div>
                  </div>
                </div>
              </div><hr>  
              <?php }}else{ echo '<div class="alert alert-warning">No messages</div>'; } ?>           
            </div>
          </a>
          <!-- Chat persone end -->
        </div>
      </div>
    </div>
  </div>

   <!-- Pagination Start -->
<div class="w3-row pagination">
  <?php
    $sql2 = "SELECT DISTINCT en_stu_id FROM enquery";

    $result2 = $conn->prepare($sql2);
    $result2->execute();
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-grey mx-1"><a href="student-enquery.php?page='.($page-1).'">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-grey mx-1 '.$active.'"><a href="student-enquery.php?page='.$i.'" class="w3-blue" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-grey mx-1"><a href="student-enquery.php?page='.($page + 1).'">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
</div>



<?php include("includes/footer.php"); ?>