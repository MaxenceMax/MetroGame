<?php
    include_once 'classes/Station.class.php';
    session_start();
    $file = fopen("Doc/bddRatp.TXT", "r+");
    // List complétes des stations
    $lstStations = array();
    // Id des stations tirées au sort
    $idStation = array();
    while($read = fgets($file)) {
        $attrStation = explode(";", $read);
        if(trim($attrStation[4]) != "rer"){
            $station = new Station(intval($attrStation[0]),  utf8_decode($attrStation[1]), intval($attrStation[2]), intval($attrStation[3]), $attrStation[4]);
            array_push($lstStations, $station);
        }
    }
    $firstStation;
    array_shift($lstStations);
    $fp = fopen("rdmStations/".session_id().".txt", "w+");
    for($i = 0 ; $i<10; $i++)
    {
        $tmp = rand(0, count($lstStations));
        if(!array_key_exists($tmp, $idStation))
        {
            if($i == 0)
            {
                $firstStation = $lstStations[$tmp];
            }
            fwrite($fp,$lstStations[$tmp]->id.";".utf8_encode($lstStations[$tmp]->name).";".$lstStations[$tmp]->x.";".$lstStations[$tmp]->y.";".$lstStations[$tmp]->type );
            array_push($idStation, $tmp);
        }
        else
        {
            $i--;
        }
    }
    fclose($file);
    fclose($fp);
    $cordX = $firstStation->x/ 13.45;
    $cordY = $firstStation->y/ 13.45;
    $cordY -= 40;
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
            <div id="plan">
                <div id="stationPick" style="visibility: hidden;top:<?php echo $cordY?>;left:<?php echo $cordX?>" >
                    <img src="images/fleche.jpg" width="30px" style="border: none;"/>?
                </div>
            </div>
            <div id="questionnaire">Question :<br>Quel est le nom de cette station ?<br>
                        <select id="selectedStation">
                            <option value=""></option>
                        <?php
                        foreach ($lstStations as $station) {
                            ?><option value="<?php echo $station->id ?>"><?php echo $station->name ?></option><?php
                        }
                        ?>
                    </select>
                </input>
                <button id="valider">Commencer</button> 
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
        var nbrepOk =0;
        var nbrepTot = 0;
        var start= false;
    $("#valider").click(function () {
       if(start)
       {
           if(nbrepTot < 10)
           {
                if($("option:selected").val())
                {
                     $.ajax({
                     type: "POST",
                     url: "classes/valider.php",
                     data: { stationId : $("option:selected").val(), numquestion : nbrepTot}
                 }).done(function(html) {
                     var o=JSON.parse(html);
                     var x = o[0]['x'];
                     console.log(o[0]['x']);
                     var y = o[0]['y'];
                     console.log(o[0]['y']);
                     if(o['rep'] == "true")
                     {
                         nbrepOk++;
                     }
                     $("#stationPick").css("top",x+"px");
                     $("#stationPick").css("left",x+"px");
                      nbrepTot++;
                      if(nbrepTot == 10)
                      {
                          $("#valider").html("Recommencer");
                          $("#stationPick").css('visibility','hidden');
                          $("#affichageRep").html("Vous avez bien r&eacute;pondu &agrave; "+nbrepOk+" r&eacute;ponses. Pour recommencer appuyer sur le bouton.")
                      }
                      //Reset option
                      $('select').val('0');
                    });
                }else
                {
                    window.alert("Veuillez choisir une station."); 
                }
            }else
            {
                location.reload();
            }
       }
       else
       {
           $("#valider").html("Suivant");
           $("#stationPick").css('visibility','visible');
           start = true;
       }
    });
    </script>
</html>
