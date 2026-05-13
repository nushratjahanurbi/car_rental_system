<?php
session_start();

include("../config/db.php");
include("../models/BlogModel.php");

$blogModel = new BlogModel($conn);


// Create Blog
if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $content = $_POST['content'];

    $user_id = $_SESSION['user_id'];

    if($title != "" && $content != ""){

        $blogModel->insertBlog($user_id, $title, $content);

        header("location: ../views/blog/index.php");
    }
}


// Delete Blog
// DELETE BLOG
if(isset($_GET['delete'])){

    if(!isset($_SESSION['user_id'])){
        die("Login First");
    }

    $id = $_GET['delete'];

    // FIXED FUNCTION NAME
    $blog = $blogModel->getSingleBlog($id);

    // Admin can delete all blogs
    // Member can delete own blogs

    if($_SESSION['role'] == "admin" ||
       $_SESSION['user_id'] == $blog['user_id']){

        $blogModel->deleteBlog($id);
    }

    header("location: ../views/blog/index.php");
}
?>