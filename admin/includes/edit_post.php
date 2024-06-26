<?php

// Displaying data on the form
if(isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}
$query = "SELECT * FROM posts WHERE post_id=$the_post_id ";
$select_posts_by_id = mysqli_query($connection, $query);

// Below values are used in the form using php tag
while($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id            = $row['post_id'];
    $post_user          = $row['post_user'];
    $post_title         = $row['post_title'];
    $post_category_id   = $row['post_category_id'];
    $post_status        = $row['post_status'];
    $post_image         = $row['post_image'];
    $post_content       = $row['post_content'];
    $post_tags          = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date          = $row['post_date'];
}

// Checking for submit and updatating the values in the database
if(isset($_POST['update_post'])) {
    $post_title         = $_POST['post_title'];
    $post_user          = $_POST['post_user'];
    // $user_id            = get_user_id();
    $post_category_id   = $_POST['post_category'];
    $post_status        = $_POST['post_status'];
    $post_image         = $_FILES['image']['name'];
    $post_image_temp    = $_FILES['image']['tmp_name'];
    $post_tags          = $_POST['post_tags'];
    $post_content       = $_POST['post_content'];
    
    move_uploaded_file($post_image_temp, "../images/$post_image"); 
    
    if(empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    // Update Query
    $query = "UPDATE posts SET ";
    $query .= "post_title       = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    // $query .= "user_id          = '{$user_id}', ";
    $query .= "post_date        = now(), ";
    $query .= "post_user        = '{$post_user}', ";
    $query .= "post_status      = '{$post_status}', ";
    $query .= "post_tags        = '{$post_tags}', ";
    $query .= "post_content     = '{$post_content}', ";
    $query .= "post_image       = '{$post_image}' ";
    $query .= "WHERE post_id    = {$the_post_id} ";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);
    
    if(is_admin()) {
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'> View Post </a> OR <a href='posts.php'>Edit More Post</a></p>";
    } else {
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'> View Post </a> OR <a href='posts.php?source=user_posts'>Edit More Post</a></p>";
    }
}

?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" value="<?php echo $post_title; ?>" name="post_title" id="" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Category</label>
        <select name="post_category" id="post_category">
            <?php
            $query = "SELECT * FROM categories ";
            $select_categories = mysqli_query($connection, $query);
            confirmQuery($select_categories);

            while($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                
                if($cat_id == $post_category_id) {
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }
            ?>
            
        </select>
    </div>
    <div class="form-group">
        <label for="">Post Status</label>
        <select name="post_status" id="">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            <?php 
            if($post_status == 'published') {
                echo "<option value='draft'>Draft</option>";
            } else if(is_admin()) {
                echo "<option value='published'>Publish</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Users</label>
        <select name="post_user" id="">
            <?php
            echo "<option value='{$post_user}'>{$post_user}</option>";
            $query = "SELECT * FROM users ";
            $select_users = mysqli_query($connection, $query);

            confirmQuery($select_users);
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img width="100" src="../images/<?php echo $post_image ?>" alt="">
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" value="<?php echo $post_tags; ?>" name="post_tags" id="" class="form-control">
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="summernote" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Update Post" name="update_post" class="btn btn-primary">
    </div>
    

</form>