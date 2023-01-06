<?php include "includes/header.php"; ?>

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
                            <small>Author</small>
                        </h1>
                       
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
            
        </tr>
    </thead>
    <tbody>
        <?php displayCommentsOfSpecificPost();?>
    </tbody>
        <td><a href="ViewPosts.php">Go to All posts</a></td>
</table>
                        <?php 
                            changeCommentStatus('approve',"post_comments.php?id=" . $_GET['id'] ."");
                            changeCommentStatus('unapprove',"post_comments.php?id=" . $_GET['id'] ."");
                            deleteComments("post_comments.php?id=" . $_GET['id'] . "");
                        ?>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/footer.php"; ?>