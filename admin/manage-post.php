<?php 
include 'loginredirect.php';
define('TITLE', 'Manage Project');
define('PAGE', 'Manage Post');
include("includes/header.php");
include '../config.php'; 

// Pagination code
$limit = 5;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;

if(isset($_REQUEST['delete-post'])){
  $post_id = $_REQUEST['del-post'];
  $sql1 = "DELETE FROM post WHERE post_id = ?";
  $result1 = $conn->prepare($sql1);
  if($result1->execute(array($post_id))){
    echo '<script>location.href = "'.$hostname.'/admin/manage-post.php"</script>';
  }
}

?>

<header class="w3-container" style="padding-top:10px">
    <h5><b><i class="fa fa-dashboard"></i> Manage posts</b></h5>
</header>
  
<div class="w3-container">
  <table class="w3-table w3-bordered w3-border w3-white mt-2">
    <thead>
      <tr>
          <th>S.No</th>
          <th>Title</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody> 
    <?php
      $sql6 = "SELECT * FROM post ORDER BY post_id DESC LIMIT ?, ?";
      $result6 = $conn->prepare($sql6);
      $result6->execute(array($offset, $limit));
      if($result6->rowCount() > 0){
        $num = 1;
        while($row6 = $result6->fetch(PDO::FETCH_ASSOC)){
    ?>

    <tr><td><?php echo $num; ?></td>
      <td><?php echo substr($row6['post_title'], 0 ,30).'..'; ?></td>
      <td><a href="add-post-manage.php?post_id=<?php echo $row6['post_id']; ?>" class="w3-btn"><i class="fa-solid fa-edit"></i></a>
      <label for="modalbox" id="modal-label<?php echo $row6['post_id']; ?>" class="w3-btn"><i class="fa-solid fa-trash"></i></label>
          <!-- Custom modal box -->
            <div class="cus-modal" id="modalbox<?php echo $row6['post_id']; ?>">
              <div class="cus-modal-box">
                <h5 style="display:inline">Confirm ?</h5><span style="float:right;" id="modal-span" onclick="document.getElementById('modalbox<?php echo $row6['post_id']; ?>').style.display='none'" >x</span><hr>
                <p>Do you want to delete ?</p>
                <!-- Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="display:inline">
                  <input type="hidden" name="del-post" value="<?php echo $row6['post_id']; ?>">
          <!-- End Form -->
                <button type="submit" class="btn w3-green w3-btn" name="delete-post"> Delete</button></form>
                <button class="btn w3-grey w3-btn" onclick="document.getElementById('modalbox<?php echo $row6['post_id'] ?>').style.display='none'">Close</button>
              </div>
            </div>
            <script>
              document.getElementById('modal-label<?php echo $row6['post_id']; ?>').addEventListener('click', () => {
                document.getElementById('modalbox<?php echo $row6['post_id']; ?>').style.display = 'block';
                (this).preventDefault();
              });
            </script></td>
    </tr>

<?php $num++; }}else{ echo '<tr><td><h5>No posts</h5></td></tr>'; } ?>
    </tbody>
    </table>
            </div>
            <br>


        <!-- Pagination Start -->
<div class="w3-row pagination">
  <?php
    $sql2 = "SELECT post_id FROM post";

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
        echo '<li class="w3-button w3-grey mx-1"><a href="manage-post.php?page='.($page-1).'">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-grey mx-1 '.$active.'"><a href="manage-post.php?page='.$i.'" class="w3-blue" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-grey mx-1"><a href="manage-post.php?page='.($page + 1).'">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
    <!-- Pagination End -->

<?php include 'includes/footer.php'; ?>