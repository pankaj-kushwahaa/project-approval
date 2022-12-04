<?php
include 'loginredirect.php';
define('TITLE', 'Student Dashboard');
define('PAGE', 'Student Dashboard');
include("header.php"); 
include '../config.php';
?>

<header class="w3-container" style="padding-top:10px">
    <h4 class="w3-center" id="welhead"></h4>
</header>

<div class="w3-container">
  <div class="row mt-3 justify-content-center">
    <div class="col-sm-6">
      <table class="w3-table w3-bordered w3-border">
        <thead>
          <tr><th>Name & Roll no.</th><td><?php echo $row2['stu_name'].' '.$row2['stu_rollno']; ?></td></tr>
          <tr><th>Email Id</th><td><?php echo $row2['stu_email']; ?></td></tr>
          <tr><th>Phone number</th><td><?php echo $row2['stu_phone']; ?></td></tr>
          <?php 
            $sql = "SELECT m_name, m_rollno FROM members WHERE m_stu_id = ?";
            $result = $conn->prepare($sql);
            if($result->execute(array($stu_id))){
              if($result->rowCount() > 0){
                $total_member = '<tr><th>Total members</th><td>'.($result->rowCount() + 1).'</td>';
                $members = '<tr><th>Team members</th><td>'.$stu_name.' '.$stu_rollno;
                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                  $members .= '<br>'.$row['m_name'].' '.$row['m_rollno'];
                }
                $members .= '</td></tr>';
              }
            }
          ?>
          <?php if(isset($members)){echo $members;} ?>
          <?php if(isset($total_member)){echo $total_member;} ?>
          <?php
            $sql9 = "SELECT pro_id, pro_title, pro_desc, pro_file, pro_date, pro_approved, pro_app_date, pro_review, pro_comment  FROM project_request 
            WHERE pro_stu_id = ?"; 
            $result9 = $conn->prepare($sql9);
            $result9->execute(array($stu_id));
            if($result9->rowCount() >= 1){
              if($result9->rowCount() == 1){
                $row9 = $result9->fetch(PDO::FETCH_ASSOC);
                echo '<tr><th>Project name</th><td>'.$row9['pro_title'].'</td></tr>';
                if($row9['pro_approved'] == 0 && $row9['pro_review'] == 0){
                  echo '<tr><th>Project status</th><td>Pending</td></tr>'; }
                else if($row9['pro_approved'] == 1 && $row9['pro_review'] == 1){ 
                  echo '<tr><th>Project status</th><td>Approved</td></tr>'; } 
                else if($row9['pro_approved'] == 0 && $row9['pro_review'] == 1){
                  echo '<tr><th>Project status</th><td>Disapproved</th></tr>'; }
              }else{
                $i = 1;
                while($row9 = $result9->fetch(PDO::FETCH_ASSOC)){
                    echo '<tr><th>Project name ('.$i.')</th><td>'.$row9['pro_title'].'</td></tr>';
                    if($row9['pro_approved'] == 0 && $row9['pro_review'] == 0){
                      echo '<tr><th>Project status '.$i.'</th><td>Pending</td></tr>'; }
                    else if($row9['pro_approved'] == 1 && $row9['pro_review'] == 1){ 
                      echo '<tr><th>Project status ('.$i.')</th><td>Approved</td></tr>'; } 
                    else if($row9['pro_approved'] == 0 && $row9['pro_review'] == 1){
                      echo '<tr><th>Project status '.$i.'</th><td>Disapproved</th></tr>'; }
                   $i++;
                  } 
              }
              
                  
                }
              
          
          ?>
        </thead>
      </table>
    </div>
  </div>
</div>


<script>
  // header part
  document.getElementById('welcome').insertAdjacentHTML('beforebegin','<span class="w3-center" id="welspan">Welcome, </span>');
  
      setTimeout(() => {
        document.getElementById('welspan').remove();
      }, 2000);
 
  

  // dashboard
  if(location.search == '?q=w'){
    document.getElementById('welhead').insertAdjacentHTML('afterbegin','<b id="welspan">Welcome, <?php echo $stu_name ?></b>' );
  }
  
  setTimeout(() => {
    document.getElementById('welspan').remove();
    document.getElementById('welhead').insertAdjacentHTML('afterbegin','<b>My Profile</b>');
  }, 2000);
  
  if(location.search !== '?q=w'){
    document.getElementById('welhead').insertAdjacentHTML('afterbegin','<b>My Profile</b>');
  }
</script>

<?php include("footer.php"); ?>