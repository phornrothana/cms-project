<?php 
    include('sidebar.php');
    global $connection;
    $news_id = $_GET['id'];
    $query = "SELECT * FROM `news` WHERE `id` = '$news_id' ";
    $result = $connection->query($query);
    $row =mysqli_fetch_assoc($result);
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add  News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" value="<?php echo $row['title']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Banner</label>
                                        <input type="file" class="form-control" name="banner" >
                                        <br>
                                        <input type="hidden" name="old_banner" value="<?php echo $row['banner']?>"> 
                                        <img width="90px" src="assets/image/<?php echo $row['banner']?>" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail</label>
                                        <input type="file" class="form-control" name="thumbnail">
                                        <br>
                                        <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail']?>" >
                                        <img width="90px" src="assets/image/<?php echo $row['thumbnail']?>" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label>category</label>
                                        <select class="form-select" name="category">
                                            <option value="sport" <?php if($row['category']=='sport') echo 'selected'?>>Sport</option>
                                            <option value="social" <?php if($row['category']=='social') echo 'selected'?>>Social</option>
                                            <option value="entertaiment" <?php if($row['category']=='entertaiment') echo 'selected'?>>Entertaiment</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type">
                                            <option value="national" <?php if($row['type']=='national') echo 'selected'?>>National</option>
                                            <option value="international" <?php if($row['type']=='international') echo 'selected'?>>International</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="description" value="<?php echo $row['description']?>">
                                    </div>
                                    <div class="form-group">
                                        <button name="confirm_edit_news" type="submit" class="btn btn-success">Confirm Add</button>
                                        <a href="view_news_post.php" class="btn btn-danger">Cancel</a>
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