<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
include './connection.php';
function register_user()
{
    global $connection;
    if (isset($_POST['btn_register'])) {
        $username = $_POST['username'];
        $gender   = $_POST['gender'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $profile = $_FILES['profile']['name'];
        if (!empty($username) && !empty($gender) && !empty($email) && !empty($password) && !empty($profile)) {
            $thumbnail = date('YmdHis') . '-' . $profile;
            $path = 'assets/image/' . $thumbnail;
            move_uploaded_file($_FILES['profile']['tmp_name'], $path);
            $password = md5($password);
            $query = "INSERT INTO `users`(`id`,`name`,`email`,`password`,`profile`,`gender`) VALUES(null,'$username','$email','$password','$thumbnail','$gender')";
            $result = $connection->query($query);
            if ($result) {
                header('location: login.php');
            }
        } else {
            echo 13;
        }
    }
}
register_user();
function login_user()
{
    global $connection;
    session_start();
    if (isset($_POST['btn_login'])) {
        $name_email = $_POST['name_email'];
        $password   = $_POST['password'];
        if (!empty($name_email)  && !empty($password)) {
            $password = md5($password);
            $sql_select = "SELECT * FROM `users` WHERE (`name` ='$name_email' OR `email` = '$name_email') AND `password` ='$password'";
            $result = $connection->query($sql_select);

            if ($result) {
                session_start();
                $row = mysqli_fetch_assoc($result);
                echo $row['id'];
                $_SESSION['id'] = $row['id'];
                header("location: index.php");
            } else {
                echo 111;
            }
        }
    }
}
login_user();
function logout_user()
{
    if (isset($_POST['logout'])) {
        session_start();
        unset($_SESSION['id']);
    }
}
logout_user();

function upload_file($name)
{
    $thumbnail = date('YmdHis') . '-' . $_FILES[$name]['name'];
    $path = 'assets/image/' . $thumbnail;
    move_uploaded_file($_FILES[$name]['tmp_name'], $path);
    return $thumbnail;
}
function add_logo_post()
{
    global $connection;
    if (isset($_POST['confirm_add_logo'])) {
        $location = $_POST['location'];
        $image    = upload_file('image');
        if (!empty($location) && !empty($image)) {
            $query = "INSERT INTO `logo` (`thumbnail`,`location`) VALUES('$image','$location')";
            $result = $connection->query($query);
            if ($result) {
                echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Success",
                                    text: "Successfully adding logo",
                                    icon: "success",
                                    button: "Confirm",
                                });
                            })
                        </script>
                    ';
            }
        } else {
            echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Failed",
                            text: "Failed adding logo",
                            icon: "error",
                            button: "Confirm",
                        });
                    })
                </script>
            ';
        }
    }
}
add_logo_post();
function view_all_logo()
{
    global $connection;

    $query = "SELECT * FROM `logo` WHERE 1 ORDER BY `id` DESC";

    $result = $connection->query($query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '
                <tr>
                    <td>' . $row['id'] . '</td>
                    <td><img width="80px" src="assets/image/' . $row['thumbnail'] . '"/></td>
                    <td>' . $row['location'] . '</td>
                    <td>' . $row['created_at'] . '</td>
                    <td width="150px">
                        <a href="logo_update.php?id=' . $row['id'] . '" class="btn btn-primary">Update</a>
                        <button type="button" remove-id="' . $row['id'] . '" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
            ';
    }
}
function update_logo()
{
    global $connection;

    if (isset($_POST['confirm_edit_logo'])) {
        $id        = $_POST['id'];
        $location  = $_POST['location'];
        $new_image = $_FILES['image']['name'];
        $old_image = $_POST['old_image'];

        if (empty($new_image)) {
            $thumbnail = $old_image;
        } else {
            $thumbnail = date('YmdHis') . '-' . $new_image;

            $path = 'assets/image/' . $thumbnail;

            move_uploaded_file($_FILES['image']['tmp_name'], $path);
        }

        if (!empty($location) && !empty($thumbnail)) {
            $query = "
                                UPDATE `logo` 
                                SET `thumbnail` = '$thumbnail',`location` = '$location'
                                WHERE `id` = '$id';
                            ";


            $result = $connection->query($query);

            if ($result) {
                echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Success",
                                    text: "Successfully editing logo",
                                    icon: "success",
                                    button: "Confirm",
                                });
                            })
                        </script>
                    ';
            }
        } else {
            echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Failed",
                            text: "Failed editing logo",
                            icon: "error",
                            button: "Confirm",
                        });
                    })
                </script>
            ';
        }
    }
}
update_logo();


