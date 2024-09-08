<?php include "header.php";
if(isset($_SESSION['user_data'])){
    $author_id = $_SESSION['user_data']['0'];
}
//fetch categories
$sql="SELECT * from categories";
$query=mysqli_query($config,$sql);
//get blog id
$blogID = $_GET['id'];
if(empty($blogID)){
    header("location:index.php");
}
$sql2="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user ON blog.author_id=user.user_id WHERE blog_id='$blogID'";
$query2=mysqli_query($config,$sql2);
$result=mysqli_fetch_assoc($query2);
?>  

<div class="container">
    <h5 class="mb-2 text-gray-800">Blogs</h5>
    <div class="row">
        <div class="col-xl-8 col-lg-6">
            <div class="card">
            <div class="card-header">
                <h6 class="font-weight-bold text-primary mt-2">Edit blog/article</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" value="<?=$result['blog_title']?>" name="blog_title" placeholder="Title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                <textarea class="form-control"  placeholder="Body" name="blog_body" rows="2" id="blog" required><?=$result['blog_body']?></textarea>
                </div>
                
                <div class="mb-3">
                <select class="form-control" name="category" required>
                
                    <?php 
                    while( $cats=mysqli_fetch_assoc($query)){ ?>
                    <option value="<?=$cats['cat_id']?>"
                         <?= ($result['category']==$cats['cat_id'])?"selected":'';?>>
                            
                        <?=$cats['cat_name']?>>
                        </option>
                    
                    <?php } ?>
                </select>
                </div>
                <div class="mb-3">
                    <input type="submit" name="edit_blog" value="Update" class="btn btn-primary">
                    <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
                </form>
            </div>
            </div>
        </div>    
    <div>
</div>


<?php include "footer.php";
if(isset($_POST['edit_blog'])){
    $title=mysqli_real_escape_string($config,$_POST['blog_title']);
    $body=mysqli_real_escape_string($config,$_POST['blog_body']);
    $category=mysqli_real_escape_string($config,$_POST['category']);
    /*$filename=$_FILES['blog_image']['name'];
    $tmp_name=$_FILES['blog_image']['tmp_name'];
    $size=$_FILES['blog_image']['size'];
    $image_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $allow_type=['jpg','jpeg','png'];
    $destination="upload./".$filename;
    if(in_array($image_ext,$allow_type)){
        
        if($size<=2000000)
        {
            move_uploaded_file($tmp_name,$destination);
        }
        else{
            echo "file size is more thsn 2 mb";
        }
    }
    else{
        echo "not allowed only(jpg,jpeg,png)";
    }*/
    $sql3="UPDATE blog SET blog_title='$title',blog_body='$body',category='$category',author_id='$author_id' WHERE blog_id='$blogID' ";
    $query3=mysqli_query($config,$sql3);
    if($query3){
        $msg=['Blog updated successfully','alert-success'];
        $_SESSION['msg']=$msg;
        header("location:index.php");    
    }
    else{
        $msg=['Not published try again..','alert-danger'];
        $_SESSION['msg']=$msg;
        header("location:index.php");
    }
}

?>
