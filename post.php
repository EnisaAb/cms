<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
    <!-- Navigation -->
   <?php include "includes/nav.php"; ?>
<?php 
if(isset($_POST['liked']))
{
    $post_id=$_POST['post_id'];
    $user_id=$_POST['user_id'];
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $result = mysqli_query($connection, $query);
    confirm($result);
    while ($post_result = mysqli_fetch_array($result)) {
       $likes = $post_result['likes'];
    }
   $update_query= mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");
    confirm($update_query);
   $insert_query= mysqli_query($connection, "INSERT INTO likes(user_id,post_id) VALUES($user_id,$post_id)");
    confirm($insert_query);
    exit();
}   
if(isset($_POST['unliked']))
{
    $post_id=$_POST['post_id'];
    $user_id=$_POST['user_id'];
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $result = mysqli_query($connection, $query);
    confirm($result);
    while ($post_result = mysqli_fetch_array($result)) {
       $likes = $post_result['likes'];
    }
   $delete_query= mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
    confirm($delete_query);
   $insert_query= mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
    confirm($insert_query);
    exit();
} 
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if (isset($_GET['p_id'])) {
                    $the_post_id = $_GET['p_id'];
                    $view_query = "UPDATE posts SET post_view_count=post_view_count+1 WHERE post_id=$the_post_id ";
                    $select_all_posts = mysqli_query($connection, $view_query);
                    confirm($select_all_posts);

                    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                        $query = "SELECT * FROM posts WHERE post_id=$the_post_id ";
                    } else {
                        $query = "SELECT * FROM posts WHERE post_id=$the_post_id AND post_status='published'";
                    }


                    $select1 = mysqli_query($connection, $query);
                    if (mysqli_num_rows($select1) < 1) {
                        echo " <h1 class='text-center'>NO POSTS AVAILABLE</h1>";
                    } else {
                        while ($row = mysqli_fetch_assoc($select1)) {
                            $post_title =       escape($row['post_title']);
                            $post_user =        escape($row['post_user']);
                            $post_date =        escape($row['post_date']);
                            $post_image =       escape($row['post_image']);
                            $post_content =     escape($row['post_content']);

                ?>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $the_post_id; ?> "> <?php echo $post_title ?> </a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?user=<?php echo $post_user; ?>&p_id=<?php echo $the_post_id; ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <hr>
                <p> <?php echo $post_content ?></p>
                <?php if(isLoggedin()):?>
                <div class="row">
                    <p class="pull-right"><a class="<?php echo userLike($the_post_id)? 'unlike':'like'?>" href=""> <span class="glyphicon glyphicon-thumbs-up"></span>  <?php echo userLike($the_post_id)? 'Unlike':'Like'?></a></p>
                </div>
                <?php else:?>
                    <div class="row">
                    <p class="pull-right">You need to <a href="login.php"> Login</a> to like</p>
                </div>
                <?php endif; ?>
                <div class="row">
                    <p class="pull-right">Like: <?php getPostLike($the_post_id)?></p>
                </div>
                <div class="clearfix"></div>

                <hr>
                <?php } ?>

              
                   <!-- Blog Comments -->
                  
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <?php
                        if (isset($_POST['create_comment'])) {

                            $post_id =           escape($_GET['p_id']);
                            $comment_author =    escape($_POST['comment_author']);
                            $comment_email =     escape($_POST['comment_email']);
                            $comment_content =   escape($_POST['comment_content']);
                            if (empty($comment_author) || empty($comment_content) || empty($comment_email)) {
                                echo "<h4 style='color:red;'>Fields can't be blank</h4>";
                            } else {
                                $query = " INSERT INTO comments (comment_post_id,
                            comment_author,comment_email,comment_content,comment_status,comment_date)
                             VALUES ($post_id,'{$comment_author}','{$comment_email}','{$comment_content}',
                            'unapproved',now())";
                                $result = mysqli_query($connection, $query);
                                confirm($result);

                            }
                            header("Location: post.php?p_id=$post_id");
                        }



                    ?>
                    <form role="form" action="" method="post">
                    <div class="form-group">
                        <label for="Author">Author</label>
                          <input type="text" class="form-control" name="comment_author" >
                        </div>
                        <div class="form-group">
                        <label for="Email">Email</label>
                          <input type="email" class="form-control" name="comment_email" >
                        </div>
                        <div class="form-group">
                        <label for="Comment">Comment</label>
                            <textarea  name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                    <?php
                        $query = "SELECT * FROM comments WHERE comment_post_id={$the_post_id}
                    AND comment_status='approved'
                    ORDER BY comment_id DESC";
                        $select_comment_query = mysqli_query($connection, $query);
                        confirm($select_comment_query);
                        while ($row = mysqli_fetch_assoc($select_comment_query)) {
                            $comment_date =     escape($row['comment_date']);
                            $comment_content =  escape($row['comment_content']);
                            $comment_author =   escape($row['comment_author']);
                    ?>
                        <div class="media">
                        <a class="pull-left" href="#">
                        <img class="media-object" src="" alt="">
                        </a>
                        <div class="media-body">
                        <h4 class="media-heading"> <?php echo $comment_author; ?>
                        <small><?php echo $comment_date; ?></small>
                        </h4> 
                        <?php echo $comment_content; ?>

                        </div>
                        </div>

                    <?php } } }
                    else
                    {
                      header("Location: index.php");
                    }
                ?>
                <!-- Comment -->
             
               
                           

            </div>

            <!-- Blog Sidebar Widgets Column -->
          
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

   <?php include "includes/footer.php"; ?>
   <script>
        $(document).ready(function(){
            var post_id=<?php echo $the_post_id?>;
            var user_id=<?php echo loggedinUserId();?>;
            $(".like").click(function(){
                $.ajax({
                    url: "/cms/post.php?p_id=<?php echo $the_post_id ?>",
                    type:'post',
                    data:{
                        'liked': 1,
                        'post_id': post_id,
                        'user_id':user_id

                    }
                });

            });
            $(".unlike").click(function(){
                $.ajax({
                    url: "/cms/post.php?p_id=<?php echo $the_post_id ?>",
                    type:'post',
                    data:{
                        'unliked': 1,
                        'post_id': post_id,
                        'user_id':user_id

                    }
                });

            });
        });
   </script>