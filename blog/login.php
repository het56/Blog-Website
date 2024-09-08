<?php session_start();
     include 'config.php'; 
     include 'header.php'; 
     if(isset($_SESSION['user_data'])){
        header("location:http://localhost/BLOG/admin/index.php");
     }
     if(isset($_POST['loginn_btn'])){
        $email=mysqli_real_escape_string($config,$_POST['email']);
        $pass=mysqli_real_escape_string($config,sha1($_POST['password']));
        $sql= "SELECT * FROM user WHERE email='{$email}'
        AND password='{$pass}'";
        $query=mysqli_query($config,$sql);
        $data=mysqli_num_rows($query);
        if($data){
            $result=mysqli_fetch_assoc($query);
            $user_data=array($result['user_id'],$result['username'],$result['role']);
            $_SESSION['user_data']=$user_data;
            header("location:admin/index.php");
            exit;
        }
        else{
            $_SESSION['Error']="Invalid";
            header("location:login.php");
            exit;
        }
    }  
 ?>
<div class="container">
    <div class="row">
        <div class="col-xl-5 col-md-4 m-auto p-5 mt-5  border border-dark rounded p-4 shadow">
            <form action="" method="POST">
          <?php
            if(isset($_SESSION['Error'])){
                $error=$_SESSION['Error'];
                echo "<p class='bg-danger p-2 text-white'>".$error."</p>";
                unset($_SESSION['Error']);
            }
            ?>
              <div class="mb-3">
                <input type="email" name="email"
                placeholder="Email" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password"
                placeholder="Password" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="submit" name="loginn_btn"
                class="btn btn-primary p-2 w-100" value="Login">
            </div>
            <hr>
            <p>Not having an account?</p>
            
            </form>

            <div class="mb-3">
                <a class="btn btn-primary w-100" href="signup.php">Sign Up</a>
            </div>

        </div>
</div>
<?php include 'footer.php';
?>
