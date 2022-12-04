<?php
include 'loginredirect.php';
define('TITLE', 'Manage Files');
define('PAGE', 'Manage Files');
include("includes/header.php"); 

if(isset($_REQUEST['upload'])){
  if(!empty($_FILES['file']['name'])){
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_size_MB = round(($file_size/1024)/1024,3);
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];

    /*echo '<br><br><br><pre>';
    echo print_r($_FILES['file']);
    echo '</pre>';*/

    $errors = array();

    if($file_size > 26214400){
      $errors[] = "File size must be less than 25 MB";
    }
    $sql4 = "SELECT file_name FROM file WHERE file_name = ?";
    $result4 = $conn->prepare($sql4);
    $result4->execute(array($file_name));
    if($result4->rowCount() > 0){
      $errors[] = "File name already exists";
    }

    $target = "../upload/".$file_name;

    if(empty($errors) == TRUE){
      $sql = "INSERT INTO file (file_name, file_size) VALUES (?,?)";
      $result = $conn->prepare($sql);
      $result->execute(array($file_name, $file_size_MB));
      move_uploaded_file($file_tmp, $target);
      $msg = '<div class="alert alert-success emp">Uploaded Successfully</div>';
    }else{
      $msg = '';
        foreach($errors as $error_msg){
          $msg .= '<div class="alert alert-danger emp">'.$error_msg.'</div>';
        }
    }
  }else{
    $msg = '<div class="alert alert-danger emp">Select a file</div>';
  }
}

if(isset($_REQUEST['file_btn'])){
  $file_id = $_REQUEST['file_id'];
  $file_name = $_REQUEST['file_name'];
  $sql3 = "DELETE FROM file WHERE file_id = ?";
  $result3 = $conn->prepare($sql3);
  if($result3->execute(array($file_id))){
    unlink('../upload/'.$file_name);
    $msg = '<div class="alert alert-success emp">Deleted</div>';
  }
}
?>
<header class="w3-container" style="padding-top:10px">
    <h5><b><i class="fa fa-file"></i> Manage files</b></h5>
</header>
<div class="w3-container">
  <div class="row mt-2">
    <div class="col-md-4 col-sm-4">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" id="form">
        <label for="file">Upload &nbsp; <small>Note : File size must be less than 25 MB and File type should be any of the following Image, Audio, Video, Pdf, Docx & PPT </small></label>
        <input type="file" name="file" id="file" class="w3-input w3-white">
        <input type="hidden" name="upload" value="">
        <button type="submit" class="w3-btn w3-center w3-green m-1" name="upload" id="up">Upload</button>
      </form><br>
      <?php if(isset($msg)){echo $msg;} ?>
      <h6 id="embed">Embed video</h6>
      <p>&lt;video&nbsp;width=&quot;&quot;&nbsp;height=&quot;&quot;&nbsp;controls&gt;<br />
&nbsp;&nbsp;&lt;source&nbsp;src=&quot;movie.mp4&quot;&nbsp;type=&quot;video/mp4&quot;&gt;<br />
Your browser does not support the video tag.<br />
&lt;/video&gt;</p>
<hr>
<h6>Embed Youtube videos</h6>
<p>&lt;iframe <span style="color:blue">height=&quot;345&quot;</span> src=&quot;<span style="color:red">https://www.youtube.com/embed/</span>...Video playback ID...<span style="color:red">;loop=1&quot;</span> <span style="color:blue">width=&quot;420&quot;</span>&gt;&lt;/iframe&gt;</p>
<hr>
<h6>Embed audio</h6>
<p>&lt;audio&nbsp;controls&gt;<br />
&nbsp;&nbsp;&lt;source&nbsp;src=&quot;horse.mp3&quot;&nbsp;type=&quot;audio/mpeg&quot;&gt;<br />
Your browser does not support the audio element.<br />
&lt;/audio&gt;</p>
<hr>
<h6>Embed link</h6>
<p>&lt;a&nbsp;href=&quot;&quot;&nbsp;target=&quot;_blank&quot;&gt;File name&lt;/a&gt;</p>
<br><br><br>
      
    </div>
    <div class="col-md-6 col-sm-6">
    <table class="w3-table w3-bordered w3-border w3-white">
      <thead>
        <tr>
          <th>S.No</th>
          <th>File</th>
          <th>Size (MB)</th>
          <th>Delete</th>
          <th>View</th>
        </tr>
      </thead>
      <tbody>
          <?php 
            $sql2 = "SELECT * FROM file";
            $result2 = $conn->prepare($sql2);
            $result2->execute();
            if($result2->rowCount()){
              $n = 1;
              while($row2 = $result2->fetch(PDO::FETCH_ASSOC)){
          ?>
        <tr>
          <td><?php echo $n; ?></td>
          <td>upload/<?php echo $row2['file_name']; ?></td>
          <td><?php if(isset($row2['file_size'])){$num =  round($row2['file_size'], 2); echo $num; } ?></td>
          <td><form action="" method="post"><input type="hidden" name="file_name" value="<?php echo $row2['file_name']; ?>"><input type="hidden" name="file_id" value="<?php echo $row2['file_id']; ?>"><button type="submit" class="w3-btn" name="file_btn"><i class="fa-solid fa-trash"></i></button></form></td>
          <td><a href="<?php echo '../upload/'.$row2['file_name']; ?>" class="w3-btn"><i class="fa-solid fa-eye"></i></a></button></td>
          </tr>
          <?php $n++; } }else{
            $no = '<td>No records</td>';
          } ?>
          
          <?php if(isset($no))echo $no; ?>
    </tbody>
  </table>
    </div>
  </div>
</div>
<noscript>Enable JavaScript to access this application</noscript>
<script>

  document.getElementById('up').addEventListener('click', (e) => {
    e.preventDefault();
    if(document.getElementById('file').value){

      var files = document.getElementById('file').files;
      var file_name = files[0].name;
      var file_size = files[0].size;
      var file_type = files[0].type;
      var file_arr = file_name.split('.');
      var file_ext = file_arr[file_arr.length-1];

      var file_extensions = ['jpeg', 'JPEG', 'png', 'PNG', 'jpg', 'JPG','gif','GIF', 'mp3', 'MP3', 'mp4','MP4', 'docx','DOCX','xlsx','XLSX','ppt','PPT','pptx','PPTX','pdf','PDF'];

      var errors = new Array();
      if(!file_extensions.includes(file_ext)){
        errors[0] = 'This file extension is not allowed';
      }

      if(file_size > 26214400){
        errors[1] = 'File size must be less than 25 MB';
      }
      
      if(errors.length == 0){
        document.getElementById('form').submit();
      }else{
        var msg = '';
        errors.forEach( (value) => {
          msg += '<div class="alert alert-danger em">'+value+'</div>';
        });
        document.getElementById('embed').insertAdjacentHTML('beforebegin', msg);
        Remove();
      }
      
    }else{
      document.getElementById('embed').insertAdjacentHTML('beforebegin', '<div class="alert alert-danger em">Select a file</div>');
      Remove();
    }
  });

  if(document.querySelectorAll('.emp')){
    setTimeout(() => {
      document.querySelectorAll('.emp').forEach( (value) => {
        value.remove();
      });
    }, 5000);
  }

  function Remove(){
    setTimeout(() => {
      document.querySelectorAll('.em').forEach( (value) => {
        value.remove();
      });
    }, 5000);
  }

</script>
<?php include "includes/footer.php"; ?>