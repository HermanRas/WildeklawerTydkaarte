 <div class="container">
     <?php

    $day = 0;

if (isset($_GET['day'])){
    $day = $_GET['day'];
}

    $date_raw = date("Y-m-d H:i:s");
    echo "<h1>". date('Y-m-d', strtotime("-$day day", strtotime($date_raw))) . "</h1>";
    
?>
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
 </div>