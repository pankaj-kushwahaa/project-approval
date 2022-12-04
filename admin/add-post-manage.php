<?php 
include 'loginredirect.php';
define('TITLE', 'Manage Project');
define('PAGE', 'Manage Post');
include("includes/header.php");
include '../config.php'; 

if(isset($_REQUEST['post_id'])){
  $post_id = $_REQUEST['post_id'];
  
  $sql = "SELECT post_id, post_title, post_desc, post_metatitle, post_metadesc, post_keyword FROM post WHERE post_id = ?";
  $result = $conn->prepare($sql);
  $result->execute(array($post_id));
  $row = $result->fetch(PDO::FETCH_ASSOC);
}

if(isset($_REQUEST['update-post'])){
  if(($_REQUEST['title'] !== '') && ($_REQUEST['description'] !== '') && ($_REQUEST['keywords'] !== '') && ($_REQUEST['metadescription'] !== '') && ($_REQUEST['metatitle'] !== '')){
     
    $postid = $_REQUEST['post-id'];
    $title = trim($_REQUEST['title']);
    $desc = trim($_REQUEST['description']);
    $metatitle = trim($_REQUEST['metatitle']);
    $keywords = trim($_REQUEST['keywords']);
    $metadesc = trim($_REQUEST['metadescription']);
    $lower = strtolower($title);
    $arr = explode(' ',$lower);
    $slug = implode('-',$arr);

    $sql2 = "UPDATE post SET post_title = ?, post_desc = ?, post_metatitle = ?, post_keyword = ?, post_metadesc = ?, post_slug = ? WHERE post_id = ?";
    $result2 = $conn->prepare($sql2);
    if($result2->execute(array($title, $desc, $metatitle, $keywords, $metadesc, $slug, $postid))){
      echo '<script> location.href = "'.$hostname.'/admin/manage-post.php"; </script>';
    }
  }else{
    $msg = '<div class="alert alert-danger">Fill all fields</div>';
  }
}


?>

<!-- Header Widget -->
<header class="w3-container" style="padding-top:10px">
    <h5><b><i class="fa fa-dashboard"></i> Add project as post</b></h5>
</header>
<!-- Header widget end -->
<!--<script src="../js/ckeditor/ckeditor.js"></script>-->
<script src="//cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
<!-- Project Submit Form Start -->
<div class="w3-container">
  <div class="row justify-content-center"><div class="col-md-12 col-sm-12">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="w3-section">
          <label for="title">Post Title</label>
          <input type="text" class="w3-input w3-border" id="title" value="<?php if(isset($row['post_title'])){ echo $row['post_title']; } ?>" required name="title">
        </div>
      <div class="w3-section">
        <label for="description">Post Summary</label>
        <textarea class="w3-input w3-border" rows="3"  id="description" required name="description"><?php if(isset($row['post_desc'])){ echo $row['post_desc']; } ?></textarea>
      </div>
      <h5>For Search Engine</h5>
      <div class="w3-section">
          <label for="metatitle">Meta Title <small id="small1">(50 Characters)</small></label>
          <input type="text" class="w3-input w3-border" id="metatitle" required name="metatitle" value="<?php if(isset($row['post_metatitle'])){ echo $row['post_metatitle']; } ?>">
        </div>
      <div class="w3-section">
        <label for="metadescription">Meta Description <small id="small2">(150 Characters)</small> </label>
        <textarea class="w3-input w3-border" rows="3"  id="metadescription" required name="metadescription"><?php if(isset($row['post_metadesc'])){ echo $row['post_metadesc']; } ?></textarea>
      </div>
      <div class="w3-section">
        <label for="keywords">Keywords</label>
        <input type="text" class="w3-input w3-border w3-white" id="keywords" required name="keywords" value="<?php if(isset($row['post_keyword'])){ echo $row['post_keyword']; } ?>">
        <input type="hidden" name="post-id" value="<?php echo $post_id; ?>">
      </div>
      <br>
      <button type="submit" class="w3-btn w3-center w3-green" name="update-post">Update</button>
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
    check1();
    check();  
    </script>
<!-- Project Submit Form End -->

<?php include("includes/footer.php"); ?>