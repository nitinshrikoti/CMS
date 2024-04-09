<table class="table table-bordered table-hover">
    <thread>
        <tr>
            <td>Id</td>
            <td>Author</td>
            <td>Comments</td>
            <td>Email</td>
            <td>Status</td>
            <td>In Responsive to</td>
            <td>Date</td>
            <td>Approve</td>
            <td>Unapprove</td>
            <td>Delete</td>
        </tr>
    </thread>
    <tbody>
    <?php
    $select_comments = get_all_posts_user_comments();
    while($row = mysqli_fetch_assoc($select_comments)) {
        $comment_id             = $row['comment_id'];
        $comment_post_id        = $row['comment_post_id'];
        $comment_author         = $row['comment_author'];
        $comment_content        = $row['comment_content'];
        $comment_email          = $row['comment_email'];
        $comment_status         = $row['comment_status'];
        $comment_date           = $row['comment_date'];
        echo "<tr>";
            echo "<td> $comment_id </td>";
            echo "<td> $comment_author </td>";
            echo "<td> $comment_content </td>";
            echo "<td> $comment_email </td>";
            echo "<td> $comment_status </td>";

            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id    = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td> <a href='../post.php?p_id=$post_id'>$post_title</a> </td>";
            }

            echo "<td> $comment_date </td>";
            
            echo "<td> <a href='comments.php?source=user_comments&approve=$comment_id'>Approve</a> </td>";
            echo "<td> <a href='comments.php?source=user_comments&unapprove=$comment_id'>Unapprove</a> </td>"; 
            echo "<td> <a href='comments.php?source=user_comments&delete=$comment_id'>Delete</a> </td>"; 
            echo "</tr>";
    }
    ?>
    <?php
    if(isset($_GET['approve'])) {
        $the_comment_id = $_GET['approve'];
        $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = $the_comment_id";
        $approve_comment_query = mysqli_query($connection, $query);
        // Relodes the page
        header("Location: comments.php?source=user_comments");
    }

    if(isset($_GET['unapprove'])) {
        $the_comment_id = $_GET['unapprove'];
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id";
        $unapprove_comment_query = mysqli_query($connection, $query);
        // Relodes the page
        header("Location: comments.php?source=user_comments");
    }
    
    if(isset($_GET['delete'])) {
        $the_comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
        $delete_query = mysqli_query($connection, $query);
        // Relodes the page
        header("Location: comments.php?source=user_comments");
    }
    ?>
    </tbody>
</table>