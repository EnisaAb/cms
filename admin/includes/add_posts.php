<?php create_post();?>
<!--THE FORM-->
<form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" />
      </div>
     
      <div class="form-group">
        <label for="post_category">Post Category </label><br>
       <select name="post_category" id="">
            <?php  select_option_categories(); ?>
       </select>
      </div>
     
      <div class="form-group">
        <label for="users">Users </label><br>
        <select name="post_user" id="">
          <?php select_option_users();?>
       </select>
      </div>

      <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select name="post_status" id="">
          <option value='draft'>Select Options</option>
          <option value="published">Published</option>
          <option value="draft">Draft</option>
        </select>
        <br>
      </div>
     
      <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image" />
      </div>
     
      <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" />
      </div>
     
      <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea class="form-control" name="post_content" id="summernote" rows="10" cols="30"></textarea>
        </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
        </div>
    </form>
    <!--THE END OF THE FORM-->
