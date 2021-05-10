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
                        SUM(worklog.crates) as 'crates'
                        From
                        workers Left Join
                        worklog On workers.id = worklog.worker_id
                        Where
                        worklog.logDate = CurDate()
                        and CN = '$CN'
                        Group By
                        worklog.logDate, workers.naam, workers.van, workers.CN
                        limit 1";
    require_once 'config/db_query.php';
    $sqlargs = array();
    $res = sqlQuery($sql, $sqlargs);
    $kratte = $res[0][0]['crates'];

    if (!is_int($kratte)){
        $kratte = 0;
    }
?>

<!-- section-block -->
<div class="container">
    <div class="card">
        <form action="user_InputCheckBins.php">
            <div class="card-body">
                <h2>Kratte vir Werker Nommer: <span class="text-inline"
                        id="QrID"><?php echo $qr . $res[0][0]['naam']." ".$res[0][0]['van']; ?></span>
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
import QrCode from './JS/qr-code.min.js';

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
<h1 class="bg-success"><img style="height:1.5em;" src="Img/invoere.png" class="rounded m-1 p-1" alt="Invoer">Bins vir
    Vandag
</h1>
<div class="container">
    <audio id="beep" preload="auto">
        <source src="Audio/beep.wav" type="audio/wav">
        Your browser does not support the audio element.
    </audio>
    <script src="JS/sweetalert2.10.js"></script>

    <div id="reader" style="margin: auto; max-width: 80%; text-align: center; position: relative;">
    </div>

    <div id="result">Scanning ...</div>
</div>


<!-- Page Level Scripts -->
<script src="JS/html5-qrcode.min.js"></script>
<script>
//run scan
function onScanSuccess(result) {
    //set defaults
    const camQrResult = document.getElementById('result');

    lastResult = result;
    const beep = document.getElementById('beep');
    var cn = result.split(":");
    var contract_end = new Date(cn[2])
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    if (contract_end < today) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Die Kontrak het verval!'
        })
    } else {
        if (camQrResult) {
            beep.play();
            var cn = result.split(":");
            camQrResult.innerHTML = '<h4> Werker: <hr>' + result +
                ' gekies</h4><a href="user_InputCheckBins.php?CN=' + cn[0] + '" class="btn btn-secondary">Stuur</a>';
        }
    }
}

//import plugins
const html5QrCode = new Html5Qrcode("reader");
Html5Qrcode.getCameras().then(devices => {
    /**
     * devices would be an array of objects of type:
     * { id: "id", label: "label" }
     */
    if (devices && devices.length) {
        if (devices[2]) {
            cameraId = devices[2].id
        } else {
            cameraId = devices[0].id;
        }
        html5QrCode.start(
                cameraId, // retreived in the previous step.
                {
                    fps: 10, // sets the framerate to 10 frame per second
                    qrbox: 200 // sets only 250 X 250 region of viewfinder to
                    // scannable, rest shaded.
                },
                qrCodeMessage => {
                    // do something when code is read. For example:
                    //console.log(`QR Code detected: ${qrCodeMessage}`);
                    onScanSuccess(qrCodeMessage)
                },
                errorMessage => {
                    // parse error, ideally ignore it. For example:
                    // console.log(`QR Code no longer in front of camera.`);
                })
            .catch(err => {
                // Start failed, handle it. For example,
                console.log(`Unable to start scanning, error: ${err}`);
            });
    }
}).catch(err => {
    // handle err
});
</script>

<?php
}
?>
<script scr="JS/bootstrap.bundle.min.js"></script>