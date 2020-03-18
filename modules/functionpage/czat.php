<?php
    
    function _downloadCzat($last)
    {
        global $conn;
        if($last == 0)
            $query = "SELECT id,time,user,msg 
                      FROM czat 
                      WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 1 HOUR)) AND timestamp(NOW());";
        else
            $query = "SELECT id,time,user,msg 
                      FROM czat 
                      WHERE id>'$last'";
        $sth = mysqli_query($conn,$query);
        $rows = array();
        while($r = mysqli_fetch_assoc($sth)) {
            $rows[] = $r;
        }
        return json_encode($rows);
    }
    
    function _downloadUsersOnline()
    {
        global $conn;
        $query = "SELECT user FROM online WHERE time BETWEEN timestamp(DATE_SUB(NOW(), INTERVAL 5 SECOND)) AND timestamp(NOW());";
        $sth = mysqli_query($conn,$query);
            $rows = array();
            while($r = mysqli_fetch_assoc($sth)) {
                 $rows[] = $r;
            }
            return json_encode($rows);
    }
    
    function _createUserOnline() {
        $user = $_SESSION["login"];
        global $conn;
        $sql = "INSERT INTO online (user) VALUES ('$user');";
        if(!(mysqli_query($conn,$sql)))
        {
            echo "Error: ".$sql."<br>".mysqli_error($conn);
        }
    }
    
    function _updateUserOnline()
    {
        global $conn;
        $user = $_SESSION["login"];
        $query = "SELECT user FROM online WHERE user = '$user'";
        $sth = mysqli_query($conn,$query);
        $num_rows = mysqli_num_rows($sth);
        if($num_rows != 0)
        {
            $sql = "UPDATE online SET time=timestamp(NOW()) WHERE user = '$user'";
            $sth = mysqli_query($conn,$sql);
        }
        else
        {
            _createUserOnline();
        }
    }
    
    
    if(isset($_POST['nr']) && isset($_SESSION["login"]))
    {
        $nr = addslashes($_POST['nr']);
        _updateUserOnline();
        echo '{"users":';
        echo _downloadUsersOnline();
        echo ',"msg":';
        echo _downloadCzat($nr);
        echo '}';            
    }
    
?>
