<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
    <!-- Navigation -->
   <?php include "includes/nav.php"; ?>


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php
                if (isset($_GET['p_id'])) {
                    $post_id = $_GET['p_id'];
                    $post_user = $_GET['user'];
                }
                $query = "SELECT * FROM posts WHERE post_user='{$post_user}' ";
                $select1=mysqli_query($connection,$query);
                while($row=mysqli_fetch_assoc($select1))
                {
                    $post_title=$row['post_title'];
                    $post_user=$row['post_user'];
                    $post_date=$row['post_date'];
                    $post_image=$row['post_image'];
                    $post_content=$row['post_content'];
                 
               ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?> "> <?php echo $post_title ?> </a>
                </h2>
                <p class="lead">
                    by <a href="author_post.php?user=<?php echo $post_user;?>&p_id=<?php echo $post_id; ?>"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p> <?php echo $post_content ?></p>
                

                <hr>
                <?php }?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
          
            <?php include "includes/sidebar.php"; ?>
        </div>
        <!-- /.row -->

        <hr>

   <?php include "includes/footer.php"; ?>