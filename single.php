<?php
include 'config.php';

if(isset($_REQUEST['post'])){
  $post_slug = $_REQUEST['post'];

  $sql = "SELECT post_id, post_title, post_desc, post_metadesc, post_metatitle, post_slug, post_keyword FROM post WHERE post_slug = ?";
  $result = $conn->prepare($sql);
  $result->execute(array($post_slug));
  if($result->rowCount() > 0){
    $row = $result->fetch(PDO::FETCH_ASSOC);
    /*echo '<br><br><pre>';
    echo print_r($row);
    echo '</pre>';*/
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="<?php echo $row['post_keyword']; ?>">
<meta name="description" content="<?php echo $row['post_metadesc']; ?>">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/w3css.css">
<link rel="stylesheet" href="css/style.css">
<style>
  iframe{
  width:100%;
  height:542px;
  }
  
  video{
    width:100%;
    height:542px;
  }
  
  .container-fluid .row .w3-white p img{
    width:100%;
    height: 100%;
  }
  
  .title-size{
      font-size:28px;
  }
  
  .desc-size{
     font-size:20px;
  }
  
  @media screen and (max-width:500px){
    iframe{
      width:100%;
      height:240px;
    }
    
    video{
      width:100%;
      height:240px;
    }
    .container-fluid .row .w3-white p img{
      width:100%;
      height: 100%;
    }
    
    .title-size{
      font-size:24px;  
    }
    
    .desc-size{
        font-size:16.7px;
    }
    
  
  }
</style>
<title><?php echo $row['post_metatitle'];  ?></title>
</head>
<body>

<!-- Header -->
<header class="w3-container w3-theme w3-margin-top w3-padding" id="myHeader">
  <div class="w3-center">
    <h4>Coding is today's language of creativity</h4>
    <h1 class="w3-xxlarge w3-animate-bottom sm">Approve Your Project</h1>
  </div>

  <div class="w3-padding-16 w3-center">      
      <a href="<?php echo $hostname; ?>" class="w3-btn w3-xlarge w3-red w3-hover-light-grey shadow-btn" style="font-weight:900;" >Home</a>
    </div>
</header>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-sm-12 col-md-8 w3-white">
      <h2 style="display:inline-block;" class="p-3 title-size"><?php echo $row['post_title'];  ?></h2>
      <button class="w3-button w3-white w3-border w3-round-large w3-border-blue"  id="share-btn">SHARE</button><hr>
      <div class="p-3 desc-size" style="text-align:justify;"><?php echo $row['post_desc'];  ?></div>
    </div>
  </div>
</div>
<?php 
 $sql56 = "SELECT post_id, post_title, post_desc, LEAD(post_slug, 1) OVER (ORDER BY post_slug DESC) AS next_post FROM post";
 $result56 = $conn->prepare($sql56);
$result56->execute();
 if($result56->rowCount() > 0){
   $row56 = $result56->fetchAll(PDO::FETCH_ASSOC);
   /*echo '<br><br><pre>';
   echo print_r($row56);
   echo '</pre>';*/
   foreach($row56 as $value){
   /* echo '<br><br><pre>';
   echo print_r($value);
   echo '</pre>';*/
   if($value['post_title'] == $row['post_title']){
      $next_post = $value['next_post'];
    }
   }
   
 } else{
  echo 'no values';
 }
?>
<?php }} ?>

<?php
$sql13 = "SELECT post_id, post_title, post_desc, post_slug FROM post WHERE post_slug = ?";
$result13 = $conn->prepare($sql13);
$result13->execute(array($next_post));
if($result13->rowCount() > 0){
  $row13 = $result13->fetch(PDO::FETCH_ASSOC);
  /*echo '<br><br><pre>';
  echo print_r($row13);
  echo '</pre>';*/
?>
<div class="container-fluid my-5">
  <div class="row justify-content-center">
    <div class="col-sm-12 col-md-8 w3-white">
      <div class="card">
        <h4 class="card-header"> <a href="single.php?post=<?php echo $row13['post_slug']; ?>" style="text-decoration:none;"><?php echo $row13['post_title']; ?></a></h4>
        <div class="card-body">
          <p class="card-text" style="font-size:15px"><?php echo substr($row13['post_desc'], 0, 100).'...'; ?></p>
          <a href="single.php?post=<?php echo $row13['post_slug']; ?>" class="w3-btn w3-orange" style="font-size:15px">READ</a>
        </div>
      </div>
    </div>
<?php } ?>

  </div>
</div>
<!-- bootsrap card end -->




<noscript>Enable JavaScript to access this application.</noscript>
<script>`use strict`;

document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
})
   
   shareData = {
    title: document.querySelector('title').innerText,
    url: location.href
    }

document.getElementById('share-btn').addEventListener('click', async () => {
  try{ 
      await navigator.share(shareData)  }catch(err){ 
    console.log(err);
	  //document.getElementsByTagName("p")[0].innerHTML = err; 
	  }
})



</script>

<footer>
  <div class="w3-container w3-dark-grey w3-large">
    <h5 style="text-align:center;"> <a href="adminlogin.php" style="text-decoration:none;">Copyright</a> &copy; 2022</h5> 
 </div>
</footer>

<!-- Bootstrap JS File -->
<script src="js/bootstrapbundle.js"></script>
<!-- FontAwesome JS File -->
<script src="js/fontawesome.js"></script>
</body>
</html>
