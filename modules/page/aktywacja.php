<div class="tekst">
    <h1>Aktywacja</h1>
    <?php
        if(isset($_GET["kod"]) && isset($_GET["user"]))
        {
            $kodaktywacji = addslashes($_GET["kod"]);
            $user = addslashes($_GET["user"]);


            global $conn;
            $sql = "SELECT email FROM users Where login = '$user';";
            $result = mysqli_query($conn,$sql);
            $row = $result->fetch_array(MYSQLI_NUM);

            $kodaktywacji2 = md5($row[0] + $user);
            if(mysqli_num_rows($result) == 0)
            {
               echo 'Urzytkownik nie istnieje :-(';
            }
            else
            {
                    $sql = "SELECT aktywacja FROM users Where login = '$user';";
                    $result2 = mysqli_query($conn,$sql);
                    $row2 = $result2->fetch_array(MYSQLI_NUM);
                    if($row2[0] == 0)
                    {
                        if($kodaktywacji2 == $kodaktywacji)
                        {
                            $sql = "UPDATE users SET aktywacja = '1' WHERE login = '$user';";
                            if(!(mysqli_query($conn,$sql)))
                            {
                                echo "Wewnętrzny błąd aktywacji :-(";
                            }
                            else
                            {
                                echo 'Konto zostało aktywowane :-)';
                            }
                        }
                        else
                        {
                            echo 'Zły kod aktywacji :-(';
                        }
                    }
                    else
                    {
                        echo 'Konto można aktywować tylko raz :-)';
                    }

            }
        }
        else
        {
            echo 'Nie mam nic do aktywowania :-(';
        }
    ?>
</div>