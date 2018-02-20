<?php include 'includes/header.php'; ?>
<?php


if (isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
  $profile = "SELECT name, email, password, file, type, size, date_added FROM users WHERE name='$name'";
  $resultProfile = mysqli_query($con, $profile);

  if (mysqli_num_rows($resultProfile)) {
    while ($row = $resultProfile->fetch_assoc()) {
      echo "<div class=" . 'profile' .">";
        echo "<div class=" . 'profile-section' .">";
          echo "<img class=" . 'profile-image' . " src=" . 'uploads/profile/' . $row['file'] .">";
          echo "<h4> Username: ". $row['name'] ."</h4>";
          echo "<h4> Email: ". $row['email'] ."</h4>";
          echo "<button type=" . 'button' ." name=" . 'edit-hobby' ." class=" . 'edit-hobby' .">Edit my profile</button>";
        echo "</div>";
      echo "</div>";
    }
  }

  $profileHobbies = "SELECT hobby, fav_movie, fav_book, date_added FROM user_hobby WHERE email='$email'";
  $profileQuery = mysqli_query($con, $profileHobbies);

  if (mysqli_num_rows($profileQuery)) {
    while ($row = $profileQuery->fetch_assoc()) {
      echo "<div class=" . 'profile' .">";
        echo "<div class=" . 'profile-section' .">";
          echo "<h4> Hobby: ". $row['hobby'] ."</h4>";
          echo "<h4> Favorite Movie: ". $row['fav_movie'] ."</h4>";
          echo "<h4> Favorite Book: ". $row['fav_book'] ."</h4>";
        echo "</div>";
      echo "</div>";
    }
  }

}
?>


<form class="hobby-form close" style="width:320px;" action="" method="POST" enctype="multipart/form-data">
  <h4>Favorite hobby</h4>
  <input type="text" name="hobby" id="hobby" placeholder="Hobby">
  <br>
  <h4>Favorite movie</h4>
  <input type="text" name="movie" id="movie" placeholder="Movie">
  <br>
  <h4>Favorite book</h4>
  <input type="text" name="book" id="book" placeholder="Book">
  <br><br>
  <input type="submit" name="submitProfile" value="submit">
</form>


<?php

if (isset($_POST['submitProfile'])) {
  $hobby = mysqli_real_escape_string($con, $_POST['hobby']);
  $movie = mysqli_real_escape_string($con, $_POST['movie']);
  $book = mysqli_real_escape_string($con, $_POST['book']);
  $date = mysqli_real_escape_string($con, date("Y-m-d") );
  $email = $_SESSION['email'];


  $addQuery = "SELECT email FROM user_hobby WHERE email='$email'";
  $query = mysqli_query($con, $addQuery);

  if (mysqli_num_rows($query) == 0) {
    $queryInsert = mysqli_query($con, "INSERT INTO user_hobby(email, hobby, fav_movie, fav_book, date_added) VALUES ('$email','$hobby', '$movie', '$book', '$date')");
    if ($queryInsert) {
      echo "Registered";
    }else {
      echo "Something went wrong with insert";
    }
  }elseif (mysqli_num_rows($query) == 1) {
    $queryUpdate = mysqli_query($con, "UPDATE user_hobby SET hobby='$hobby', fav_movie='$movie', fav_book='$book', date_added='$date' WHERE email='$email'");

    if ($queryUpdate) {
      echo "Updated";
    }else {
      echo "Something went wrong with the update";
    }
  }


}
 ?>

 <?php include 'includes/footer.php'; ?>
