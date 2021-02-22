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
<h1 class="bg-success"><img style="height:1.5em;" src="Img/invoere.png" class="rounded m-1 p-1" alt="Invoer">Invoer</h1>
<div class="container">
    <h3>Lees QR Kode</h3>
    <video style="max-width:300px; max-height:180px;display: block; margin: 0 auto;" id="qr-video"></video>
    <span id="cam-qr-result">scanning...</span>
</div>

<!-- Page Level Scripts -->
<script type="module">
//import plugins
import QrScanner from "./js/qr-scanner.min.js";
QrScanner.WORKER_PATH = './js/qr-scanner-worker.min.js';

//set defaults
const video = document.getElementById('qr-video');
const camQrResult = document.getElementById('cam-qr-result');

//run scan
function setResult(label, result) {
    var cn = result.split("(");
    label.innerHTML = '<h4> Werker: ' + result +
        ' gekies</h4><a href="user_InputData.php?User=' + cn[0] + '" class="btn btn-secondary">Stuur</a>';
    document.getElementById('memberName').value = result;

    label.style.color = 'orange';
    clearTimeout(label.highlightTimeout);
    label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
}

// ####### Web Cam Scanning #######
const scanner = new QrScanner(video, result => setResult(camQrResult, result));
scanner.start();
scanner.setInversionMode('original');
</script>
<?php
}
?>