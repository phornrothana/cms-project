<!--  jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
 include "../admin/connection.php";
function logo_website($location){
    global $connection;
    $query = "SELECT * FROM `logo` WHERE `location` = '$location' ORDER BY `id` DESC LIMIT 1";
    $result = $connection->query($query);
    $row =mysqli_fetch_assoc($result);
    return $row['thumbnail'];
}
function get_news_post($category){
    global $connection;
    $query = "SELECT * FROM `news` WHERE `category` = '$category' ORDER BY `id` DESC LIMIT 3";
    $result =$connection->query($query);
     while($row =mysqli_fetch_assoc($result)){
        echo '
            <div class="col-4">
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img width="350px" height="200px"  src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                    <div class="title">
                        '.$row['title'].'
                    </div>
                    </div>
                </a>
            </figure>
        </div>
        ';
     }
}
function get_related_news($id,$category)
{
    global $connection;
    $query = "SELECT * FROM `news` WHERE `id` NOT IN ('$id') AND `category` = '$category' LIMIT 2";
    $result =$connection->query($query);
    while($row=mysqli_fetch_assoc($result)){
            echo '
                <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img width="350" height="200" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                    </div>
                    <div class="detail">
                        <h3 class="title">'.$row['title'].'</h3>
                        <div class="date">'.$row['create_at'].'</div>
                        <div class="description">
                           '.$row['description'].'
                        </div>
                    </div>
                </a>
            </figure>
            
            ';

    }
}
function get_views($id){
    global $connection;
    $query="UPDATE `news` SET `view` = `view` + 1 WHERE `id`= '$id'";
    $result=$connection->query($query);
}
function top_trending_nesw(){
    global $connection;
    $query = "SELECT * FROM `news` ORDER BY `view` DESC LIMIT 1";
    $result = $connection->query($query);
    while($row=mysqli_fetch_assoc($result)){
        echo '
                <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img width="730px" height="415px"  src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                    <div class="title">
                        '.$row['title'].'
                    </div>
                    </div>
                </a>
            </figure>
        
        ';
    }
}
function  get_trend_news(){
    global $connection;
    $query = "SELECT * FROM `news` ORDER BY `view` DESC LIMIT 1,2";
    $result = $connection->query($query);
    while($row=mysqli_fetch_assoc($result)){
        echo '
            <div class="col-12">
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img  width="350" height="200" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                    <div class="title">
                       '.$row['title'].'
                    </div>
                    </div>
                </a>
            </figure>
        </div>
        ';
    }
}
function search_news(){
    global $connection;
    $search = $_GET['query'];
    $query = "SELECT * FROM `news`  WHERE `title` LIKE  '%$search%'";
    $result=$connection->query($query);
    while($row=mysqli_fetch_assoc($result)){
        echo '
            <div class="col-4">
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img width="400" height="250" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                    </div>
                    <div class="detail">
                        <h3 class="title">'.$row['title'].'</h3>
                        <div class="date">'.$row['create_at'].'</div>
                        <div class="description">
                            '.$row['description'].'
                        </div>
                    </div>
                </a>
            </figure>
        </div>
        ';
    }
}

function contact(){
    global $connection;
    if(isset($_POST['btn_message'])){
        $username   = $_POST['username'];
        $email      = $_POST['email'];
        $phone      = $_POST['phone'];
        $address    = $_POST['address'];
        $content    = $_POST['message'];
        if(!empty($username) && !empty($email) && !empty($phone) && !empty($address) &&!empty($content)){
            $query = "INSERT INTO `feedback` (`username`, `email`, `phone`, `address`, `content`) 
             VALUES ('$username','$email' , '$phone' , '$address' , '$content') ";
             $result = $connection->query($query);
             if ($result) {
                echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "Success",
                                text: "Successfully adding content",
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
                        text: "Failed adding content",
                        icon: "error",
                        button: "Confirm",
                    });
                })
            </script>
        ';
        }
    }
}
contact();
function National($type,$category){
    global $connection;
    $query = "SELECT * FROM `news`  WHERE `type` = '$type' AND `category` = '$category' ORDER BY `id` DESC LIMIT 6";
    $result=$connection->query($query);
    while($row=mysqli_fetch_assoc($result)){
            echo '
            <div class="col-4">
                <figure>
                    <a href="">
                        <div class="thumbnail">
                            <img width="350" height="300" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                        </div>
                        <div class="detail">
                            <h3 class="title">'.$row['title'].'</h3>
                            <div class="date">'.$row['create_at'].'</div>
                            <div class="description">
                                    '.$row['description'].'
                            </div>
                        </div>
                    </a>
                </figure>
            </div>
            ';
    }
    
}
function footer($location){
    global $connection;
    $query = "SELECT * FROM `social` WHERE `location` = '$location' ORDER BY `id` DESC LIMIT 3";
    $result = $connection->query($query);
   while($row=mysqli_fetch_assoc($result)){
        echo '
        <li>
         <a href=""><img width="40" src="../admin/assets/image/'.$row['image'].'" alt=""></a>
       </li>
        ';
   }
}
function get_follow_website($location){
    global $connection;
    $query = "SELECT * FROM `social` WHERE `location` = '$location' ORDER BY `id` DESC LIMIT 7";
    $result = $connection->query($query);
   while($row=mysqli_fetch_assoc($result)){
        echo '
          <li>
            <a href=""><img width="40" src="../admin/assets/image/'.$row['image'].'" alt="">'.$row['name'].'</a>
          </li>
        ';
   }
}
