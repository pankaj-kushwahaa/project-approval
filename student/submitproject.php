<?php 
include 'loginredirect.php';
define('TITLE', 'Submit Project for Approval');
define('PAGE', 'submitproject');
include("header.php"); 
include '../config.php';

$date = date('d M Y');

if(isset($_POST['submit_project'])){
  if(($_POST['title'] !== '') && ($_POST['description'] !== '') && isset($_FILES['file']['name'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
      
    // File Code start
      $errors = array();
      /*echo '<pre>';
      echo print_r($_FILES);
      echo '</pre>';*/    
      $file_name = $_FILES['file']['name'];
      $file_size = $_FILES['file']['size'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $file_type = $_FILES['file']['type'];
      $ext = explode('.', $file_name);
      $file_ext = end($ext);
      $extensions = array('pptx', 'PPTX','pdf', 'PDF', 'ppt', 'PPT', 'docx', 'DOCX');
    
      if(in_array($file_ext, $extensions) === FALSE){
        $errors[] = "This extension file is not allowed, Please choose a .pptx or .pdf file";
      }
    
      if($file_size > 1024000){
        $errors[] = "File size must be less than 1 MB";
      }

      $new_name = time().'--'.basename($file_name);
      $name_current = "upload/".$new_name;
      $target = $name_current;
    
      if(empty($errors) == TRUE){
        $sql = "INSERT INTO project_request (pro_title, pro_desc, pro_file, pro_stu_id, pro_branch_id, pro_review, pro_approved, pro_comment, pro_date, pro_app_date) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $result = $conn->prepare($sql);
        if($result->execute(array($title, $desc, $new_name, $stu_id, $stu_branch, 0, 0, "empty", $date, 0))){
          $sql = "UPDATE branch SET total_pro_req = total_pro_req + ? WHERE branch_id = ?";
          $result = $conn->prepare($sql);
          if($result->execute(array(1, $stu_branch))){
            move_uploaded_file($file_tmp, $target);
            echo '<script>location.href = "'.$hostname.'/student/projectstatus.php";</script>';
            //header("Location: {$hostname}/student/projectstatus.php");
          }else{
            $msg = '<div class="alert alert-danger">Due to some technical issue, file cannot be upload. Contact developer</div>';
          }
        }
      }else{
        /*echo '<pre>';
        echo print_r($errors);
        echo '</pre>';
        echo $file_size;*/
        $msg = '';
        foreach($errors as $error_msg){
          $msg .= '<div class="alert alert-danger emp">'.$error_msg.'</div>';
        }
      }  
  }else{
    $msg = '<div class="alert alert-danger emp">Fill All Fields</div>';
  }
}
?>

<header class="w3-container" style="padding-top:10px">
    <h4 class="w3-center"><b>Submit project for approval</b></h4>
    <?php if(isset($msg)){ echo $msg; } ?>
</header>

<!-- Project Submit Form Start -->
<div class="w3-container">
  <div class="row justify-content-center"><div class="col-md-12 col-sm-12">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="form">
        <div class="w3-section">
          <label for="title">Title</label>
          <input type="text" class="w3-input w3-border" id="title" required name="title">
        </div>
        <div class="w3-section">
          <label for="description">Summary</label>
          <textarea class="w3-input w3-border" rows="10"  id="description" required name="description"></textarea> 
        </div>
        <div class="w3-section">
          <label for="file">PPT</label>&nbsp;&nbsp;<small id="embed">Note : File extension should be (.ppt, .pptx, .docx or .pdf) and size less than 500 KB</small>
          <input type="file" class="w3-input w3-border w3-white" id="file" required name="file">
          <input type="hidden" name="submit_project">
        </div><br>
        <button type="submit" class="w3-btn w3-center w3-red" name="submit_project" id="up">Submit</button><br>
      </form>
    </div>
  </div>
</div><br><br><br>
<!-- Project Submit Form End -->
<script>
  document.getElementById('up').addEventListener('click', (e) => {
    e.preventDefault();
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;
    if(title != '' && description != '' && document.getElementById('file').value){

      var files = document.getElementById('file').files;
      var file_name = files[0].name;
      var file_size = files[0].size;
      var file_type = files[0].type;
      var file_arr = file_name.split('.');
      var file_ext = file_arr[file_arr.length-1];

      var file_extensions = ['docx','DOCX','ppt','PPT','pptx','PPTX','pdf','PDF'];

      var errors = new Array();
      if(!file_extensions.includes(file_ext)){
        errors[0] = 'This file extension is not allowed';
      }

      if(file_size > 1024000){
        errors[1] = 'File size must be less than 1 MB';
      }
      
      if(errors.length == 0){
        document.getElementById('form').submit();
      }else{
        var msg = '';
        errors.forEach( (value) => {
          msg += '<div class="alert alert-danger em">'+value+'</div>';
        });
        document.getElementById('embed').insertAdjacentHTML('afterend', msg);
        Remove();
      }
      
    }else{
      document.getElementById('embed').insertAdjacentHTML('afterend', '<div class="alert alert-danger em">Fill all fields</div>');
      Remove();
    }
  });

function Remove(){
    setTimeout(() => {
      document.querySelectorAll('.em').forEach( (value) => {
        value.remove();
      });
    }, 5000);
  }

  if(document.querySelectorAll('.emp')){
    setTimeout(() => {
      document.querySelectorAll('.emp').forEach( (value) => {
        value.remove();
      });
    }, 5000);
  }

</script>

<?php include("footer.php"); ?>