<?php
include "delete_modal.php";
checkBoxArray();
?>
<form action="" method="post">
<table class="table table-bordered table-hover">

<div id="bulkOptionsContainer" class="col-xs-4">

<select class="form-control"  name="bulk_options" id="">
<option value="">Select Options</option>
<option value="published">Publish</option>
<option value="draft">Draft</option>
<option value="delete">Delete</option>

</select>
</div>
<div class="col-xs-4">
<input type="submit" name="submit" class="btn btn-success" value="Apply">
<a href="ViewPosts.php?source=add_posts" class="btn btn-primary"> Add New</a>

</div>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllBoxes"></th>
                                    <th>Id</th>
                                    <th>User</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Content</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>View Count</th>
                                    <th>Go To Post</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                    
                        
                                </tr>
                            </thead>
                            <tbody>
                            <?php display_table_ofPost(); ?>
                            </tbody>
                        </table>
                        </form>
                        <?php 
                            post_delete();
                            resetViewCount();
                        ?>
                        <script>
                            $(document).ready(function () {
                              $(".delete_link").on('click',function(){
                                //pulls the id of a specific link
                                var id=$(this).attr("rel");
                                var delete_url="ViewPosts.php?delete="+id + " ";
                                $(".modal_delete_link").attr("href",delete_url);
                                 $("#myModal").modal('show')  ;
                              });
                            });
                        </script>