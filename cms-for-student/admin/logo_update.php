<?php 
    include('sidebar.php');
    include './connection.php';
    $logo_id=$_GET['id'];
    $query = "SELECT * FROM `logo` WHERE `id`= '$logo_id'";
    $result = $connection->query($query);
    $row =mysqli_fetch_assoc($result);
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Update Logo </h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row['id']?>"> 
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-select" name="location">
                                            <option value=""></option>
                                            <option value="Header" <?php if($row['location']=='Header') echo 'selected'?>>Header</option>
                                            <option value="Footer" <?php if($row['location']=='Footer') echo 'selected'?>>Footer</option>
                                        </select>
                                    <div class="form-group">
                                        <label>image</label>
                                        <input type="file" class="form-control" name="image">
                                        <br>
                                        <input type="hidden" name="old_image" value="<?php echo $row['thumbnail']?>">
                                        <img width="80px" src="assets/image/<?php echo $row['thumbnail']?>" alt="">
                                    </div>
                                    <div class="form-group">
                                        <button  name="confirm_edit_logo" type="submit" class="btn btn-primary">Confirm Edit</button>
                                        <a href="logo_view_post.php" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>