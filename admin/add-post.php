<?php 
include 'loginredirect.php';
define('TITLE', 'Add Project');
define('PAGE', 'Add Post');
include("includes/header.php");
include '../config.php'; 

if(isset($_REQUEST['pro_id'])){
  $pro_id = $_REQUEST['pro_id'];
  
  $sql = "SELECT pro_title, pro_desc FROM project_request WHERE pro_id = ?";
  $result = $conn->prepare($sql);
  $result->execute(array($pro_id));
  $row = $result->fetch(PDO::FETCH_ASSOC);
}

if(isset($_REQUEST['add-post'])){
  if(($_REQUEST['title'] !== '') && ($_REQUEST['description'] !== '') && ($_REQUEST['keywords'] !== '') && ($_REQUEST['metadescription'] !== '') && ($_REQUEST['metatitle'] !== '')){
      
    $title = trim($_REQUEST['title']);
    $desc = trim($_REQUEST['description']);
    $metatitle = trim($_REQUEST['metatitle']);
    $keywords = trim($_REQUEST['keywords']);
    $metadesc = trim($_REQUEST['metadescription']);
    $lower = strtolower($title);
    $arr = explode(' ',$lower);
    $slug = implode('-',$arr);

    $sql2 = "INSERT INTO post (post_title, post_desc, post_metatitle, post_keyword, post_metadesc, post_slug) VALUES (?, ?, ?, ?, ?,?)";
    $result2 = $conn->prepare($sql2);
    if($result2->execute(array($title, $desc, $metatitle, $keywords, $metadesc, $slug))){
        echo '<script> location.href = "'.$hostname.'/admin/add-projects.php"; </script>';  
    }
  }else{
    $msg = '<div class="alert alert-danger">Fill all fields</div>';
  }
}
?>

<!-- <script src="../js/ckeditor/ckeditor.js"></script> -->
<script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>

<!-- Header Widget -->
<header class="w3-container" style="padding-top:10px">
    <h5><b><i class="fa fa-dashboard"></i> Add project as post</b></h5>
</header>
<!-- Header widget end -->

<!-- Project Submit Form Start -->
<div class="w3-container">
  <div class="row justify-content-center"><div class="col-md-12 col-sm-12">
      <form action="">
        <div class="w3-section">
          <label for="title">Post Title</label>
          <input type="text" class="w3-input w3-border" id="title" value="<?php if(isset($row['pro_title'])){ echo $row['pro_title']; } ?>" required name="title">
        </div>
      <div class="w3-section">
        <label for="description">Post Summary</label>
        <textarea class="w3-input w3-border" rows="3"  id="description" required name="description"><?php if(isset($row['pro_desc'])){ echo $row['pro_desc']; } ?></textarea>
      </div>
      <h5>For search Engine</h5>
      <div class="w3-section">
          <label for="metatitle">Meta Title <small id="small1">(50 characters)</small></label>
          <input type="text" class="w3-input w3-border" id="metatitle" required name="metatitle">
        </div>
      <div class="w3-section">
        <label for="metadescription">Meta Description <small id="small2">(150 characters)</small></label>
        <textarea class="w3-input w3-border" rows="3"  id="metadescription" required name="metadescription"></textarea>
      </div>
      <div class="w3-section">
        <label for="keywords">Keywords</label>
        <input type="text" class="w3-input w3-border w3-white" id="keywords" required name="keywords">
      </div>
      <br>
      <button type="submit" class="w3-btn w3-center w3-red" name="add-post">Add</button>
    </form><br>
    </div>
    </div>
  </div>

  <script>
    CKEDITOR.replace('description', {
     // width:"500px",
      height:"300px"
    });
    
    const metatitle = document.getElementById('metatitle');
    metatitle.addEventListener('keyup',check1);
    
    const metadesc = document.getElementById('metadescription');
    metadesc.addEventListener('keyup',check);

    function check(e){
      //console.log(e);
      const small = document.getElementById('small2');
      const meta = metadesc.value;
      small.innerHTML = '(' + (150 - meta.length) + ' Characters left)';
      if(meta.length > 150){
        small.setAttribute('style', 'color:red');
      }else{
        small.removeAttribute('style');
      }
    }
    
    function check1(e){
      //console.log(e);
      const small2 = document.getElementById('small1');
      const metati = metatitle.value;
      small2.innerHTML = '(' + (50 - metati.length) + ' Characters left)';
      if(metati.length > 50){
        small2.setAttribute('style', 'color:red');
      }else{
        small2.removeAttribute('style');
      }
    }
    
   </script>
   
<!-- Project Submit Form End -->

<?php include("includes/footer.php"); ?>