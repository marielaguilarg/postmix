<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include('../../libs/paginator.class.php');
     //    require_once "../../Models/crud_unegocios.php";
        require_once "../../Models/crud_unegocios.php";
try {
	
	  $filx=array(            
        "pais"=>1,
        "uni"=>1,
        "zon=>"=>1,
         "reg"=>"",
        "ciu"=>$select5,
        "niv6"=>$select6);

////inserta reportes en la tabla temporal tmp_estadistica
    
$rs_sql_us = DatosUnegocio::unegociosxNivel($fil_ptoventa,$fil_idpepsi,$filx,$fily,"","");
	$num_rows = sizeof($rs_sql_us);
	$pages = new Paginator($num_rows,9,array(15,3,6,9,12,25,50,100,250,'All'));
	echo $pages->display_pages();
	echo "<span class=\"\">".$pages->display_jump_menu().$pages->display_items_per_page()."</span>";
//	$stmt = $conn->prepare('SELECT City.Name,City.Population,Country.Name,Country.Continent,Country.Region FROM City INNER JOIN Country ON City.CountryCode = Country.Code ORDER BY City.Name ASC LIMIT :start,:end');
//	$stmt->bindParam(':start', $pages->limit_start, PDO::PARAM_INT);
//	$stmt->bindParam(':end', $pages->limit_end, PDO::PARAM_INT);
//	$stmt->execute();
	$result = DatosUnegocio::unegociosxNivel($fil_ptoventa,$fil_idpepsi,$filx,$fily,$pages->limit_start,$pages->limit_end);
	echo "<table><tr><th>City</th><th>Population</th><th>Country</th><th>Continent</th><th>Region</th></tr>\n";
	foreach($result as $row) {
		echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td></tr>\n";
	}
	echo "</table>\n";
	echo $pages->display_pages();
	echo "<p class=\"paginate\">Page: $pages->current_page of $pages->num_pages</p>\n";
	echo "<p class=\"paginate\">SELECT * FROM table LIMIT $pages->limit_start,$pages->limit_end (retrieve records $pages->limit_start-".($pages->limit_start+$pages->limit_end)." from table - $pages->total_items item total / $pages->items_per_page items per page)";
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
        ?>
    </body>
</html>
