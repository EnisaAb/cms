<?php
//this is a function that you can use to see if the 
//query given as a parameter haves any errors
function confirm($result)
{
    global $connection;
    if(!$result)
    {
        die("Query Failed " . mysqli_error($connection)); 
    }
    
}
function query($query)
{
    global $connection;

    $result= mysqli_query($connection,$query);
    confirm($result);
    return $result;
}
function imagePlaceholder($image='')
{
    if(!$image)
    {
        return 'image_4.jpg';  
    }
    else
    {
        return $image;
    }
}
//this is a function that you can insert categories to a database
function insert_categories()
{
    global $connection;
    if(isset($_POST['submit']))
{
    $cat_title = $_POST['cat_title'];

        if($cat_title== "" || empty($cat_title))
        {
          echo "<h6 style='color:red;'>This fiel should not be empty</h6>";
        }
        else 
        {
            $query = "insert into categories(cat_title) ";
            $query .= "values ('{$cat_title}')";
            $cat_result = mysqli_query($connection, $query);
            if(!$cat_result)
            {
                die("Query Failed " . mysqli_error($connection));
            }
        }
}
}
// a function that displays the data from the categorie table of the database
function displayCategories()
{
    global $connection;
    $query = "select * from categories";
    $select=mysqli_query($connection,$query);
    while($row=mysqli_fetch_assoc($select))
    {
        $cat_id=$row['cat_id'];
        $cat_title=$row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
         echo "</tr>";
    }
}
//a function that can delete rows based the id
function deleteCategories()
{
    global $connection;
    if(isset($_GET['delete']))
    {
        $cat_id_delete = $_GET['delete'];
        $query1 = "delete from categories where cat_id={$cat_id_delete}";
        $result = mysqli_query($connection, $query1);
        header("Location:categories.php");

    }
}
//a function that displays all the online users 
function users_online()
{

    if(isset($_GET['onlineusers']))
    {
            global $connection;
            if(!$connection)
            {
                    session_start();
                    include "../includes/db.php";
        

                    //numeron te gjithe id qe perdoren per momentin
                    $session = session_id();
                    $time = time();
                    $time_out_in_seconds = 05;
                    $time_out = $time - $time_out_in_seconds;
                    $query = "SELECT * FROM users_online WHERE session='$session'";
                    $send_query = mysqli_query($connection, $query);
                    $count = mysqli_num_rows($send_query);
                    if ($count == NULL) {
                        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session','$time')");
                    }
                    else{
                        mysqli_query($connection, "UPDATE users_online SET time= '$time' WHERE session='$session'");
                    }

                    $users_online=mysqli_query($connection, "SELECT * FROM users_online WHERE time>'$time_out'");
                    echo $count_user = mysqli_num_rows($users_online);
            }
    }
}
users_online();
function escape($string){
    global $connection;
  return  mysqli_real_escape_string($connection, trim($string));

}
function checkStatus($table,$column,$status){
    global $connection;
    $query = "SELECT * FROM $table WHERE $column='$status'";
    $select_draft = mysqli_query($connection, $query);
  return  $result = mysqli_num_rows($select_draft);

}

