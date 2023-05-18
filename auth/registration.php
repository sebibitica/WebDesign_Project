<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
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
    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $query    = "INSERT into `users` (username, password, email)
                     VALUES ('$username', '" . md5($password) . "', '$email')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
    } else {
?>
    <main>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="text" class="login-input" name="email" placeholder="Email Adress">
        <input type="password" class="login-input" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
    </main>
<?php
    }
?>
    <footer>
        <p>&copy; 2023 Movie Shop Website. All rights reserved.</p>
    </footer>
</body>
</html>