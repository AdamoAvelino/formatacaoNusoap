<?php

include "../lib/nusoap.php";

$cliente = new nusoap_client('http://192.168.1.103/blogretro/nusoap-master/adamo/servidor.php?wsdl');

$parametros = array('email' => 'adamo.avelino@gmail.com', 'senha' => '12345');
//var_dump($parametros);

$resultado = $cliente->call('busca_usuario', $parametros);

$resultado = json_decode($resultado);
echo "<ul>";
foreach($resultado as $json){
	if(isset($json->mens)){
		echo "<li><div style='background: red; color:#fff'><p>{$json->mens}</p></div></li>";
	}else{
		echo "<li><div><p>{$json->id}</p></div></li>";
		echo "<li><div><p>{$json->email}</p></div></li>";
		echo "<li><div><p>{$json->nome}</p></div></li>";
		echo "<li><div><p>{$json->senha}</p></div></li>";

	}
}
echo "</ul>";	


