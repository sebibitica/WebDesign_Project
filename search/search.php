<?php
// Check if the search term is provided
if (isset($_GET['search'])) {
  $searchTerm = $_GET['search'];

  // Create a database connection
  $conn = mysqli_connect('localhost', 'root', '', 'movieswebsite');

  // Check if the connection was successful
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Prepare the SQL query
  $query = "SELECT * FROM movies WHERE title LIKE '%" . $searchTerm . "%'";

  // Execute the query
  $result = mysqli_query($conn, $query);

  // Check if any rows were returned
  if (mysqli_num_rows($result) > 0) {
    // Output the results
    while ($row = mysqli_fetch_assoc($result)) {
      ?>
            <a class="movie" href="../movie/?id=<?php echo $row['id']; ?>">
              <img src="../<?php echo $row['img_dir']; ?>" class="image" />
              <div class="details">
                <h1><?php echo $row['title']; ?></h3>
                <h3><?php echo $row['director']; ?></h2>
              </div>
            </a>
      <?php
    }
  } else {
    echo "<p>No movies found.</p>";
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
