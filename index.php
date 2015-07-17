<?php
session_start();
require_once('new_connection.php');
if(isset($_SESSION['user']))
{
    header('location:the_wall.php');
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
    <div class='container-fluid'>
        <div class='row rowOne'>
            <div class='col-md-7 title'>
                <h1>Coding Dojo</h1>
            </div>
            <div class='col-md-5 headerBoxes'>
                <form id='login' class='form-inline' action='process.php' method='POST'>
                    <div class='form-group'>
                        <label for='login'></label>
                        <input type="hidden" class="form-control" name="action" value='login'>
                    </div>
                    <div class='form-group'>
                        <!-- <label for='email'></label> -->
                        <input type="text" class="form-control" name="email" placeholder='email'>
                    </div>
                    <div class='form-group'>
                        <!-- <label for='password'></label> -->
                        <input type="password" class="form-control" name="password">
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>
        </div>
        <div class='row rowTwo'>
            <div class='col-md-2'></div>
            <div class='col-md-3 ninja'>
                <img src="black.png" alt="ninja pic">
            </div>
            <div class='col-md-2 newNinja'>
                <?php
                    if(isset($_SESSION['success']))
                    {
                        echo $_SESSION['success'];
                        echo '<img src="black.png" alt="new ninja pic">';
                    }
                    unset($_SESSION['success']);
                ?>
            </div>
            <div class='col-md-4 signUp'>
                <h1>Sign Up</h1>
                <form class="form-inline" action='process.php' method='POST'>
                  <div class='form-group'>
                    <label for='sign_up'></label>
                    <input type="hidden" class="form-control" name="action" value='sign_up'>
                  </div>
                  <div class="form-group half">
                    <label for="">First Name
                        <?php
                            if(isset($_SESSION['errors']['first_name']))
                            {   
                                echo $_SESSION['errors']['error'];
                            }
                        ?>
                    </label>
                    <input type="first_name" name='first_name' class="form-control" placeholder="First Name">
                  </div>
                  <div class="form-group half">
                    <label for="">Last Name
                        <?php
                            if(isset($_SESSION['errors']['last_name']))
                            {   
                                echo $_SESSION['errors']['error'];
                            }
                        ?>
                    </label>
                    <input type="last_name" name='last_name' class="form-control" placeholder="Last Name">
                  </div>
                  <div class="form-group full">
                    <label for="">Email
                        <?php
                            if(isset($_SESSION['errors']['email']))
                            {   
                                echo $_SESSION['errors']['error'];
                            }
                        ?>
                    </label>
                    <input type="email" name='email' class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group full">
                    <label for="">Password
                        <?php
                            if(isset($_SESSION['errors']['password']))
                            {   
                                echo $_SESSION['errors']['error'];
                            }
                        ?>
                    </label>
                    <input type="password" name='password' class="form-control">
                  </div>
                  <div class="form-group full">
                    <label for="">Confirm Password
                        <?php
                            if(isset($_SESSION['errors']['confirm_password']))
                            {   
                                echo $_SESSION['errors']['error'];
                            }
                            unset($_SESSION['errors']);
                        ?>
                    </label>
                    <input type="password" name='confirm_password' class="form-control">
                  </div>
                  <button type="submit" id='register' class="btn btn-default">Sign Up</button>
                </form>
            </div>
            <!-- <div class='col-md-2'></div> -->
        </div>
    </div>
</body>
</html>