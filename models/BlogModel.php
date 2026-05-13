<?php

class BlogModel{

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Insert Blog
    public function insertBlog($user_id, $title, $content){

        $sql = "INSERT INTO blogs(user_id, title, content)
                VALUES('$user_id', '$title', '$content')";

        return mysqli_query($this->conn, $sql);
    }

    // Show All Blogs
    public function getAllBlogs(){

        $sql = "SELECT blogs.*, users.name
                FROM blogs
                JOIN users
                ON blogs.user_id = users.id
                ORDER BY blogs.id DESC";

        return mysqli_query($this->conn, $sql);
    }

    // Get Single Blog
    public function getSingleBlog($id){

        $sql = "SELECT * FROM blogs WHERE id='$id'";

        $result = mysqli_query($this->conn, $sql);

        return mysqli_fetch_assoc($result);
    }

    // Delete Blog
    public function deleteBlog($id){

        $sql = "DELETE FROM blogs WHERE id='$id'";

        return mysqli_query($this->conn, $sql);
    }
}

?>