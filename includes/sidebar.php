<?php if(ifItIsMethod('post'))
{
    if (isset($_POST['login'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = escape($_POST['username']);
            $password = escape($_POST['password']);
            login_user($username, $password);
        } else {
            header("Location: index.php");
        }
    }
}?>
<div class="col-md-4">

<!-- Blog Search Well -->
<div class="well">
    <h4>Blog</h4>
    <form action="" method="post">
    <div class="input-group">
        <input  name="username" type="text" class="form-control" placeholder="Enter username">

        <span class="input-group-btn">
            <button name="submit" class="btn btn-default"  type="submit">
                <span class="glyphicon glyphicon-search"></span>
        </button>
        </span>
    </div>
    <!-- /.input-group -->
    </form>
</div>

<div class="well">
    <?php  if(isset($_SESSION['user_role'])):?>
      <h4>Login in as <?php echo $_SESSION['username'] ?></h4>
    <a href="includes/logout.php" class="btn btn-primary">Logout</a>
   <?php else: ?>
  <h4>Login</h4>
    <form  method="post">
    <div class="form-group">
        <input  name="username" type="text" class="form-control" placeholder="Enter username">
    
    </div>
    <div class="input-group">
        <input  name="password" type="password" class="form-control" placeholder="Enter password">
      <span class="input-group-btn">
            <button name="login" class="btn btn-primary"  type="submit">Submit</button>
        </span>
  
    </div>
    <div style="margin: 10px 3px; ">
    <a  href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
    </div>
    <!-- /.input-group -->
    </form>
    <?php endif; ?>
</div>




<!-- Blog Categories Well -->
<div class="well">

<?php
$query = "select * from categories";
$select=mysqli_query($connection,$query);

?>
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php 
                while($row=mysqli_fetch_assoc($select))
                {
                    $cat_title=$row['cat_title'];
                    $cat_id=$row['cat_id'];
                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                }
                ?>
               
            </ul>
        </div>




        <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->
</div>










<!-- Side Widget Well -->
<?php  include "widges.php" ?>
</div>