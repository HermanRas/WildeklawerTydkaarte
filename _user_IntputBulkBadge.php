<?php

    #################################################################
    ## show QR Code for printing
    #################################################################
$qr = '';
if(isset($_GET['qr'])){
    $qr = $_GET['qr'];
    $sql = "SELECT * from workers 
            where CN='$qr' 
            limit 1";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $res = sqlQuery($sql, $sqlargs);
?>

<!-- section-block -->
<div class="container">
    <div class="card">
        <form action="user_InputSelect.php">
            <div class="card-body">
                <h2>QR vir Werker Nommer: <span class="text-inline"
                        id="QrID"><?php echo $qr . " (".$res[0][0]['naam']." ".$res[0][0]['van'].")"; ?></span>
                </h2>
                <section id="qr-code">
                </section>
                <input class="btn btn-success" type="button" value="Druk" onclick="PrintElem()">
                <input class="btn btn-primary" type="submit" value="Kanselleer">
            </div>
        </form>
    </div>
</div>

<?php
}else{
?>
<!-- 
    #################################################################
    ## show camera and Code if found
    #################################################################
 -->
<form action="user_InputBulkClock.php" method="post">
    <h1 class="bg-wk"><img style="height:1.5em;" src="Img/klok.png" class="rounded m-1 p-1" alt="Klok">Massa Klok</h1>
    <div class="container">
        <h3>Lees al die QR Kodes</h3>
        <video style="max-width:300px; max-height:180px;display: block; margin: 0 auto;" id="qr-video"></video>
        <br>
        <h3 class="bg-primary p-1 m-1">Werker Lys:</h3>
        <ul class="text-xs bg-white" id="cam-qr-result"></ul>
        <div id="butDiv"></div>
    </div>
</form>
<script>
// clearItem if error
function clearItem(e) {
    console.log(e.parentElement.parentElement.removeChild(e.parentElement));
}
</script>

<!-- Page Level Scripts -->
<script type="module">
//import plugins
import QrScanner from "./js/qr-scanner.min.js";
QrScanner.WORKER_PATH = './js/qr-scanner-worker.min.js';

//set defaults
const video = document.getElementById('qr-video');
const camQrResult = document.getElementById('cam-qr-result');
var lastResult = '';

//run scan
function setResult(label, result) {
    if (lastResult == result) {
        scanner.start();
    } else {
        lastResult = result;
        var cn = result.split(":");
        label.innerHTML =
            '<li>' +
            '<input type="hidden" name="CN[]" value="' + cn[0] + '">' +
            '<input type="hidden" name="name[]" value="' + result + '">' +
            result +
            '<input type="button" class="btn-sm btn-close" onclick="clearItem(this);" >' +
            '</li>' +
            label.innerHTML;
        document.getElementById('butDiv').innerHTML = '<button href="user_InputClock.php?User=' + cn[0] +
            '" class="btn btn-secondary">Stuur</button>';

        label.style.color = 'orange';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
        scanner.start();
    }
}


// ####### Web Cam Scanning #######
const scanner = new QrScanner(video, result => setResult(camQrResult, result));
scanner.start();
scanner.setInversionMode('original');
</script>
<?php
}
?>