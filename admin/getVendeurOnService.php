<?php
//GetAllVendeurs on service 
include "../connect.php";
$result =$con->query( "SELECT CONCAT(v.Nomv, ' ', v.Prenomv) AS nom_complet
      FROM vendeur v
      INNER JOIN users u ON v.idV = u.id
          WHERE u.service = 1;");
if ($result) {
    $vendeurs = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $vendeurs[] = $row['nom_complet'];
    }

   echo json_encode(array("status" => "success", "data" => $vendeurs));
 }
?>
