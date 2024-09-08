<?php include "header.php";
if(isset($_POST['add_user'])){
    $username=mysqli_real_escape_string($config,$_POST['username']);
    $email=mysqli_real_escape_string($config,$_POST['email']);
    $pass=mysqli_real_escape_string($config,sha1($_POST['pass']));
    $c_pass=mysqli_real_escape_string($config,sha1($_POST['c_pass']));
    $role=0;
    if(strlen($username) < 4 ||strlen($username) > 100 ){
        $error="username length is not proper(must be 4 - 100)";
    }  
    elseif(strlen(sha1($pass)) < 4){
        $error="password length is not proper(must be 4 - 100)"; 
    }
    else if($pass!=$c_pass){
        $error="confirm password is not matching.";
    }
    else{
        $sql="SELECT * FROM user WHERE email='$email'";
        $query=mysqli_query($config,$sql);
        $row=mysqli_num_rows($query);
        if($row>=1){
            $error="Email already exists";
        }
        else{
            $sql2="INSERT INTO user (username,email,password,role) VALUES ('$username','$email','$pass','$role')";
            $query2=mysqli_query($config,$sql2);
            if($query2){
                $msg=['Usser added successfully','alert-success'];
                $_SESSION['msg']=$msg;
                header("location:login.php");
            }
            else{
                $error="Failed to signup,Try again";
            }
            
        }
    }
}
?>

<div class="container ">
    <div class="row mt-5">
        <div class="col-md-5 m-auto border border-dark rounded p-4 shadow ">
        <?php
            if(!empty($error)){
                echo "<p class='bg-danger text-white p-2'>".$error."</p>";
            }
            ?>
            <form action="" method="POST">
                <p class="text-center">Sign Up</p>
                <div class="mb-3">
                    <input type="text" name="username" placeholder="Username" class="form-control" value="<?=(!empty($error))?$username:'';?>" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" placeholder="Email" class="form-control" value="<?=(!empty($error))?$email:'';?>" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="pass" placeholder="Password" class="form-control"  required>
                </div>
                <div class="mb-3">
                    <input type="password" name="c_pass" placeholder="Confirm Password" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <input type="submit" name="add_user" class="btn btn-primary w-100" value="Sign Up" required>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "footer.php" ?>