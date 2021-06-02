<?php

$hostname = '10.190.16.50';
$username = 'iberti';
$password = 'iberti3421';
$database = 'BaseSIG';

$conexion = mysqli_connect( $hostname, $username, $password, $database) or die ("No se ha podido conectar al servidor de Base de datos");

mysqli_set_charset($conexion,"utf8");

$consulta = "SELECT * FROM capa_sig_unidades_militares";

$resultado = mysqli_query( $conexion, $consulta ) or die ( "Algo ha ido mal en la consulta a la base de datos");

$features = array();
$i=0;
while ($columna = mysqli_fetch_array($resultado))
{
	/*
	echo "<tr>";
	echo "<td>" . $columna['cod_uni'] . "</td><td>" . $columna['abrev'] . "</td>";
	echo "</tr><br>";
	*/
	//$features[] = $columna;
	$features[] = array(
        'type' => 'Feature',
        'properties' => array('gid' => ++$i,
        			'fdc' => 'Ejército Argentino',
      				'fna' => $columna['abrev'],
        			'cod_uni' => $columna['cod_uni'],
        			'cod_unisup' => $columna['cod_unisup']),
        'geometry' => array(
             'type' => 'Point', 
             'coordinates' => array(
                  $columna['lat'], 
                  $columna['lon']
             ),
         ),
    );
}

$geojson = array(
    'type' => 'FeatureCollection',
    'features' => $features,
);

mysqli_close($conexion);

$jsonData =json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

//print_r($data);
print_r($jsonData);

/*$fp = fopen('geojson/data_unidades_ea.geojson', 'w');
fwrite($fp, $jsonData);
fclose($fp);
*/

?>
