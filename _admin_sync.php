<!-- Main Content -->
<!-- section-block -->
<div class="container">
    <div class="card">
        <form action="user_InputCheckBins.php">
            <div class="card-body">
                <div>
                    <h2 class="text-primary">Databasis Weergawe: v1</h2>
                    <h3 class="bg-success"> Op Bediener </h3>
                    <ul class="text-left">
                        <?php
                         $sql = "SELECT count(id) as total from clocklog";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Klok: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from worklog";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Werk: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from gewas";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Gewas: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from spilpunt";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Spilpunt: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from workers";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Werkers: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from users";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Gebruikers: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from plaas";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Plaas: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from task";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Taak: <?=$result?></li>
                        <?php
                         $sql = "SELECT count(id) as total from access";
                            require_once 'config/db_query.php';
                            $sqlargs = array();
                            $result = sqlQuery($sql, $sqlargs);
                            $result = $result[0][0]['total'];
                        ?>
                        <li>Toegangsvlakke: <?=$result?></li>
                    </ul>

                    <script>
                    let db = JSON.parse(localStorage.getItem('db_details'));
                    document.write('<h2 class="text-primary">Databasis Weergawe: v', db.version,
                        '</h2><small class="text-black">Last Update: ', db
                        .last_update,
                        '</small>');
                    </script>
                    <h3 class="bg-primary"> Op Foon </h3>
                    <ul class="text-left">
                        <script>
                        document.write('<li>Klok: ', JSON.parse(localStorage.getItem('clockings')).length, '</li>');
                        document.write('<li>Werk: ', JSON.parse(localStorage.getItem('worklog')).length, '</li>');
                        document.write('<li>Gewas: ', JSON.parse(localStorage.getItem('gewas')).length, '</li>');
                        document.write('<li>Spilpunt: ', JSON.parse(localStorage.getItem('spilpunt')).length, '</li>');
                        document.write('<li>Werkers: ', JSON.parse(localStorage.getItem('worker')).length, '</li>');
                        document.write('<li>Gebruikers: ', JSON.parse(localStorage.getItem('user')).length, '</li>');
                        document.write('<li>Plaas: ', JSON.parse(localStorage.getItem('plaas')).length, '</li>');
                        document.write('<li>Taak: ', JSON.parse(localStorage.getItem('task')).length, '</li>');
                        document.write('<li>Toegangsvlakke: ', JSON.parse(localStorage.getItem('access')).length,
                            '</li>');
                        </script>
                    </ul>
                </div>
                <div>
                    <h3 class="bg-secondary"> Op Foon - Moet nog oplaai</h3>
                    <ul class="text-left">
                        <script>
                        document.write('<li>Klok rekords: ', JSON.parse(localStorage.getItem('clockingsUP')).length,
                            '</li>');
                        document.write('<li>Werk rekords rekords: ', JSON.parse(localStorage.getItem('worklogUP'))
                            .length, '</li>');
                        </script>
                    </ul>
                </div>

                <br>
                <input type="button" class="btn btn-info" onclick="fSync()" value="Forseer Sinkroniseer">
                <a class="btn btn-primary" href="home.html">Tuis</a>
                <input type="button" class="btn btn-danger" onclick="clearCash('offline')" value="Dwing Herstel">
            </div>
        </form>
    </div>
</div>