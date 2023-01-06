<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firsname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            </tr>
    </thead>
    <tbody>
        <?php display_table_ofUsers(); ?>
    </tbody>
</table>
<?php
deleteUsers();
changeUserRole('admin');
changeUserRole('subscriber');
?>