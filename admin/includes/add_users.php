<?php create_user() ?>
<!--THE FORM-->
<form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="user_first_name" />
      </div>
     
      <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="user_last_name" />
      </div>
     
     
      <div class="form-group">
        <label for="role">Select Role</label><br>
        <select name="user_role" id="">
            <option value="select"></option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
       </select>
      </div>    
    <!--  <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image" />
      </div>
              -->
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" />
      </div>
     
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="user_email" />
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password" />
      </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
        </div>
    </form>
      <!--THE END OF THE FORM-->