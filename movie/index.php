<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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

    <main>
        <?php
            session_start();
            if(!isset($_GET['id'])){
                echo "<h1>Movie not found</h1>";
            }
            else{
                $movie=$_GET['id'];
                $con=mysqli_connect("localhost","root","","movieswebsite");
                if (!$con)
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $query = "SELECT * FROM movies WHERE id=$movie";
                $result = mysqli_query($con, $query);
                $row = mysqli_fetch_assoc($result);
        ?>
            <div class="container">
                <img src="../<?php echo $row['img_dir']; ?>" class="movieimg" />
                <div class="detalii">
                    <h1><?php echo $row['title']; ?></h1>
                    <br>
                    <br>
                    <h2>Description:</h2>
                    <br>
                    <div style="width:80%">
                        <?php echo '<h4 style="font-weight:500">'.$row['description'].'</h4>'; ?>
                    </div>
                    <br>
                    <br>
                    <h2>Release date: <?php echo '<h4 style="font-weight:500">'.$row['release_date'].'</h4>'; ?></h2>
                    <br>
                    <br>
                    <h2>Director: <?php echo '<h4 style="font-weight:500">'.$row['director'].'</h4>'; ?></h2>
                    <?php 
                        //see if the user has the movie in his favorites
                        $userid = isset($_SESSION['id']) ? $_SESSION['id'] : null;
                        if($userid !== null){
                            $checkQuery = "SELECT * FROM `moviesowned` WHERE user_id = ? AND movie_id = ?";
                            $checkStmt = $con->prepare($checkQuery);
                            $checkStmt->bind_param("ii", $userid, $movie);
                            $checkStmt->execute();
                            $checkResult = $checkStmt->get_result();
                            if ($checkResult->num_rows <= 0) {
                                echo '<img src="../movies_images/add.png" class="addbtn1" data-id="'.$row['id'].'"/>';
                            }
                        }
                    ?>
                </div>
            </div>

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
        $(".addbtn1").on("click",function(){
            console.log("bla");
            let movieid = $(this).data("id");
            let userid= <?php echo isset($_SESSION['id']) ? json_encode($_SESSION['id']) : 'null'; ?>;
            if(userid === null){
                alert("You need to login first");
            }
            else{
                $.ajax({
                url: "../scripts_php/add.php",
                type: "POST",
                data: {
                    movie_id: movieid,
                    user_id: userid
                },
                success: function(data){
                    location.reload();
                    alert("Movie added successfully");
                },
                error: function(){
                    alert(response);
               }
                });
            }
        });
        });
    </script>
</body>
</html>