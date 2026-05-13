<?php
session_start();

include("../../config/db.php");
include("../../models/BlogModel.php");


// TEMP SESSION
$_SESSION['user_id'] = 3;
$_SESSION['role'] = "admin";


$blogModel = new BlogModel($conn);

$blogs = $blogModel->getAllBlogs();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Blog Page</title>

    <style>

        body{
            font-family: Arial;
            background-color: #f2f2f2;
        }

        .container{
            width: 70%;
            margin: auto;
        }

        .blog-box{
            background: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
        }

        input, textarea{
            width: 100%;
            padding: 10px;
        }

        textarea{
            height: 100px;
        }

        button{
            padding: 10px 20px;
            cursor: pointer;
        }

        a{
            color: red;
            text-decoration: none;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Blog Page</h1>

    <!-- BLOG FORM -->

    <?php if(isset($_SESSION['user_id'])){ ?>

    <form method="POST"
          action="../../controllers/BlogController.php"
          onsubmit="return validateForm()">

        <input type="text"
               name="title"
               id="title"
               placeholder="Enter Blog Title">

        <br><br>

        <textarea name="content"
                  id="content"
                  placeholder="Write Your Experience"></textarea>

        <br><br>

        <button type="submit" name="submit">
            Post Blog
        </button>

    </form>

    <?php } ?>


    <!-- SHOW BLOGS -->

    <?php while($blog = mysqli_fetch_assoc($blogs)){ ?>

    <div class="blog-box">

        <h2>
            <?php echo $blog['title']; ?>
        </h2>

        <p>
            <b>Author:</b>
            <?php echo $blog['name']; ?>
        </p>

        <p>
            <?php echo $blog['content']; ?>
        </p>

        <p>
            <?php echo $blog['created_at']; ?>
        </p>


        <?php

        if(isset($_SESSION['user_id'])){

            if($_SESSION['role'] == "admin" ||
               $_SESSION['user_id'] == $blog['user_id']){

        ?>

        <a onclick="return confirm('Delete this blog?')"
           href="../../controllers/BlogController.php?delete=<?php echo $blog['id']; ?>">

            Delete

        </a>

        <?php }} ?>

    </div>

    <?php } ?>

</div>


<script>

function validateForm(){

    let title = document.getElementById("title").value;
    let content = document.getElementById("content").value;

    if(title.trim() == "" || content.trim() == ""){

        alert("All fields are required");
        return false;
    }

    return true;
}

</script>

</body>
</html>