<?php
// require_once('extension_utils.php');
// $utils = new ExtensionUtils();

$q = '{query}';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://jtsternberg.com/?json&gifs={$q}' );
curl_setopt($ch, CURLOPT_HEADER, TRUE);
curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$head = curl_exec($ch);
$http_info = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

die( '<xmp>'. print_r( $http_info, true ) .'</xmp>' );

// $list = json_decode( $http_info );

// $results = array();

// foreach( $list['data'] as $emot => $img ) {
// 	$name = basename( $img );

// 	if ( !empty($q) &&
// 		strpos( $emot, $q ) === false &&
// 		strpos( $name, $q ) === false
// 	) continue;
// 	$results[] = array(
// 		'title' => $name,
// 		// 'icon' => 'filetype',
// 		'icon' => $img,
// 		'valid' => '',
// 		'uid' => '',
// 		'subtitle' => "Copy to clipboard",
// 		'arg' => "($emot)"
// 	);
// }

// die( '<xmp>'. print_r( $results, true ) .'</xmp>' );

// echo $utils->toXml( $results );
