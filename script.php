<?php
require_once('extension_utils.php');
$utils = new ExtensionUtils();

$gif_dir = __DIR__ . '/gifs-cache/';
$feed    = __DIR__ . '/feed-cache/feed.php';
$day_ago = time() - 60*60*24;
$q       = '{query}';
// $q       = 'cat';

if ( file_exists( $feed ) ) {
	$modified_time = filemtime( $feed );

	if ( $modified_time < $day_ago ) {
		cache_gif_feed( $feed );
	}

} else {
	cache_gif_feed( $feed );
}

require_once( $feed );

$results = array();
$counter = 0;
$files_to_be_cached = array();

foreach( $list->data as $filename => $img ) {

	// Filter out if a term was searched & json
	if ( false === stripos( $filename, $q ) ) {
		continue;
	}

	if ( 10 <= $counter ) {
		break;
	}

	$file_location = $gif_dir . str_ireplace( '/', '-', $filename );

	if ( ! file_exists( $file_location ) && isset( $img->thumb_src ) && $img->thumb_src ) {
		$files_to_be_cached[ $img->thumb_src ] = $file_location;
	}

	$results[] = array(
		'title'    => $img->name,
		// 'icon'  => 'filetype',
		// 'icon'     => 'fakefile.php?src='. $img->src,
		'icon'     => $file_location,
		'valid'    => '',
		'uid'      => '',
		'subtitle' => "Copy to clipboard",
		'arg'      => $img->src,
	);

	$counter++;
}

echo $utils->toXml( $results );

clean_cached_gifs( $gif_dir );
cache_gif_thumbs( $files_to_be_cached );
