<?php
function _connectMySQL($setLocalOrOnlineDB)
{
    global $typeOfDB;
    $local = $setLocalOrOnlineDB;
    if($_SERVER['SERVER_NAME'] == 'localhost')
    {
        if($local)
        {
            #Lokalna Baza Danych
            $servername = 'localhost';
            $username = 'root';
            $password = 'root';
            $db = 'chat';
            $typeOfDB = "Lokalna Baza Danych";
        }
        else
        {
            #Remote
            $servername = '';
            $username = '';
            $password = '';
            $db = '';
            $typeOfDB = "";
        }
    }
    else
    {
        #Remote
        $servername = '';
        $username = '';
        $password = '';
        $db = '';
        $typeOfDB = "";
    }

    $conn = new mysqli($servername, $username, $password,$db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function _downloadUsersDataFromPsiToJSON()
{
    global $conn;
    $query = "SELECT id,Name,Imie,Nazwisko,Picture FROM psi";
    $sth = mysqli_query($conn,$query);
    //echo "Error: ".$query."<br>".mysqli_error($conn);
    $rows = array();
    while($r = mysqli_fetch_assoc($sth)) {
         $rows[] = $r;
    }
    return json_encode($rows);
}

function _addUserToPsiDB($name,$imie,$nazwisko,$picture)
{
    global $conn;
    $sql = "INSERT INTO psi (name,imie,nazwisko,picture) VALUES ('$name','$imie','$nazwisko','$picture');";
    if(!(mysqli_query($conn,$sql)))
	{
        echo "Error: ".$sql."<br>".mysqli_error($conn);
	}
}

function _delUserFromPsiDB($id)
{
    global $conn;
    $query = "SELECT Picture FROM psi Where psi.id = $id";
    $sql = "DELETE FROM psi WHERE psi.id = $id";
    if(!(mysqli_query($conn,$sql)))
	{
        echo "Error: ".$sql."<br>".mysqli_error($conn);
	}
}

?>
