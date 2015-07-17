<?php
session_start();
require_once('new_connection.php');

if(!isset($_SESSION['user']))
{
    header('location:index.php');
    die();
}
?>



<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sample Bootstrap Site</title>
        <!-- Personal styling -->
        <link rel="stylesheet" type="text/css" href="index.css">

        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <!-- bootstrap javascript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- put your content here -->
        <div class='container-fluid the_wall'>
            <div class='row rowOne'>
                <div class='col-md-8 title'>
                    <h1>Coding Dojo Wall</h1>
                </div>
                <div class='col-md-2 title'>
                    <h3>
                        <?php
                            echo 'Welcome '.$_SESSION['user']['first_name'].'!';
                        ?>
                    </h3>
                </div>
                <div class='col-md-2 headerBoxes'>
                    <form id='logout' class='form-inline' action='process.php'method='POST'>
                        <div class='form-group'>
                            <label for='logout'></label>
                            <input type="hidden" class="form-control" name="action" value='logout'>
                        </div>
                        <button type="submit" class="btn btn-default">Log Out</button>
                    </form>
                </div>
            </div>
            <div class='row rowTwo'>
                <div class='col-md-2'></div>
                <div class='col-md-8'>
                    <form action='process.php'method='POST'>
                        <label for='message'><h3>Post a Message</h3></label>
                        <input type="hidden" class="form-control" name="action" value='message'>
                        <textarea name='message' class="form-control"></textarea>
                        <button type="submit" class="btn btn-default">Post a message</button>
                    </form>
                </div>
            </div>
            <?php
                // create tables
            // date_format(messages.created_at,'%h%:%i%p %M %d %Y')
                //create messages table
                $query="SELECT users.id as 'u_id', users.first_name, users.last_name, date_format(messages.created_at,'%h%:%i%p %M %d %Y') AS 'time', messages.message, messages.id FROM messages LEFT JOIN users ON users.id=messages.user_id ORDER BY messages.created_at desc";

                $_SESSION['messages']=fetch($query);

                //create comments table
                // date_format(messages.created_at,'%h%:%i%p %M %d %Y')
                $query="SELECT users.id AS 'u_id', users.first_name, users.last_name, messages.id AS 'm_id', messages.message, date_format(messages.created_at,'%h%:%i%p %M %d %Y') AS 'm_c',  comments.id AS 'c_id', comments.comment, comments.created_at AS 'c_c'
                        FROM comments 
                        LEFT JOIN messages ON messages.id=comments.message_id
                        RIGHT JOIN users on comments.user_id=users.id";

                $_SESSION['comments']=fetch($query);

                //finish creating tables

                //var_dumps
                // echo 'messages<br>';
                // var_dump($_SESSION['messages']);
                // echo '<br><br>comments<br>';
                // var_dump($_SESSION['comments']);
                // echo '<br>';

                //create divs!!!

                if(COUNT($_SESSION['messages'])>0)
                {
                    foreach($_SESSION['messages'] as $message)
                    {
                        // echo each message

                        echo '<div class="row rowMessages">
                            <div class="col-md-2"></div>
                            <div class="col-md-8 messageBox">';

                        echo '<div class="row messageHead">';

                        echo '<h4>'.$message['first_name'].' '.$message['last_name'].' - '.$message['time'].'</h4>';
                        echo '<div class="row"><div class="col-md-10"><p>'.$message['message'].'</p>';

                        //create delete button
                        if($_SESSION['user']['id'] == $message['u_id'])
                        {
                            echo "<div class='col-md-2'><form id='delete' action='process.php'method='POST'>";
                            echo "<input type='hidden' name='action' value='delete'>";
                            echo "<input type='hidden' name='message_id' value='".$message['id']."'>";
                            echo "<input type='hidden' name='user_id' value='".$message['u_id']."'>";
                            echo "<button type='submit' class='btn btn-default'>Delete</button>";
                            echo "</form></div>";
                        }
                        //finish creating delete button

                        echo '</div></div></div>';

                        if(COUNT($_SESSION['comments'])>0)
                        {
                            echo '<div class="row commentBox">';
                            echo '<div class="col-md-1"></div>';
                            echo  '<div class="col-md-10 commentTexts">';
                            
                            foreach($_SESSION['comments'] as $comment)
                            // echo each comment
                            {
                                if($comment['m_id']==$message['id'])
                                {
                                    echo '<h4>'.$comment['first_name'].' '.$comment['last_name'].' - <span>'.$comment['m_c'].'</span></h4>';
                                    echo '<p>.'.$comment['comment'].'</p>';
                                }
                            // finish echo comments
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                        $_SESSION['message_id']=$message['id'];

                        //create comment buttons
                        echo '<div class="row rowMessages">';
                        echo '<div class="col-md-1"></div>';
                        echo  '<div class="col-md-10">';

                        echo "<form action='process.php'method='POST'>";
                        echo "<input type='hidden' name='action' value='comment'>";
                        echo "<input type='hidden' name='message_id' value='".$_SESSION['message_id']."'>";
                        echo "<textarea name='comment' class='form-control'></textarea>";
                        echo "<button type='submit' class='btn btn-default'>Post a comment</button>";
                        echo "</form>";

                        echo '</div>';
                        echo '</div>';

                        echo '</div></div>';
                        //finish echo messages
                    }
                    
                }
            ?>
        </div>
    </body>
</html>