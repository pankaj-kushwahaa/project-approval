<?php 
define('TITLE', 'Registered Students');
define('PAGE', 'Registered Users');
include("includes/header.php"); 
?>
<!-- Filter Start -->
<div class="w3-container">
  <div class="w3-section w3-bottombar w3-padding-16">
    <span class="w3-margin-right">Filter:</span> 
    <a href="registered-users.php" class="w3-button w3-black">All Students</a>
    <a href="users-list.php" class="w3-button w3-white"><i class="fa fa-diamond w3-margin-right"></i>CSE 6th</a>
    <a href="users-list.php" class="w3-button w3-white"><i class="fa fa-photo w3-margin-right"></i>EE 6th</a>
    <a href="teachers-list.php" class="w3-button w3-white"><i class="fa fa-photo w3-margin-right"></i>All Teachers</a>
  </div>
</div>
<!-- Filter End -->

<!-- Table Container Start -->
<div class="w3-container">
  <h5>All Registered Members</h5>
  <!-- Table Start -->
  <table class="w3-table w3-bordered w3-border w3-hoverable w3-white">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Branch/Sem</th>
        <th>Team Members</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Pankaj 1908751</td>
        <td>pankajkushwaha</td>
        <td>781488</td>
        <td>CSE 6th</td>
        <td>Akash 1908751 <br>Pankaj 1908751 <br>Harjot 1908751</td>
        <td><button type="submit" class="w3-btn w3-green w3-small" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete</button></td>
    </tr>
  </tbody>
  </table>
  <!-- Table End -->
</div>
<!-- Table Container End -->

<!-- Modal box start -->
<!-- Modal -->
<div class="container">
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirm ?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Delete</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Modal box end -->

<?php include("includes/footer.php"); ?>