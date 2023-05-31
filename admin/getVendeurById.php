<?php
include "../connect.php";
 $idv=filterRequest("idv");
$list = array();
$result = $con->query("SELECT * FROM vendeur where idV='$idv'");
if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $list[] = $row;
    }
    echo json_encode($list);
}
?>
