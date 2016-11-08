<?php 
include "../lib/nusoap.php";

$servidor = new soap_server();

$servidor->configureWSDL('Web Service Adamo','urn:adamoWebService');

if(!isset($HTTP_RAW_POST_DATA)){
	$HTTP_RAW_POST_DATA = file_get_contents('php://input');
}

$f = fopen('post_data.txt', 'w');

fwrite($f, $HTTP_RAW_POST_DATA);
fclose($f);



$conect = new PDO('mysql:host=localhost;dbname=blogretro', 'root', '@avelino82');

function busca_usuario($email, $senha){

	$conect = new PDO('mysql:host=localhost;dbname=blogretro', 'root', '@avelino82');
	$conect->exec("SET CHARACTER SET utf8");

	$query = $conect->query("select * from usuarios where email='{$email}' and senha='{$senha}'");
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$recordset = $query->fetchAll();
	
	if(count($recordset)){
		$retorno = json_encode($recordset, JSON_UNESCAPED_UNICODE);		
	}
	else{
		$mensagem[] = array('mens' => 'Não Há Registros');
		$retorno = json_encode($mensagem, JSON_UNESCAPED_UNICODE); 
	}
    
	
	
	return $retorno;
}

$servidor->register(
		'busca_usuario',
		array('email' => 'xsd:string', 'senha' => 'xsd:string'),
		array('return' => 'xsd:string'),
		'urn:adamoWebService.busca_usuario',
		'urn:adamoWebService.busca_usuario',
		'rpc',
		'encoded',
		'TEste do soap adamo php'


	);
$servidor->service($HTTP_RAW_POST_DATA);

