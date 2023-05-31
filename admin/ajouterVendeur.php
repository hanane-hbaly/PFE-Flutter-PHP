<?php

include "../connect.php";

$id = filterRequest("id");
$cin = filterRequest("cin");
 $type = "vendeur";
 $nomv = filterRequest("nomv");
 $prenomv = filterRequest("prenomv");
 $telev = filterRequest("telev");



$stmt = $con->prepare("SELECT * FROM users WHERE id = ? OR cin = ? ");
$stmt->execute(array($id, $cin));
$count = $stmt->rowCount();
if ($count > 0) {
    printFailure("id OR cin");
} else {

    $data = array(
        "id" => $id,
        "cin" =>  $cin,
        "type" => $type,
      
    );
    insertDatasansSu("users" , $data) ; 

    $datav = array(
        "idV" => $id,
        "Cinv" =>  $cin,
        "Nomv" => $nomv,
        "Prenomv" => $prenomv,
        "Telephonev" => $telev,

      
    );
    insertData("vendeur" , $datav) ; 
}
