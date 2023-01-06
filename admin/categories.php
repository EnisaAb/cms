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
<div class="col-xs-6">


<?php insert_categories();?>
    <!--The Add Categories Form-->
<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Add Categories</label>
        <input type="text" class="form-control" name="cat_title">
    </div>

    <div class="form-group">
        <input class="btn btn-primary"  type="submit" name="submit" value="Add Category">
    </div>

</form>  <!--The End of Add Categories Form-->
<?php
//e nxjerr formen vetem kur do ta shtypim edit
if(isset($_GET['edit'])){
    $cat_id =escape($_GET['edit']);
    include "includes/edit_categories.php";
}

 ?>

</div><!--Add categorie form-->
<div class="col-xs-6">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Category Title</th>
            </tr>
        </thead>
        <tbody>
        <?php displayCategories(); ?>
        <?php deleteCategories(); ?>
          
        </tbody>
    </table>
</div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/footer.php"; ?>