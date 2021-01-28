<?php

    #################################################################
    ## show QR Code for printing
    #################################################################
$qr = '';
            if(isset($_GET['CN'])){
                $CN = $_GET['CN'];
                $sql = "SELECT
            worklog.logDate,
            workers.naam,
            workers.van,
            workers.CN,
            worklog.farm_id,
            worklog.produce_id,
            worklog.spry_id,
            worklog.task_id,
            SUM(worklog.crates) as 'crates'
            From
            workers Left Join
            worklog On workers.id = worklog.worker_id
            Where
            worklog.logDate = CurDate()
            and CN = '$CN'
            Group By
            worklog.logDate, workers.naam, workers.van, workers.CN, worklog.farm_id,
            worklog.produce_id, worklog.spry_id, worklog.task_id
            limit 1";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $res = sqlQuery($sql, $sqlargs);
    $kratte = $res[0][0]['crates'];
?>

<!-- section-block -->
<div class="container">
    <div class="card">
        <form action="user_InputCheckBins.php">
            <div class="card-body">
                <h2>QR vir Werker Nommer: <span class="text-inline"
                        id="QrID"><?php echo $qr . " (".$res[0][0]['naam']." ".$res[0][0]['van'].")"; ?></span>
                </h2>
                <h1 class="text-success text-center" style="font-size:10rem;"><?php echo $kratte; ?></h1>
                <input class="btn btn-primary" type="submit" value="Soek Weer">
            </div>
        </form>
    </div>
</div>

<!-- script to open picture in print window -->
<script>
function PrintElem() {
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    var canvas = document.getElementById('YourQRCode');
    var img = canvas.toDataURL("image/png");
    mywindow.document.write('<img src="' + img + '"/>');
    mywindow.document.write('</body></html>');

    var now = new Date().getTime();
    while (new Date().getTime() < now + 2000) {
        /* do nothing */
    }
    mywindow.focus(); // necessary for IE >= 10*/
    mywindow.print();
    return true;
}
</script>

<!-- Load QR Code rendering Module -->
<script type="module">
import QrCode from './js/qr-code.min.js';

function readSettings() {
    let settings = {};
    settings.radius = '0';
    settings.ecLevel = 'H';
    settings.fill = '#000000';
    settings.background = null;
    settings.size = 250;
    settings.text = document.getElementById('QrID').innerText;
    return settings;
}
</script>

<?php
}else{
?>
<!-- 
    #################################################################
    ## show camera and Code if found
    #################################################################
 -->
<h1 class="bg-dark"><img style="height:1.5em;" src="Img/invoere.png" class="rounded m-1 p-1" alt="Invoer">Soek Bins
</h1>
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
        ' gekies</h4><a href="user_InputCheckBins.php?CN=' + cn[0] + '" class="btn btn-secondary">Stuur</a>';
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