function remove_logo()
{
    global $connection;

    if (isset($_POST['confirm_remove_logo'])) {
        $id = $_POST['remove_id'];

        $query = "DELETE FROM `logo` WHERE `id` = '$id'";

        $result = $connection->query($query);

        if ($result) {
            echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success",
                                text: "Successfully editing logo",
                                icon: "success",
                                button: "Confirm",
                            });
                        })
                    </script>
                ';
        }
    }
}
remove_logo();
function add_news_post()
{
    global $connection;
    if (isset($_POST['confirm_add_news'])) {
        $title      =    $_POST['title'];
        $banner     =    upload_file('banner');
        $thumbnail  =    upload_file('thumbnail');
        $category   =    $_POST['category'];
        $type       =    $_POST['type'];
        $description =    $_POST['description'];
        $post_by     =   $_SESSION['id'];
        if (!empty($title) && !empty($banner) && !empty($thumbnail) && !empty($category) && !empty($type) && !empty($description)) {
            $query = "INSERT INTO `news`(`title`, `banner`, `thumbnail`, `description`, `category`, `type`,  `post_by`) 
        VALUES ('$title','$banner','$thumbnail','$description','$category','$type','$post_by')";
            $result = $connection->query($query);
            if ($result) {
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success",
                                text: "Successfully adding news",
                                icon: "success",
                                button: "Confirm",
                            });
                        })
                    </script>
                ';
            }
        } else {
            echo '
            <script>
                $(document).ready(function(){
                    swal({
                        title: "Failed",
                        text: "Failed adding news",
                        icon: "error",
                        button: "Confirm",
                    });
                })
            </script>
        ';
        }
    }
}
add_news_post();
function view_news_post()
{
    global $connection;
    $query = "SELECT a.name , b.*FROM `users` AS a INNER JOIN `news` AS b ON a.id= b.post_by";
    $result = $connection->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '
                <tr>
                    <td>' . $row['title'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td><img width="80px" src="assets/image/' . $row['banner'] . '"/></td>
                    <td><img width="80px" src="assets/image/' . $row['thumbnail'] . '"/></td>
                    <td>' . $row['category'] . '</td>
                    <td>' . $row['type'] . '</td>
                    <td>' . $row['description'] . '</td>
                    <td>' . $row['view'] . '</td>
                    <td>' . $row['create_at'] . '</td>
                    <td width="150px">
                        <a href="news_update_post.php?id='.$row['id'].'"class="btn btn-primary">Update</a>
                        <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Remove
                        </button>
                    </td>
                </tr>
        
        ';
    }
}
function update_news_post(){
    global $connection;
    if(isset($_POST['confirm_edit_news'])){
        $id=$_POST['id'];
        $title =$_POST['title'];
        $new_banner =$_FILES['banner']['name'];
        $old_banner =$_POST['old_banner'];
        $new_thumbnail =$_FILES['thumbnail']['name'];
        $old_thumbnail=$_POST['old_thumbnail'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $description =$_POST['description'];
        if(empty($new_banner)){
            $banner=$old_banner;
        }else{
           $banner = date('YmdHis').'-'.$new_banner;
           $path ='assets/image/'.$banner;
           move_uploaded_file($_FILES['banner']['tmp_name'],$path);
        }
        if(empty($new_thumbnail)){
            $thumbnail =$old_thumbnail;
        }else{
           $thumbnail = date('YmdHis').'-'.$new_thumbnail;
           $path ='assets/image/'.$thumbnail;
           move_uploaded_file($_FILES['thumbnail']['tmp_name'],$path);
        }
        if (!empty($title) && !empty($banner) && !empty($thumbnail) && !empty($category) && !empty($type) && !empty($description)){
            $query = "UPDATE  `news` SET `title` = '$title' , `banner` = '$banner' , `thumbnail` = '$thumbnail' , `category` = '$category',
            `type`='$type', `description` = '$description' WHERE `id`='$id' ";
            $result =$connection->query($query);
            if($result){

                echo '
                        <script>
                            $(document).ready(function(){
                                swal({
                                    title: "Success",
                                    text: "Successfully editing news",
                                    icon: "success",
                                    button: "Confirm",
                                });
                            })
                        </script>
                    ';
            }

        }
        else {
            echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Failed",
                            text: "Failed editing news",
                            icon: "error",
                            button: "Confirm",
                        });
                    })
                </script>
            ';
        }
    }
}
update_news_post();

