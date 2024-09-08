<?php include "header.php";
include '../config.php';
if(isset($_SESSION['user_data'])){
    $author_id = $_SESSION['user_data']['0'];
}

$sql="SELECT * from categories";
$query=mysqli_query($config,$sql);

if(isset($_POST['add_blog'])){
    $title=mysqli_real_escape_string($config,$_POST['blog_title']);
    $body=mysqli_real_escape_string($config,$_POST['blog_body']);
    $category=mysqli_real_escape_string($config,$_POST['category']);
    $sql2="INSERT INTO blog(blog_title,blog_body,category,author_id) VALUES('$title','$body','$category','$author_id')";
    $query2=mysqli_query($config,$sql2);
    if($query2){
        $msg=['Blog added successfully','alert-success'];
        $_SESSION['msg']=$msg;
        header("location:add_b.php");
        exit;    
    }
    else{
        $msg=['Not published try again..','alert-danger'];
        $_SESSION['msg']=$msg;
        header("location:add_b.php");
        exit;
    }
}

?>  
<div class="container">
    <h5 class="mb-2 text-gray-800">Blogs</h5>
    <div class="row">
        <div class="col-xl-7 col-lg-5">
            <div class="card">
            <div class="card-header">
                <h6 class="font-weight-bold text-primary mt-2">Publish blog/article</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="text" name="blog_title" placeholder="Title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                <textarea class="form-control" placeholder="Body" name="blog_body" rows="2" id="blog" required></textarea>
                </div>
                
                <div class="mb-3">
                <select class="form-control" name="category" required>
                    <option>Select categories</option>
                    <?php while( $cats=mysqli_fetch_assoc($query)){ ?>

                    <option value="<?=$cats['cat_id']?>"><?=$cats['cat_name']?></option>

                <?php } ?>
                </select>
                </div>
                <div class="mb-3">
                    <input type="submit" name="add_blog" value="Add" class="btn btn-primary">
                    <a href="index.php" class="btn btn-secondary">Back</a>
                </div>
                </form>
            </div>
            </div>
        </div>    
    <div>
</div>


<?php 

include "footer.php"?>
