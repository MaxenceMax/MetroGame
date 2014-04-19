<?php
    include_once 'Station.class.php';
 
    $file = fopen("Doc/bddRatp.TXT", "r+");
    $lstStations = array();
    while($read = fgets($file)) {
        $attrStation = explode(";", $read);
        $station = new Station($attrStation[0], $attrStation[1], $attrStation[2], $attrStation[3], $attrStation[4]);
        array_push($lstStations, $station);
    }
    array_shift($lstStations);
    $nbTry = 0;
    // random station id a stocker
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" media="screen" href="style/style.css">
</head>
<body>
    <div id="Global">
        <div id="Logo">
            <a href="/"></a>
        </div>
        <div id="Contenu">
            <div id="plan"></div>
            <div id="questionnaire">Question :<br>Quel est le nom de cette station ?<br>
                        <select>
                        <option value=""></option>
                        <?php
                        foreach ($lstStations as $station) {
                            ?><option value="<?php echo $station->id ?>"><?php echo $station->name ?></option><?php
                        }
                        ?>
                    </select>
                </input>
                <button id="valider">Valider</button>
                <div id="affichageRep"></div>
            </div>
        </div>
    </div>
    <div id="BarreInterne">
        <div id="TexteAccueil">
            <h2 style="border: none">
        </div>
    </div>
    <div id="Footer">
    </div>
</body>
    
    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    <script>
        var nbrep =0;
    $("#valider").click(function () {
       $.ajax({
           type: "POST",
           url: "valider.php",
           data: { stationId : $("option:selected").val() }
       }).done(function(html) {
            console.log(html);
            nbrep++;
            $("#affichageRep").html(html);
          });
    });
    $("#")
    </script>
    
</html>

<?php

