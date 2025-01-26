<?php
include "inc/functions.php"; 

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['deletepost'])){
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

        if(delete('posts', $id)){
            redirect("posts.php");
        }
    }
}