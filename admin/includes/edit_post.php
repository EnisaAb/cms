<?php
if (isset($_GET['p_id'])) {
}

    $p_id =   escape($_GET['p_id']);
    $query = "SELECT * FROM posts WHERE post_id='{$p_id}'";
    $select = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select)) {
     
        $post_user =       escape( $row['post_user']);
        $post_title =      escape($row['post_title']);
        $post_category =   escape($row['post_category_id']);
        $post_status =     escape($row['post_status']);
        $post_images =     escape( $row['post_image']);
        $post_tags =       escape($row['post_tags']);
        $post_comment =    escape($row['post_comment_count']);
        $post_content =    escape( $row['post_content']);
        $post_date =       escape($row['post_date']);
}

if (isset($_POST['update_post'])) 
{
        $post_user =         escape($_POST['post_user']);
        $post_title =        escape( $_POST['title']);
        $post_category =     escape($_POST['post_category']);
        $post_status =       escape($_POST['post_status']);
        $post_images =       escape($_FILES['image']['name']);
        $post_images_temp =  escape($_FILES['image']['tmp_name']);
        $post_tags =         escape($_POST['post_tags']);
        $post_content =      escape($_POST['post_content']);

    move_uploaded_file($post_images_temp, "../images/$post_images");
    if(empty($post_images))
    {
        $query_img = "SELECT * FROM posts WHERE post_id=$p_id ";
        $select_images = mysqli_query($connection, $query_img);
        while ($row = mysqli_fetch_assoc($select_images)) {
          $post_image = escape($row['post_image']);
        }   
    }
    $query = "UPDATE posts SET
            post_title = '{$post_title}',
            post_category_id = '{$post_category}',
            post_date = now(),
            post_user = '{$post_user}',
            post_status = '{$post_status}',
            post_tags = '{$post_tags}',
            post_content = '{$post_content}',
            post_image = '{$post_images}'
            WHERE post_id = {$p_id}";
    $update_post = mysqli_query($connection, $query);
    confirm($update_post);
    echo "<h6 style='color:green;'>Post was updated successfully</h6>";
   // header("Location : view_all_post.php");
    
}
?>


<form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title" />
      </div>
     
      <div class="form-group">
        <label for="post_category">Post Category Id</label><br>
       <select name="post_category" id="">
            <?php 

                $query = "SELECT * FROM categories ";
                $select_edit = mysqli_query($connection, $query);
                confirm($select_edit);
                while ($row = mysqli_fetch_assoc($select_edit)) {
                $cat_id =escape($row['cat_id']);
                $cat_title =escape($row['cat_title']);
                if($cat_id==$post_category){
                  echo "<option selected value='{$cat_id}'>$cat_title</option>";
                } else {
                echo "<option value='{$cat_id}'>$cat_title</option>";
              }
                }

            ?>
       </select>
      </div>
    
      <div class="form-group">
        <label for="users">Users </label><br>
       <select name="post_user" id="">
            <?php 
                echo "<option value='{$post_user}'>$post_user</option>";
                $query = "SELECT * FROM users ";
                $select_users = mysqli_query($connection, $query);
                confirm($select_users);
                while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id =escape($row['user_id']);
                $username =escape($row['username']);
                echo "<option value='{$username}'>$username</option>";

                }

            ?>
       </select>
      </div>
     
      <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="">
        <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
           <?php
  
            if($post_status=='published'){
              echo " <option value='draft'>draft</option>";
            }
            else
            {
              echo " <option value='published'>published</option>";
            }
            ?>
         
        </select>
        <!--<input value="" type="text" class="form-control" name="post_status" />-->
      </div>
     
      <div class="form-group">
        <label for="post_image">Post Image</label><br>
        <input type="file" name="image" />
       <img  name="image" width="100" src="../images/<?php echo $post_images; ?>" alt="">
      </div>
     
      <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags" />
      </div>
     
      <div class="form-group">
        <label for="summernote">Post Content</label>
          <textarea  class="form-control" name="post_content" id="summernote" rows="10" cols="30"><?php echo $post_content; ?></textarea>
        </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
        </div>
    </form>