function remove_news_post(){
    global $connection;
    if(isset($_POST['remove_news'])){
        $id=$_POST['remove_id'];
        $query = "DELETE FROM `news` WHERE `id`='$id'";
        $result =$connection->query($query);
        if ($result) {
            echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success",
                                text: "Successfully remove news",
                                icon: "success",
                                button: "Confirm",
                            });
                        })
                    </script>
                ';
        }
    }
}
remove_news_post();
function view_contact(){
    global $connection;
    $query = "SELECT * FROM `feedback` WHERE 1 ORDER BY `id` DESC";
    $result=$connection->query($query);
    while($row=mysqli_fetch_assoc($result)){
        echo '
        <tr>
                <td>'.$row['username'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['phone'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['content'].'</td>
                <td>'.$row['create_at'].'</td>
                <td width="150px">
                    <a href=""class="btn btn-primary">Update</a>
                    <button type="button" remove-id="1" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Remove
                    </button>
                </td>
            </tr>

        
        
        ';
    }
}

function add_follow(){
    global $connection;
   if(isset($_POST['confirm_add_follow'])){
    $image    =upload_file('image');
    $name     =$_POST['name'];
    $url      =$_POST['url'];
    $location =$_POST['location'];
    if(!empty($image) && !empty($name) && !empty($url) && !empty($location)){
        $query = "INSERT INTO `social` (`image`,`name`,`url`,`location`) VALUES ('$image','$name','$url' ,'$location')";
        $result=$connection->query($query);
        if ($result) {
            echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success",
                                text: "Successfully adding follow",
                                icon: "success",
                                button: "Confirm",
                            });
                        })
                    </script>
                ';
        }
    }
    else {
        echo '
            <script>
                $(document).ready(function(){
                    swal({
                        title: "Failed",
                        text: "Failed adding follow",
                        icon: "error",
                        button: "Confirm",
                    });
                })
            </script>
        ';
    }


   }
}
add_follow();

function view_follow(){
    global $connection;
    $query = "SELECT * FROM `social` ORDER BY  `id` DESC";
    $result =$connection->query($query);

    while($row=mysqli_fetch_assoc($result)){
        echo '
        <tr>
           <td>'.$row['id'].'</td>
           <td><img width="60px" src="assets/image/'.$row['image'].'"/></td>
           <td>'.$row['name'].'</td>
           <td>'.$row['url'].'</td>
           <td>'.$row['location'].'</td>
           <td>'.$row['create_at'].'</td>
           <td width="150px">
              <a href="update_follow.php?id='.$row['id'].'"class="btn btn-primary">Update</a>
              <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Remove
               </button>
            </td>
       </tr>
        ';
    }
} 
function update_follow(){
    global $connection;
    if(isset($_POST['confirm_edit_follow'])){
        $id =$_POST['id'];
        $new_image =$_FILES['image']['name'];
        $old_image =$_POST['old_image'];
        $name     =$_POST['name'];
        $url      =$_POST['url'];
        $location =$_POST['location'];
        if(empty($new_image)){
            $image = $old_image;
        }else{
           $image = date('YmdHis').'-'.$new_image;
           $path ='assets/image/'.$image;
           move_uploaded_file($_FILES['image']['tmp_name'],$path);
        }
        if(!empty($image) && !empty($name) && !empty($url) && !empty($location)){
         
           $query = "UPDATE `social` SET `image` = '$image' , `name` ='$name' ,  `url` = '$url' , `location` = '$location' WHERE `id`='$id'";
           $result =$connection->query($query);
           if($result){

               echo '
                       <script>
                           $(document).ready(function(){
                               swal({
                                   title: "Success",
                                   text: "Successfully editing follow",
                                   icon: "success",
                                   button: "Confirm",
                               });
                           })
                       </script>
                   ';
           }

        }
        else {
            echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "Failed",
                            text: "Failed editing follow",
                            icon: "error",
                            button: "Confirm",
                        });
                    })
                </script>
            ';
        }
    }
}
update_follow();
function remove_follow(){
    global $connection;
    if(isset($_POST['remove_follow'])){
        $remove_id =$_POST['remove_id'];
        $query = "DELETE FROM `social` WHERE `id`='$remove_id'";
        $result =$connection->query($query);
        if ($result) {
            echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success",
                                text: "Successfully remove follow",
                                icon: "success",
                                button: "Confirm",
                            });
                        })
                    </script>
                ';
        }
    }
}
remove_follow();