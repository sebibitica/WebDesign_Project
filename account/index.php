<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account - Movie Shop Website</title>
  <link rel="stylesheet" href="account.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
  <header>
    <div class="logo">
      <a href="../"><img src="../logo.png" alt="Movies" /></a>
    </div>
    <nav>
      <ul>
        <li><a href="../search/">Search Movies</a></li>
        <li><a href="./">Account</a></li>
        <li><a href="../about/">About</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <?php
        session_start();
        $con = mysqli_connect("localhost","root","","movieswebsite");
        if(!$con){
            die("Connection failed: " . mysqli_connect_error());
        }

        if (!isset($_SESSION['username'])) {
            echo "<div class='form'>
                    <h3>You need to login first.</h3>
                    <p class='link'>Click here to <a href='../auth/login.php'>Login</a></p>
                </div>";
        }
        else{
            // get email from database and show it
            $query = "SELECT email FROM `users` WHERE username='" . $_SESSION['username'] . "'";
            $result = mysqli_query($con, $query) or die(mysql_error());
            $rows = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            $email = $row['email'];
            // get user id from database and show it
            $query = "SELECT id FROM `users` WHERE username='" . $_SESSION['username'] . "'";
            $result = mysqli_query($con, $query) or die(mysql_error());
            $rows = mysqli_num_rows($result);
            $row = mysqli_fetch_assoc($result);
            $userid = $row['id'];
?>
          <section class='profile'>
            <div class='detailsandlogout'>
              <img class="profileimg" src='../movies_images/profile.png' alt='profile' />
              <div class='profile-details'>
                <h3>Name:</h3><?php echo "<h4> {$_SESSION['username']}</h4>"; ?> 
                <br>
                <h3>Email:</h3> <?php echo " <h4> $email </h4> ";?> 
              </div>
              <div class='profile-buttons'>
                <a href='../auth/logout.php'>
                  <img class="logoutbtn" src='../movies_images/logout.png' alt='logout' />
                </a>
              </div>
            </div>
          </section>
        <section class="favmovies">
          <h2>Your Movies:</h2>
          <div class="movie-list">
          <?php
            $query = "SELECT movies.* FROM movies
                      INNER JOIN moviesowned ON movies.id = moviesowned.movie_id
                      WHERE moviesowned.user_id = '$userid'";
            $result = mysqli_query($con, $query);
    
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <a href="../movie/?id=<?php echo $row['id']; ?>" class="movie">
            <img src="../<?php echo $row['img_dir']; ?>" class="image"/>
            <div class="detbtn">
              <div class="details">
                  <div class="nameofmovie">
                    <h1><?php echo $row['title']; ?></h3>
                  </div>
                  <div class="director">
                    <h4>Director:</h4>
                    <h3><?php echo $row['director']; ?></h2>
                  </div>
              </div>
              <img src="../movies_images/remove.png" class="addbtn" data-id="<?php echo $row['id']; ?>"/>
            </div>
            </a>
        <?php endwhile; ?>
          </div>
        </section>
<?php
        }
    ?>
    <?php
          mysqli_close($con);
        ?>
  </main>
  <footer>
    <p>&copy; 2023 Movie Shop Website. All rights reserved.</p>
  </footer>
  <script>
    $(document).ready(function(){
      $(".addbtn").on("click",function(){
        event.preventDefault();
        let movieid = $(this).data("id");
        let userid= <?php echo $userid; ?>;
        $.ajax({
          url: "../scripts_php/remove.php",
          type: "POST",
          data: {
            movie_id: movieid,
            user_id: userid
          },
          success: function(data){
            location.reload();
          },
          error: function(){
            alert(response);
          }
        });
      });
    });
  </script>
</body>

</html>