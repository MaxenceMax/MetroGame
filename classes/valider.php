<?php
    include_once '../classes/Station.class.php';
    if(isset($_POST['stationId']) && isset($_POST['numquestion']))
    {
        $numqestion = $_POST['numquestion'];
        session_start();
        $file = fopen("../rdmStations/".session_id().".txt", "r+");
        $lstStations = array();
        while($read = fgets($file)) {
                $attrStation = explode(";", $read);
                $station = new Station(intval($attrStation[0]),  utf8_decode($attrStation[1]), intval($attrStation[2]), intval($attrStation[3]), $attrStation[4]);
                array_push($lstStations, $station);
        }
        fclose($file);
        $cordX = $lstStations[$numqestion+1]->x/ 13.45;
        $cordY = $lstStations[$numqestion+1]->y/ 13.45;
        $cordY -= 40;
        if($_POST['stationId'] == $lstStations[$numqestion]->id)
        {
            $data = array(
                'rep' => 'true',
                array('x' => $cordX,'y' => $cordY)
            );
        }
        else
        {
            $data = array(
                'rep' => 'false',
                array('x' => $cordX,'y' => $cordY)
            );
        }
        echo json_encode($data);
    }   
?>
