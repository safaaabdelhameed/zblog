<?php 
include "inc/header.php";
include "inc/navbar.php"; 
include "inc/connect.php"; 
include "inc/functions.php"; 


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['addpost'])){

        $title = filter_input(INPUT_POST,'title', FILTER_SANITIZE_STRING);
        $content = filter_input(INPUT_POST,'content', FILTER_SANITIZE_STRING);
        $category = filter_input(INPUT_POST,'category', FILTER_SANITIZE_STRING);
        $excerpt = filter_input(INPUT_POST,'excerpt', FILTER_SANITIZE_STRING);
        $tags = filter_input(INPUT_POST,'tags', FILTER_SANITIZE_STRING);
        
        $author = "safaa"; // Temporary Author until creating admins

        date_default_timezone_set("Africa/cairo");
        $datetime = date('M-D-Y h:m',time());
        $image = $_FILES['image'];
        
        $img_name = $image['name'];
        $img_tmp_name = $image['tmp_name'];
        $img_size = $image['size'];

        // echo $img_name;
        // echo $img_size;

        

        $error_msg = "";
        if(strlen($title) < 100 || strlen($title) > 200){
            $error_msg = "Title must be between 100 and 200";
        }elseif(strlen($content) < 500 || strlen($content) > 10000){
            $error_msg = "content must be between 500 and 10000";
        }elseif(!empty($excerpt)){
            if(strlen($excerpt) < 100 || strlen($excerpt) > 500){
                $error_msg = "Excerpt must be between 100 and 500";
            }
        }else{
            if(!empty($img_name)){
                $img_extension = explode('.', $img_name)[1];
                                
                $allowed_extensions = array('jpg' , 'png', 'jpeg');

                if(! in_array($img_extension, $allowed_extensions)){
                    $error_msg = "Allowed Extensions are jpg, png and jpeg";
                }elseif($img_size > 1000000) {
                    $error_msg = "Image size must be less than 1m";
                }

            }
        }
        
        if(empty($error_msg)){
            // Insert data in Database
            if(insert_post($datetime, $title, $content, $author, $excerpt, $img_name, $category, $tags)){
                
                // If there is an image, move it to the desired directory
                if(!empty($img_name)){
                    $new_path = "uploads/posts/" . $img_name;
                        if(move_uploaded_file($img_tmp_name, $new_path)){
                            echo "Success";
                        } 
                } 
        
            } 
        } else {
            echo "Error: " . $error_msg;
        }

    }




}







 
?>



<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
           <?php include "inc/sidebar.php"; ?>
        </div>
        <div class="col-sm">
            <div class="post">
                <h3>Add New Post</h3>
                <form action="post.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input class="form-control" type="text" name="title" placeholder="Title" required autocomplete="off">
                        <p class="error title-error">Title must be between 100 and 200 characters</p>
                    </div>
                    <div class="form-group">
                        <textarea rows="6" name="content" class="form-control" placeholder="Content" required autocomplete="off" ></textarea>
                        <p class="error content-error">Content must be between 500 and 10000 characters</p>
                    </div>
                    <div class="form-group">
                        <select name="category" class="form-control">
                            <?php  
                            foreach(get_categories() as $category){
                                echo "<option>";
                                echo $category['name'];
                                echo "</option>";
                            }
                            
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="excerpt" placeholder="Excerpt ( Optional ) " autocomplete="off">
                        <p class="error excerpt-error">Excerpt must be between 100 and 500 characters</p>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="tags" placeholder="tags" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="file" name="image">
                    </div>
                    <input value="Add Post" type="submit" name="addpost" class="btn btn-primary" style="float:right">
                </form>
            </div>
        </div>
    </div>
</div>



<?php include "inc/footer.php"; ?>