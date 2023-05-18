<!DOCTYPE html>
<html>

<head>
  <title>Movie Shop & Review</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
  <header>
    <img src="logo.png" class="logo"/>
    <nav>
      <ul>
        <li><a href="search/">Search Movies</a></li>
        <li><a href="account/">Account</a></li>
        <li><a href="about/">About</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h1>Welcome!</h1>

    <section class="movies">
      <br>
      <h2>Here are the top Movies:</h2>
      <div class="movie-list">
        <?php
        
        $con=mysqli_connect("localhost","root","","movieswebsite");
        if (!$con)
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $query = "SELECT * FROM movies";
        $result = mysqli_query($con, $query);

        // Step 3: Display movies dynamically
        while ($row = mysqli_fetch_assoc($result)):
        ?>
        <a class="movie" href="movie/?id=<?php echo $row['id']; ?>">
            <img src="<?php echo $row['img_dir']; ?>" class="image"/>
              <div class="details">
                  <div class="nameofmovie">
                    <h1><?php echo $row['title']; ?></h3>
                  </div>
                  <div class="director">
                    <h4>Director:</h4>
                    <h3><?php echo $row['director']; ?></h2>
                  </div>
              </div>
        </a>
        <?php endwhile; ?>

        <?php
          mysqli_close($con);
        ?>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2023 Movie Shop Website. All rights reserved.</p>
  </footer>
</body>

</html>