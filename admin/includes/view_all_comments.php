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
                            <?php display_table_ofComments()?>
                            </tbody>
                        </table>
                        <?php
                            deleteComments('comments.php');
                            changeCommentStatus('approved','comments.php');
                            changeCommentStatus('unapproved','comments.php');
                        ?>