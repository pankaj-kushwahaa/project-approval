<?php 
include 'loginredirect.php';
define('TITLE', 'Enquery');
define('PAGE', 'Enquery');
include("includes/header.php"); 
include '../config.php';

if(isset($_REQUEST['en_id'])){
$en_id = $_REQUEST['en_id'];
}

if(isset($_REQUEST['Send']) && ($_REQUEST['reply'] !== '')){
  $reply = trim($_REQUEST['reply']);
  $reply_date = date('d M Y, H : i');
  $sql4 = "UPDATE enquery SET en_reply = ?, en_reply_date = ?, en_review = ?, en_admin_id = ? WHERE en_id = ?";
  $result4 = $conn->prepare($sql4);
  if($result4->execute(array($reply, $reply_date, 1, $s_role, $en_id))){
    $print = '<script>location.href = "'.$hostname.'/admin/enquery-page.php?en_id='.$en_id.'"</script>';
    echo $print;
  }
}

if(isset($_REQUEST['delall'])){
  $en_stu_id = $_REQUEST['del-all'];
  $sql1 = "DELETE FROM enquery WHERE en_stu_id = ?";
  $result1 = $conn->prepare($sql1);
  if($result1->execute(array($en_stu_id))){
    echo '<script>location.href = "'.$hostname.'/admin/student-enquery.php";</script>';
  }
}


$sql = "SELECT en_id, en_user, en_user_date, en_stu_id, en_branch_id FROM enquery 
WHERE en_id = ?";
$result = $conn->prepare($sql);
$result->execute(array($en_id));
if($result->rowCount() > 0){
  $row = $result->fetch(PDO::FETCH_ASSOC);

  $sql5 = "SELECT stu_name, stu_rollno FROM student WHERE stu_id = ?";
  $result5 = $conn->prepare($sql5);
  $result5->execute(array($row['en_stu_id']));
  $row5 = $result5->fetch(PDO::FETCH_ASSOC);


  //fetching members name from stu_id
  $sql3 = "SELECT m_name, m_rollno FROM members WHERE m_stu_id = ?";
  $result3 = $conn->prepare($sql3);
  $result3->execute(array($row['en_stu_id']));
  //$row3 = $result3->fetchAll(PDO::FETCH_ASSOC);
  if($result3->rowCount()){
    $Members = '';
    $Members .= $row5['stu_name'].' '.$row5['stu_rollno'];
    while($row3 = $result3->fetch(PDO::FETCH_ASSOC)){
    $Members .= ', '.$row3['m_name'].' '.$row3['m_rollno'];
    } 
    $Members .= '';
  }else{
    $Members = $row5['stu_name'].' '.$row5['stu_rollno'];
  }

//echo '<br><br><br>'.$Members;
?>
<br>
<div class="container">
  <div class="row d-flex flex-row">
    <div class="col-sm-10 my-2 mx-2 mt-2">
      <div class="card">
        <div class="card-header">
          <h5><?php echo $Members;  ?> <form action="" style="display:inline;float:right;"><input type="hidden" name="del-all" value="<?php echo $row['en_stu_id'];  ?>"><button type="submit" name="delall">Delete All</button></form> </h5>          
        </div>
        <div class="card-body" style="overflow-y:scroll; height:60vh;">
          <?php 
            $sql2 = "SELECT en_id, en_user, en_user_date, en_reply, en_reply_date FROM enquery WHERE en_stu_id = ?";
            $result2 = $conn->prepare($sql2);
            $result2->execute(array($row['en_stu_id']));
            $value = $result2->fetchAll(PDO::FETCH_ASSOC);
            foreach($value as $row2){

           /* echo '<pre>';
            echo print_r($row2);
            echo '</pre>';*/
          ?>
              <p style="text-align:left"><small><?php if($row2['en_user_date']){echo $row2['en_user_date'];} ?></small><br><span style="text-align:right" class="card-text w3-pale-green"><?php if($row2['en_user']){echo $row2['en_user'];} ?></span></p>
            
            <?php if($row2['en_reply'] != 0){ ?>
              <p style="text-align:right"><small><?php if($row2['en_reply_date']){echo $row2['en_reply_date'];} ?></small><br><span style="text-align:right" class="card-text w3-pale-yellow"> <?php if($row2['en_reply']){echo $row2['en_reply'];} ?><input type="hidden" value="<?php echo $row2['en_id']; ?>" class="del-btn"> <label for="del-user" id="del-btn-user" style="cursor:pointer;"><i class="fa-solid fa-trash mx-1 cl"></i></label></span></p>

       <?php } }}?>
        </div>
      </div><br>
      <form action="<?php echo $_SERVER['PHP_SELF'].'?en_id='.$en_id; ?>" method="post">
        <input type="text" name="reply" class="w3-input" placeholder="Reply...">
        <input type="submit" value="Send" name="Send" class="w3-btn w3-green">
      </form>
    </div>
  </div>
</div>
<script>
  console.log(document.querySelectorAll(".del-btn"));
for(let i = 0 ; i < document.querySelectorAll(".del-btn").length ; i++){
  document.querySelectorAll('.cl')[i].addEventListener('click', () => {
  const del_user = document.querySelectorAll(".del-btn")[i].value;
  xhr = new XMLHttpRequest();
  xhr.responseType = 'text';
  xhr.open("POST", "ajax.php");
  xhr.onload = () => {
    if(xhr.status == 200){
    
      if(xhr.responseText == 1){
      location.reload(); 
      }
    }
  }
  const mydata = {del:del_user};
  const data = JSON.stringify(mydata);
  console.log(data);
  xhr.send(data);
});
}
</script>

<?php include("includes/footer.php"); ?>