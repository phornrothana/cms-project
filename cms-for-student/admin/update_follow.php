<?php 
    include('sidebar.php');
    include './connection.php';
    $id_follow =$_GET['id'];
    $query = "SELECT* FROM `social` WHERE `id`='$id_follow'";
    $result = $connection->query($query);
    $row =mysqli_fetch_assoc($result);
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Update Follow</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $row['id']?>"> 
                                <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control" name="image">
                                        <br>
                                        <input type="hidden" name="old_image" value="<?php echo $row['image']?>">
                                        <img width="80" src="assets/image/<?php echo $row['image']?>" alt="">
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $row['name']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Url</label>
                                        <input type="text" class="form-control" name="url" value="<?php echo $row['url']?>"> 
                                    </div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <select class="form-select" name="location">
                                            <option value="Header" <?php if($row['location']=='Header') echo 'selected'?>>Header</option>
                                            <option value="Footer" <?php if($row['location']=='Footer') echo 'selected'?>>Footer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button name="confirm_edit_follow" type="submit" class="btn btn-success">Confirm Add</button>
                                        <button type="submit" class="btn btn-danger">Concel</button>

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