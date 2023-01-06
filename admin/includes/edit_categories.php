 <!--The Edit Categories Form-->
<form action="" method="post"> 
    <div class="form-group">
        <label for="cat-title">Edit Categories</label>
            <?php
                if (isset($_GET['edit']))
                 {
                    $cat_id_edit = $_GET['edit'];
                    $query = "select * from categories where cat_id={$cat_id_edit}";
                    $select_edit = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_edit)) {
                        $cat_id =escape($row['cat_id']);
                        $cat_title =escape($row['cat_title']);
            ?>
      <!--when we click edit a new input field shows with the values of the one we want to edit(BELOW)-->
      <input value="<?php if (isset($cat_title)) {echo $cat_title;} ?>" type="text" class="form-control" name="cat_title">
        <?php }}?>
      <?php update_category($cat_id_edit); ?>
    </div>
    <div class="form-group">
        <input class="btn btn-primary"  type="submit" name="update_category" value="Update">
    </div>

</form>