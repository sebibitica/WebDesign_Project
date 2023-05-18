<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Shop Website</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header>
    <div class="logo">
      <a href="./"><img src="logo.png" alt="Movies" /></a>
    </div>
    <nav>
      <ul>
        <li><a href="search/">Search</a></li>
        <li><a href="account/">Account</a></li>
        <li class="dropdown">
          <a href="about/">About</a>
          <div class="dropdown-content">
            <a href="about/">About Us</a>
            <a href="about/movies.html">About Movies</a>
          </div>
        </li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="welcome">
      <text class="welcome-title">Welcome to Movie Shop!</text>
      <span style="font-size:36px">📽️</span>
    </div>
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
  <script>
    const title = document.querySelector('.welcome-title');
    const text = title.textContent;
    const letters = text.split('');

    const coloredText = letters.map(letter => `<span>${letter}</span>`).join('');
    title.innerHTML = coloredText;

  </script>
</body>

</html>