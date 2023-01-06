<?php include "includes/header.php"; ?>
<?php  
if(isset($_SESSION['username']))
{
    $username =escape($_SESSION['username']);
    $query = "SELECT * FROM users WHERE username='{$username}'";
    $select_user_profile = mysqli_query($connection, $query);
    while($row=mysqli_fetch_array($select_user_profile))
    {
        $user_id =        escape($row['user_id']);
        //$username =     escape($row['username']);
        $user_password =  escape($row['user_password']);
        $user_first_name =escape($row['user_first_name']);
        $user_last_name = escape( $row['user_last_name']);
        $user_email =     escape($row['user_email']);
        $user_image =     escape($row['user_image']);
        //$user_dates =   escape($row['user_date']);
        $user_role =      escape($row['user_role']);
    }

    
}
?>
 <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/nav.php"; ?>
            <div id="page-wrapper">
            <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
            <div class="col-lg-12">
            <h1 class="page-header">
            Welcome to Admin
                <small><?php echo $username; ?></small>
            </h1>
            <?php  
             
             if(isset($_POST['edit_users']))
             {
               
                //$user_id =       escape($_POST['user_id']);
                $username =        escape($_POST['username']);
                $user_first_name = escape($_POST['user_first_name']);
                $user_last_name =  escape($_POST['user_last_name']);
                $user_role =       escape($_POST['user_role']);
                //$post_images =  $_FILES['image']['name'];
                //$post_images_temp = $_FILES['image']['tmp_name'];
                $user_email =     escape($_POST['user_email']);
                $user_password =  escape($_POST['user_password']);
                // $post_date = date('d-m-y');
                // move_uploaded_file($post_images_temp, "../images/$post_images");

             
               $query = "UPDATE users SET
               user_first_name = '{$user_first_name}',
               user_last_name = '{$user_last_name}',
               user_role = '{$user_role}',
               username = '{$username}',
               user_email = '{$user_email}',
               user_password = '{$user_password}'
               
               WHERE username ='{$username}'";
             $update_user = mysqli_query($connection, $query);
             confirm($update_user);
             echo "<h6 style='color:green;'>User was updated successfully</h6>";
             }
             
                          
?>
            <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" value="<?php echo $user_first_name;?>" class="form-control" name="user_first_name" />
            </div>

            <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" value="<?php echo $user_last_name;?>" class="form-control" name="user_last_name" />
            </div>


            <div class="form-group">
            <label for="role">Select Role</label><br>
            <select name="user_role" id="">
            <option value="subscriber"><?php echo $user_role;?></option>
            <?php 
            if($user_role=='admin')
            {
            echo " <option value='subscriber'>subscriber</option>";
            }
            if($user_role=='subscriber')
            {
            echo " <option value='admin'>admin</option>";
            }


          
            ?>
        
            </select>
            </div>



            <!--  <div class="form-group">
            <label for="post_image">Post Image</label>
            <input type="file" name="image" />
            </div>
            -->
            <div class="form-group">
            <label for="username">Username</label>
            <input type="text" value="<?php echo $username;?>" class="form-control" name="username" />
            </div>

            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" value="<?php echo $user_email;?>" class="form-control" name="user_email" />
            </div>

            <div class="form-group">
            <label for="password">Password</label>
            <input type="password" autocomplete="off" class="form-control" name="user_password" />
            </div>

            <div class="form-group">
            <input class="btn btn-primary" type="submit" name="edit_users" value="Edit Profile">
            </div>
            </form>
            
            </div>
            </div>
            <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

            <?php include "includes/footer.php"; ?>