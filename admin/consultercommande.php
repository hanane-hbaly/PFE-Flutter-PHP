<?php
include "../connect.php";

$vendeurID = filterRequest('vendeurID'); // ID du vendeur sélectionné
$dateSaisie = filterRequest('dateSaisie'); // Date saisie par le responsable

$result = $con->query("
    SELECT CONCAT(cl.Nomc, ' ', cl.Prenomc) AS client, cl.Adressec,
           GROUP_CONCAT(CONCAT(p.Nomp, ' ', p.Typep, ' ', p.Prixp, ' (Quantité: ', q.Quantite, ')' , ' (Prix: ', p.Prixp * q.Quantite, ')') SEPARATOR '; ') AS produits,
           SUM(p.Prixp * q.Quantite) AS prix_commande,
           s.Noms AS secteur, a.VehiculeID, c.Tonagea, c.Tonaged
    FROM secteur s, affectation a, commande c, client cl, produit p, quantite q, facture f
    WHERE s.SecteurID = cl.SecteurID
      AND s.SecteurID = a.SecteurID
      AND a.VendeurID = f.VendeurID
      AND f.FactureID = q.FactureID
      AND q.ProduitID = p.ProduitID
      AND f.VendeurID = c.VendeurID
      AND f.ClientID = cl.ClientID
      AND a.VendeurID = $vendeurID
      AND a.Datea = '$dateSaisie'
      AND c.Datec = '$dateSaisie'
      AND f.Datef = '$dateSaisie'
    GROUP BY cl.ClientID
");

if ($result) {
    $commandes = array();
    $prix_total = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
       // $commandes[] = $row;
        $client = $row['client'];
        $Adressec=$row['Adressec'];
        $produits = $row['produits'];
        $prixCommande = $row['prix_commande'];
        $secteur = $row['secteur'];
        $vehiculeID = $row['VehiculeID'];
        $tonageDepart = $row['Tonagea'];
        $tonageArrivee = $row['Tonaged'];
        $prix_total += $prixCommande;

        // Ajouter les informations à la liste des commandes
        $commandes[] = array(
            'client' => $client,
            'Adressec' => $Adressec,      
            'produits' => $produits,
            'prixCommande' => $prixCommande,
            'secteur' => $secteur,
        );
    }
    if (empty($commandes)) {
        $commandes = array('error' => 'Aucune commande trouvée');
        echo json_encode($commandes);
    } else {
        $commandes['vehiculeID'] = $vehiculeID;
        $commandes['tonageDepart'] = $tonageDepart;
        $commandes['tonageArrivee'] = $tonageArrivee;
        $commandes['prix_total'] = $prix_total;
        // Retourner la liste des commandes au format JSON
        echo json_encode($commandes);
    }
}  

?>
