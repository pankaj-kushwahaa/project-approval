<?php include_once 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
<title>Error Page</title>
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
    <div class="col-sm-12 col-md-8">
    <h2>Sorry!<br>
We can't seem to find the resource you're looking for</h2>
    </div>
  </div>
</div>
<!-- bootsrap card end -->

<noscript>Enable JavaScript to access this application.</noscript>

<!-- Bootstrap JS File -->
<script src="js/bootstrapbundle.js"></script>
<!-- FontAwesome JS File -->
<script src="js/fontawesome.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer[0].remove();
   }  
});
</script>
</body>
</html>