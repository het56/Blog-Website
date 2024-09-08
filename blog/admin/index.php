<?php include "header.php";

if(isset($_SESSION['user_data'])){
   $userID = $_SESSION['user_data']['0'];
} 
?>

               <!-- Begin Page Content -->
               <div class="container-fluid">
                  <!-- Page Heading -->
                  <h5 class="mb-2 text-gray-800">Blog Posts</h5>
                  <!-- DataTales Example -->
                  <div class="card shadow">
                     <div class="card-header py-3 d-flex justify-content-between">
                        <div>
                        
                            <a href="add_b.php">  <h6 class="font-weight-bold text-primary mt-2">Add New Blog</h6> </a>
                  
                        </div>
                        <div>
                           <form class="navbar-search">
                              <div class="input-group">
                                 <input type="text" class="form-control bg-white border-0 small" placeholder="Search for...">
                                 <div class="input-group-append">
                                    <button class="btn btn-primary" type="button"> <i class="fa fa-search fa-sm"></i> </button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="table-responsive">
                           <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                 <tr>
                                    <th>Sr.No</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Date</th>
                                    <th colspan="2">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                 $sql="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user ON blog.author_id=user.user_id WHERE user_id='$userID' ORDER BY blog.publish_date DESC";
                                 $query=mysqli_query($config,$sql);
                                 $rows=mysqli_num_rows($query);
                                 $count=0;
                                 if($rows){
                                    while ($result=mysqli_fetch_assoc($query)) {
                                       ?>
                                       <tr>
                                          <td><?= ++$count ?></td>
                                          <td><?=$result['blog_title']?></td>
                                          <td><?=$result['cat_name']?></td>
                                          <td><?=$result['username']?></td>
                                          <td><?=$result['publish_date']?></td>
                                          <td><a href="edit_blog.php ?id=<?=$result['blog_id'] ?>" class="btn btn-sm btn-success">Edit</a></td>
                                          <td>
                                          <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete?')">
                                          <input type="hidden" name="ID" value="<?= $result['blog_id']?>">
                                          <input type="submit" name="DeletePost" value="Delete" class="btn btn-sm btn-danger">
                                          </form>
                                          </td>
                                       </tr>
                                       <?php
                                 }
                                 }
                                 else{
                                    ?>
                                    <tr><td colspan="7">NO RECORDS FOUND </td></tr>
                                    <?php
                                 }   
                                 ?>

                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- /.container-fluid -->
            </div>

<?php include "footer.php";
if (isset($_POST['DeletePost'])){
   $id=$_POST['ID'];
   $delete="DELETE FROM blog WHERE blog_id='$id'";
   $run=mysqli_query($config,$delete);
       if ($run) {
           $msg=['Post deleted successfully','alert-success'];
           $_SESSION['msg']=$msg;
           header("location:index.php");
           exit;
       }
       else{
           $msg=['failed try again','alert-danger'];
           $_SESSION['msg']=$msg;
           header("location:index.php");
           exit;
       }
   }

?>