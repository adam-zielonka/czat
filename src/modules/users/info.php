<div class="tekst">
  <h1>Info o user</h1>
  <?php
    global $conn;
    $sql = "SELECT login, email, picture FROM users Where login = '".$_SESSION["login"]."';";
    $result = mysqli_query($conn,$sql);
    $row = $result->fetch_array(MYSQLI_NUM);
    echo $row[0]."<br>";
    echo $row[1]."<br>";
    echo '<img src="'.$row[2].'" alt="'.$_SESSION["login"].'" width="200" />';
  ?>
</div>
