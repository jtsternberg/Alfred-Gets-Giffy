<?php
// require_once('extension_utils.php');
// $utils = new ExtensionUtils();

$q = '{query}';
$q = 'cat';
$q = 'bob';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://jtsternberg.com/?json&gifs={$q}" );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$head = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ( 200 != $http_code ) {
	return;
}
$list = json_decode( $head );


$dir = __DIR__ . '/gifs-cache/';

$results = array();
$counter = 0;
foreach( $list->data as $filename => $img ) {

	if ( 10 <= $counter ) {
		break;
	}

	// $file_location = $dir . $filename;

	// if ( ! file_exists( $file_location ) ) {

	// 	$contentOrFalseOnFailure   = file_get_contents( $img->src );
	// 	$byteCountOrFalseOnFailure = file_put_contents( $file_location, $contentOrFalseOnFailure );

	// }

	$results[] = array(
		'title'    => $img->name,
		// 'icon'  => 'filetype',
		'icon'     => 'fakefile.php?src='. $img->src,
		'valid'    => '',
		'uid'      => '',
		'subtitle' => "Copy to clipboard",
		'arg'      => $img->src,
	);

	$counter++;
}

foreach ( glob( $dir .'*.gif' ) as $gif_file) {
	$time = fileatime( $gif_file );

	if ( $time < ( time() - 60*60*24 ) ) {
		unlink( $gif_file );
	}
}

die( '<xmp>'. print_r( $results, true ) .'</xmp>' );

echo $utils->toXml( $results );
