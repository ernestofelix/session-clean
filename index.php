<?php
    session_start();
    echo session_status();
	if ($_SERVER['HTTP_HOST'] == 'localhost')
	{
		define('HOST', 'localhost');
		define('USER', 'root');
		define('PASS', '1550');
		define('DB', 'food');
	}
	else
	{
		define('HOST', 'sql313.epizy.com');
		define('USER', 'epiz_33379676');
		define('PASS', 'Childofgod14');
		define('DB', 'epiz_33379676_food');
	}
    function connectToDB()
    {
        $conn = mysqli_connect(HOST,USER,PASS,DB);
        return $conn;
    }
    
    $form ='<form action="" method="POST">
                <div class="input-group my-3">
                    <span class="input-group-text">Username</span>
                    <input type="text" name="username" class="form-control">
                </div>
                <div class="input-group my-3">
                    <span class="input-group-text" >Password</span>
                    <input type="password" name="password" class="form-control">
                </div>
                <input type="reset" class="btn btn-secondary btn-lg" value="Reset">
                <input type="submit" class="btn btn-secondary btn-lg" name="submit-form" value="Submit">
            </form>';
    function checkPassword($user, $pass)
    {
    $conn = connectToDB();
    $query = "SELECT USERNAME, PASSWORD FROM USERS;";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result))
        {
            if ($row['USERNAME'] == $user && $row['PASSWORD'] == $pass) return 1;
        }
    mysqli_close($conn);
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        header('location: index.php');
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Insecure Assignment</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark">
            <div class="container-fluid bg-dark ">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav center">
                        <li class="nav-item bg-light rounded">
                            <a class="nav-link nav-text" name="home" href="index.php">Home</a>
                        </li>
                        <li class="nav-item bg-light mx-1 rounded">
                            <a class="nav-link" name="logout" href="index.php">Log Out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="background position-relative">
            <div class="box position-absolute top-50 start-50 translate-middle">
            <?php
            echo $_SERVER['REQUEST_METHOD'];
            if ($_SERVER['REQUEST_METHOD'] == 'POST') 
                {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    if(checkPassword($username, $password) == 1)
                        {
                            
                            echo "<h1 class='mb-4'>Access Granted</h1>";
                            echo "<table class='table table-light table-striped'>";
                            echo "<tr>";
                            echo "<th>Agent</th>";
                            echo "<th>Code Name</th>";
                            echo "</tr>";
                            $fs = fopen('includes/fbi.txt', 'r');
                            $content = fread($fs, filesize('includes/fbi.txt'));
                            $agents = explode('||>><<||', $content);
                            foreach($agents as $agentName)
                            {
                                $code = explode(",", $agentName);
                                echo "<tr>";
                                    foreach($code as $codeName)
                                    {
                                        echo "<td>$codeName</td>";
                                    }
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    else
                        {
                            echo "<h1 class='mb-4'>Access Denied</h1>";
                            echo "<h2 class='mb-4'>Try Again</h2>";
                            echo $form;
                        }
                }
            else
                {
                    echo $form;
                }
            ?>
            </div>
        </div>
    </body>
</html>