<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style_auth.css"/>
</head>
<body>
    <header>
    <a href="../"><img class="logo" src="../logo.png" alt="Movies" /></a>
    <nav>
      <ul>
        <li><a href="../search/">Search Movies</a></li>
        <li><a href="../account/">Account</a></li>
        <li><a href="../about/">About</a></li>
      </ul>
    </nav>
  </header>
<?php
    session_start();
    $con = mysqli_connect("localhost","root","","movieswebsite");
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }
    if(isset($_SESSION['username'])){
        header("Location: ../account/");
        exit();
    }
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $query    = "SELECT * FROM `users` WHERE username='$username'
                     AND password='" . md5($password) . "'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['id'] = mysqli_fetch_assoc($result)['id'];
            header("Location: ../account/");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Username/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {

  echo '<main>
  <form class="form" method="post" name="login">
      <h1 class="login-title">Login</h1>
      <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
      <input type="password" class="login-input" name="password" placeholder="Password"/>
      <input type="submit" value="Login" name="submit" class="login-button"/>
      <p class="link"><a href="registration.php">New Registration</a></p>
  </form>
  </main>';
    }
?>
    <footer>
        <p>&copy; 2023 Movie Shop Website. All rights reserved.</p>
    </footer>
</body>
</html>