function create_post()
{

    if(isset($_POST['create_post']))
    {
        global $connection;
        $post_user =        escape($_POST['post_user']);
        $post_title =       escape($_POST['title']);
        $post_category =    escape($_POST['post_category']);
        $post_status =      escape($_POST['post_status']);
        $post_images =      escape($_FILES['image']['name']);
        $post_images_temp = escape($_FILES['image']['tmp_name']);
        $post_tags =        escape($_POST['post_tags']);
        $post_content =     escape($_POST['post_content']);
        $post_date =        escape(date('d-m-y'));

        move_uploaded_file($post_images_temp, "../images/$post_images");
        $query = "INSERT INTO posts
         (post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status) 
        VALUES ('{$post_category}','{$post_title}','{$post_user}',now(),'{$post_images}','{$post_content}','{$post_tags}','{$post_status}')";
        $create_post = mysqli_query($connection, $query);
        confirm($create_post);
        echo "<h6 style='color:green;'>Post was added successfully</h6>";

    }
}
function create_user()
{
    if(isset($_POST['create_user']))
    {
        global $connection;
        $username =         escape($_POST['username']);
        $user_first_name =  escape($_POST['user_first_name']);
        $user_last_name =   escape($_POST['user_last_name']);
        $user_role =        escape($_POST['user_role']);
        //$post_images =    $_FILES['image']['name'];
        //$post_images_temp=$_FILES['image']['tmp_name'];
        $user_email =       escape($_POST['user_email']);
        $user_password =    escape($_POST['user_password']);
        //$post_date =      date('d-m-y');
        //move_uploaded_file($post_images_temp, "../images/$post_images");
        $user_password=      password_hash($user_password,PASSWORD_BCRYPT,array('cost'=>10));

        $query = "INSERT INTO users (user_first_name,user_last_name,user_role,username,user_email,user_password) 
        VALUES ('{$user_first_name}','{$user_last_name}','{$user_role}','{$username}','{$user_email}','{$user_password}')";
        $create_user = mysqli_query($connection, $query);
        confirm($create_user);
        echo "<h6 style='color:green;'>User was added successfully</h6>";
        // header("Location : users.php");

    }
}
function is_admin()
{
    global $connection;
    if (isLoggedin()) {
        $query = query("SELECT user_role FROM users WHERE user_id=".$_SESSION['user_id']."");
         $row = mysqli_fetch_array($query);
        if ($row['user_role'] == 'admin') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}
function username_exists($username)
{
    global $connection;
    $query = "SELECT username FROM users WHERE username='$username'";
    $result= mysqli_query($connection, $query);
    confirm($result);
    if(mysqli_num_rows($result)>0)
    {
        return true;
    }
    else
    {
        return false;
    }

}
function email_exists($email)
{
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email='$email'";
    $result= mysqli_query($connection, $query);
    confirm($result);
    if(mysqli_num_rows($result)>0)
    {
        return true;
    }
    else
    {
        return false;
    }

}
function register_user($username,$email,$password)
{
    global $connection;
    $username =      mysqli_real_escape_string($connection, $username);
    $email =         mysqli_real_escape_string($connection, $email);
    $password =      mysqli_real_escape_string($connection, $password);
    $password =      password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users (username, user_password, user_email, user_role)  
    VALUES('{$username}','{$password}','{$email}','subscriber' )";
    $register = mysqli_query($connection, $query);
    confirm($register);
    echo "<h4 style='color:green; text-align:center;'>You have been registrated successfully</h4>";
}
  
function login_user($username,$email)
{
    global $connection;
    $username =    escape($_POST['username']);
    $password =    escape($_POST['password']);
    $query = "SELECT * FROM users WHERE username='{$username}'";
    $select_user = mysqli_query($connection, $query);
    confirm($select_user);
    while ($row = mysqli_fetch_assoc($select_user)) {
        $db_id =        escape($row['user_id']);
        $db_firstname = escape($row['user_first_name']);
        $db_lastname =  escape($row['user_last_name']);
        $db_user_role = escape($row['user_role']);
        $db_username =  escape($row['username']);
        $db_password =  escape($row['user_password']);



        if (password_verify($password, $db_password)) {
            $_SESSION['user_id'] =   $db_id;
            $_SESSION['username'] =  $db_username;
            $_SESSION['firstname'] = $db_firstname;
            $_SESSION['lastname'] =  $db_lastname;
            $_SESSION['user_role'] = $db_user_role;
            header("Location: /cms/admin/");

        } else {
            header("Location: ./index.php");
        }
    }
}

function ifItIsMethod($method=null)
{
    if($_SERVER['REQUEST_METHOD']==strtoupper($method))
    {
        return true;
    }
    return false;

}
function isLoggedin()
{
    if(isset($_SESSION['user_role']))
    {
        return true;
    }
    return false;
}
function loggedinUserId()
{
    if(isLoggedin())
    {
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
        confirm($result);
        $users = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $users['user_id'] : false;
    }
}
function userLike($the_post_id='')
{
   $result= query("SELECT * FROM likes WHERE user_id=" . loggedinUserId() . " AND post_id={$the_post_id}");
    confirm($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}
function count_record($result)
{
    return mysqli_num_rows($result);
}
//general data count for admin dashboard
function recordCound($table)
{
    $result=query("SELECT * from $table ");
    confirm($result);
    return count_record($result);
  
}
function get_users_post()
{
   $result= query("SELECT * FROM posts WHERE post_user='" .$_SESSION['username'] . "'");
   return count_record($result);

}
function get_all_posts_user_comments()
{
    $result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE posts.post_user='".$_SESSION['username']."'");
   return count_record($result);
}
function get_users_category()
{
    $result = query("SELECT * FROM categories WHERE user_id=" . loggedinUserId() . "");
    return count_record($result);

}
function get_user_published_post()
{
    $result= query("SELECT * FROM posts WHERE post_user='" .$_SESSION['username'] . "' AND post_status='published'");
    return count_record($result);
}
function get_user_draft_post()
{
    $result= query("SELECT * FROM posts WHERE post_user='" .$_SESSION['username'] . "' AND post_status='draft'");
    return count_record($result);
}
function get_user_approved_comments()
{
    $result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE posts.post_user='" . $_SESSION['username'] . "' AND comments.comment_status='approved'");
    return count_record($result);
}
function get_user_unapproved_comments()
{
    $result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE posts.post_user='" . $_SESSION['username'] . "' AND comments.comment_status='unapproved'");
    return count_record($result);
}
function getPostLike($the_post_id)
{
    $result = query("SELECT * FROM likes WHERE post_id=$the_post_id");
    confirm($result);
    echo mysqli_num_rows($result);
}
function checkIfUserLoggedIn($redirectLocation=null)
{
    if(isLoggedin())
    {
        header("Location:" . $redirectLocation);
    }
}
function select_option_categories()
{
    global $connection;
    $query ="SELECT * FROM categories ";
    $select_edit =mysqli_query($connection, $query);
    confirm($select_edit);
    while ($row = mysqli_fetch_assoc($select_edit))
    {
      $cat_id =     escape($row['cat_id']);
      $cat_title =  escape($row['cat_title']);
      echo "<option value='{$cat_id}'>$cat_title</option>";
    }
}
function select_option_users()
{
    global $connection;
    $query = "SELECT * FROM users ";
    $select_users = mysqli_query($connection, $query);
    confirm($select_users);
    while ($row = mysqli_fetch_assoc($select_users)) {
    $user_id =    escape($row['user_id']);
    $username =   escape($row['username']);
    echo "<option value='{$username}'>$username</option>";
    } 
}
function update_category($get_id)
{
    if(isset($_POST['update_category']))
    {
     
        global $connection;
        $cat_title_edit = $_POST['cat_title'];
        $query1 = "UPDATE categories SET cat_title='{$cat_title_edit}' WHERE cat_id='{$get_id}'";
        $result = mysqli_query($connection, $query1);
        confirm($result);
        header("Location:categories.php");
     
    } 
}
function get_edit_post()
{
    if (isset($_GET['p_id'])) {
    }
        global $connection;
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
      
}
//showing the data at view_all_post.php from database to a table
function display_table_ofPost()
{
    global $connection;
    $user=$_SESSION['username'];
    $query = "SELECT * FROM posts WHERE post_user='{$user}' ORDER BY post_id DESC";
    $select = mysqli_query($connection, $query);
    confirm($select);
    while($row=mysqli_fetch_assoc($select))
    {
        $post_id =        escape($row['post_id']);
        $post_user =      escape($row['post_user']);
        $post_title =     escape( $row['post_title']);
        $post_category =  escape( $row['post_category_id']);
        $post_status =    escape( $row['post_status']);
        $post_images =    escape( $row['post_image']);
        $post_tags =      escape($row['post_tags']);
        $post_comment =   escape( $row['post_comment_count']);
        $post_content =   escape($row['post_content']);
        $post_date =      escape($row['post_date']);
        $post_view_count= escape($row['post_view_count']);
         echo "<tr>";
         echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id '></td>";
         echo "<td>{$post_id}</td>";
         echo "<td>{$post_user}</td>";
         echo "<td>{$post_title}</td>";

        $query = "SELECT * FROM categories WHERE cat_id={$post_category}";
        $select_edit = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_edit))
        {
            $cat_id =       escape($row['cat_id']);
            $cat_title =    escape($row['cat_title']);
            echo "<td>{$cat_title}</td>";
        }
    
        echo "<td>{$post_status}</td>";
        echo "<td><img width='100' src='../images/$post_images'></td>";
        echo "<td>{$post_tags}</td>";
        echo "<td>{$post_content}</td>";

        $query = "SELECT * FROM comments WHERE comment_post_id=$post_id";
        $send_query_count = mysqli_query($connection,$query);
        while($row = mysqli_fetch_array($send_query_count))
        {
            $comment_id = $row['comment_id'];
        }
        $count_comments = mysqli_num_rows($send_query_count);

        echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";
        echo "<td>{$post_date}</td>";
        echo "<td><a href='ViewPosts.php?reset={$post_id}'>{$post_view_count}</a></td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>See Post</a></td>";
        // echo "<td><a  href='ViewPosts.php?delete={$post_id}' onClick=\"javascript:return confirm('Are you sure you want to delete'); \">Delete</a></td>";
        ?>
        <form action="" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id?>">
            <td><input type="submit" class="btn btn-danger" name="delete" value="Delete"></td>
            </form>
    

       <!--echo "<td><a rel='$post_id'  href='javascript:void(0)' class='delete_link'>Delete</a></td>";-->
       <?php
        echo "<td><a class='btn btn-primary' href='ViewPosts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
      
        echo "</tr>";
    }
   


}
//to delete a post form view_all_post.php
function post_delete()
{
    global $connection;
    if(isset($_POST['delete']))
    {
        $the_post_id=escape($_POST['post_id']);
        $query = "DELETE FROM posts WHERE post_id={$the_post_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: ViewPosts.php");
    }
}
function resetViewCount()
{
    global $connection;
    if(isset($_GET['reset']))
    {
        $the_post_id=escape($_GET['reset']);
        $query = "UPDATE  posts SET post_view_count=0 WHERE post_id=".mysqli_real_escape_string($connection,$the_post_id)." ";
        $reset_query = mysqli_query($connection, $query);
        header("Location: ViewPosts.php");
    }
    
}
//the select option at view all posts
function checkBoxArray()
{
    global $connection;
    if(isset( $_POST['checkBoxArray']))
    {
        foreach($_POST['checkBoxArray'] as $checkBoxValue)
        {
            $bulk_options =escape($_POST['bulk_options']);
            switch( $bulk_options)
            {
                case 'published':
                    $query = "UPDATE posts SET post_status='{$bulk_options}'
                    WHERE post_id=' $checkBoxValue'";
                    $update_published = mysqli_query($connection, $query);
                    break;
                case 'draft':
                    $query = "UPDATE posts SET post_status='{$bulk_options}'
                    WHERE post_id=' $checkBoxValue'";
                    $update_draft= mysqli_query($connection, $query);
                    break;
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id=' $checkBoxValue'";
                    $delete= mysqli_query($connection, $query);
                    break;

            }
        }
    }
}
//showing the data at view_all_comments.php from database to a table
function display_table_ofComments()
{
    global $connection;
    $query = "SELECT * FROM comments ORDER BY comment_id DESC";
    $select = mysqli_query($connection, $query);
    while($row=mysqli_fetch_assoc($select))
    {
        $comment_id =escape($row['comment_id']);
        $comment_post_id =escape( $row['comment_post_id']);
        $comment_author =escape($row['comment_author']);
        $comment_email =escape($row['comment_email']);
        $comment_content =escape($row['comment_content']);
        $comment_status =escape($row['comment_status']);
        $comment_date =escape($row['comment_date']);
       
         echo "<tr>";
         echo "<td>{$comment_id}</td>";
         echo "<td>{$comment_author}</td>";
         echo "<td>{$comment_content}</td>";
/*
         $query = "select * from categories where cat_id={$post_category}";
         $select_edit = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_edit)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
        
            echo "<td>{$cat_title}</td>";
        }
*/
         echo "<td>{$comment_email}</td>";
         echo "<td>{$comment_status}</td>";
        $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
        $select_query = mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($select_query))
        {
            $post_id =escape($row['post_id']);
            $post_title =escape($row['post_title']);
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }
         

         echo "<td>{$comment_date}</td>";
         echo "<td><a href='comments.php?approved=$comment_id'> Approve</a></td>";
         echo "<td><a href='comments.php?unapproved=$comment_id'>Unapprove</a></td>";
         echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";
         echo "</tr>";


    }
}
//delete the comments in view_all_comments.php with a button
function deleteComments($location)
{

    if(isset($_GET['delete']))
    {
        global $connection;
        $the_comment_id=escape($_GET['delete']);
        $query = "DELETE FROM comments WHERE comment_id={$the_comment_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: $location");
    }
}
//delete users in view_all_users.php 
function deleteUsers()
{
    global $connection;
    if(isset($_GET['delete']))
    {
       // if (isset($_SESSION['user_role'])) {
         //   if ($_SESSION['user_role'] == 'admin') {
                $the_users_id = escape($_GET['delete']);
                $query = "DELETE FROM users WHERE user_id={$the_users_id} ";
               $result = mysqli_query($connection, $query);
                confirm($result);
                header("Location: users.php");
          //  }
     //   }

    }
}
//changes the status of the comments approved and unapproved
function changeCommentStatus($status,$location)
{
    if(isset($_GET[$status]))
    {
        global $connection;
        $the_comment_id=escape($_GET[$status]);
        $query = "UPDATE comments SET comment_status='$status' WHERE comment_id=$the_comment_id ";
        $approve_query = mysqli_query($connection, $query);
        header("Location: $location");
    }   
}
// displaying data in view_all_users.php from database in a table
function  display_table_ofUsers(){
    global $connection;
    $query = "SELECT * FROM users ORDER BY user_id DESC";
    $select_users = mysqli_query($connection, $query);
    while($row=mysqli_fetch_assoc($select_users))
    {
        $user_id =escape($row['user_id']);
        $username =escape($row['username']);
        $user_password =escape($row['user_password']);
        $user_first_name =escape($row['user_first_name']);
        $user_last_name =escape($row['user_last_name']);
        $user_email =escape($row['user_email']);
        $user_image =escape($row['user_image']);
        //  $user_dates = $row['user_date'];
        $user_role =escape($row['user_role']);
        echo "<tr>";
        echo "<td>{$user_id}</td>";
        echo "<td>{$username}</td>";
        echo "<td>{$user_first_name}</td>";
        /*
        $query = "select * from categories where cat_id={$post_category}";
        $select_edit = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_edit)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<td>{$cat_title}</td>";
        }
        */
        echo "<td>{$user_last_name}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        /*$query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
        $select_query = mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($select_query))
        {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }

        */
    
        echo "<td><a href='users.php?admin={$user_id}'> Admin</a></td>";
        echo "<td><a href='users.php?subscrieber={$user_id}'>Subscriber</a></td>";
        echo "<td><a class='btn btn-primary'href='users.php?source=edit_users&edit_users={$user_id}'>Edit</a></td>";
        echo "<td><a class='btn btn-danger' href='users.php?delete={$user_id}'>Delete</a></td>";
        echo "</tr>";
    }
}
//in view_all_users.php to change the role of the users from admin or subscriber
function changeUserRole($role)
{
    global $connection;
    if(isset($_GET[$role]))
    {
        $the_users_id=escape($_GET[$role]);
        $query = "UPDATE users SET user_role= '$role' WHERE user_id=$the_users_id ";
        $admin_query = mysqli_query($connection, $query);
        header("Location: users.php");
    }
}
function displayCommentsOfSpecificPost()
{
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id= ". mysqli_real_escape_string($connection,$_GET['id']);
    $select = mysqli_query($connection, $query);
    while($row=mysqli_fetch_assoc($select))
    {
        $comment_id =       escape($row['comment_id']);
        $comment_post_id =  escape($row['comment_post_id']);
        $comment_author =   escape($row['comment_author']);
        $comment_email =    escape($row['comment_email']);
        $comment_content =  escape($row['comment_content']);
        $comment_status =   escape($row['comment_status']);
        $comment_date =     escape($row['comment_date']);
       
         echo "<tr>";
         echo "<td>{$comment_id}</td>";
         echo "<td>{$comment_author}</td>";
         echo "<td>{$comment_content}</td>";
/*
         $query = "select * from categories where cat_id={$post_category}";
         $select_edit = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_edit)) {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
        
            echo "<td>{$cat_title}</td>";
        }
*/
         echo "<td>{$comment_email}</td>";
         echo "<td>{$comment_status}</td>";
        $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
        $select_query = mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($select_query))
        {
            $post_id =      escape($row['post_id']);
            $post_title =   escape($row['post_title']);
            echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        }
         

         echo "<td>{$comment_date}</td>";
         echo "<td><a href='post_comments.php?approve=$comment_id&id=". $_GET['id'] ."'> Approve</a></td>";
         echo "<td><a href='post_comments.php?unapprove=$comment_id&id=". $_GET['id'] ."'>Unapprove</a></td>";
         echo "<td><a href='post_comments.php?delete=$comment_id&id=". $_GET['id'] ."'>Delete</a></td>";
         echo "</tr>";


    }
   
    
    
}
