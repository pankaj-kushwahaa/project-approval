<?php
include 'loginredirect.php'; 
define('TITLE', 'Enquery Page'); 
define('PAGE', 'enquery');
include("header.php"); 

include '../config.php';

if(isset($_REQUEST['enquerySubmit']) && ($_REQUEST['enquery'] !== '')){
  $enquery = trim($_REQUEST['enquery']);
  $user_date = date('d M Y, H : i');
  echo '<br><br>'.$enquery.' '.$user_date;
  $sql = "INSERT INTO enquery (en_stu_id, en_branch_id, en_user, en_user_date, en_admin_id, en_reply, en_reply_date, en_review) VALUES (?,?,?,?,?,?,?,?)";
  $result = $conn->prepare($sql);
  if($result->execute([$stu_id, $stu_branch, $enquery, $user_date, 0, 0, 0,0])){
    $msg = '<script>location.href = "'.$hostname.'/student/enquery.php"</script>';  
  }
}
?>

<header class="w3-container" style="padding-top:10px">
    <h4><b>Enquery</b></h4>
</header>

<div class="container">
  <div class="row d-flex flex-row">
    <div class="col-sm-10 mt-2 mx-2">
      <form action="" method="post">
      <div class="form-group">
        <label for="enquery">Write your message</label>
        <textarea type="text" name="enquery" id="enquery" class="w3-input my-2" rows="2"></textarea>
        <input type="submit" value="Send" class="w3-btn w3-green" name="enquerySubmit">
      </div>
      </form>
      <?php if(isset($msg)){echo $msg; } ?>
    </div>
  </div>
  
  <div class="row">
    <div class="col-sm-10 my-2 mt-2">
      <div class="card">
        <div class="card-header">
          <h5>Messages</h5>          
        </div>
        <div class="card-body" style="overflow-y:scroll; height:50vh;">
          <?php 
            $sql2 = "SELECT * FROM enquery WHERE en_stu_id = ?";
            $result2 = $conn->prepare($sql2);
            $result2->execute([$stu_id]);
            while($row2 = $result2->fetch(PDO::FETCH_ASSOC)){
              /*echo '<pre>';
              echo print_r($row2);
              echo '</pre>';*/
          ?>
          
            <p style="text-align:right"><small><?php if($row2['en_user_date'] != 'empty'){echo $row2['en_user_date'];} ?></small><br><span style="text-align:right" class="card-text w3-pale-green"><?php if($row2['en_user'] != 'empty'){echo $row2['en_user'];} ?><input type="hidden" name="" value="<?php echo $row2['en_id']; ?>" id="del-user"> <label for="del-user" id="del-btn-user" style="cursor:pointer;"><i class="fa-solid fa-trash mx-1 cl"></i></label> </span> </p>
           
            <?php if($row2['en_reply'] != 0){ ?>
              <p style="text-align:left"><small><?php if($row2['en_reply_date']){echo $row2['en_reply_date'];} ?></small><br><span style="text-align:right" class="card-text w3-pale-yellow"> <?php if($row2['en_reply']){echo $row2['en_reply'];} ?></span></p>

          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if(document.getElementById('doc')){
    setTimeout(() => {
      document.getElementById('doc').remove();
    }, 1500);
  }
});

  for(let i = 0 ; i < document.querySelectorAll("input[type=hidden]").length ; i++){
     console.log(document.querySelectorAll("input[type=hidden]"));
     console.log(document.querySelectorAll('.cl'));
     console.log(document.querySelectorAll('.cl')[i]);
     
    document.querySelectorAll('.cl')[i].addEventListener('click', () => {
    const del_user = document.querySelectorAll("input[type=hidden]")[i].value;
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

<?php include "footer.php"; ?>
