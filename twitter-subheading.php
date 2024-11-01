<?php
/*
 * Plugin Name:	Twitter Sub-Heading
 * Plugin URI:	http://invariabletruth.com
 * Version:	0.01
 * Author:	Stewart Malik
 * Author URI:	http://invariabletruth.com
 * Description:	This changes the sub-heading of your blog to your latest tweet.
 * 
 * Copyright 2009 Stewart Malik <mali0037@gmail.com>
 *     
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *     
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
*/

// Get some options from the database //
define(TWITTER_USERNAME, (get_option('twitterSubheading_username')));
define(UPDATE_INTERVAL, (get_option('twitterSubheading_interval')));

// Don't change anything below this line unless you know what you are doing. //
define(STATUS_URL, 'wp-content/plugins/twitter-sub-heading/extra/status.dat');


function testTime( ) {
	// Opens the status.dat file and pushes it into an array. //
	$file = file(STATUS_URL, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	// Assigns a variable from the UPDATE_INTERVAL definition. //
	$updateInterval = UPDATE_INTERVAL;
	// Change the type to a float, not 100% sure if this is necessary. //
	settype($updateInterval, float);
	// Calculate the number of minutes that has passed since the last status write. //
	$minutes = (time() - $file['0']) / 60;
	// Check if the number of minutes is larger of equal to the Update Interval. //
	if($minutes >= $updateInterval) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function getTwitterStatus( ) {
	// Function above that tests to see if we should access the Twitter API. //
	$testTime = testTime();
	if($testTime == TRUE) {
		// Make the call to the twitterApiCall function. //
		$twitterQuery = twitterApiCall("http://twitter.com/users/show/" . TWITTER_USERNAME);
		// Error Checking. //
		if($twitterQuery != NULL) {
			// Open the status file. //
			$fileHandle = fopen(STATUS_URL, "w");
			fwrite($fileHandle, time() . "\n" . $twitterQuery);
			fclose($fileHandle);
			return $twitterQuery;
		}
	}
	// If we don't access the twitterApiCall then we return the value already in the status file. //
	$file = file(STATUS_URL);
	return $file['1'];
}

function twitterApiCall( $api_url ) {
	// Initialize cURL. //
	$curl_handle = curl_init();
	// Set cURL options. //
	curl_setopt($curl_handle, CURLOPT_URL, $api_url);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array('Expect:'));
	// Run cURL and assign result to a variable. //
	$twitter_data = curl_exec($curl_handle);
	// Close cURL. //
	curl_close($curl_handle);
	// Check to see if we need to add an external class for PHP4 support. //
	$PHPversion = PHP_VERSION;
	if($PHPversion{0} < 5) {
		require 'php/simplexml.class.php';
		$xmlObject = new simplexml;
		$XMLdata = $xmlObject->xml_load_file($twitter_data);
		$twitter_text = $XMLdata->status->text;
		return $twitter_text;
	}	
	// Parse the XML. //
	$asXML = new SimpleXMLElement($twitter_data);
	foreach($asXML->status as $status) {
		$twitter_text = $status->text;
	}
	// Return your latest status update. //
	return $twitter_text;
}

// Function for the WordPress Filter. //
function changeBlogDescription( $description = '', $show = '' ) {
	switch ($show) {
		case 'description' :
			$description = getTwitterStatus();
			break;
		default : 
	}
	return $description;
}

// Function for adding the admin page. //
function twitterSubheadingAdminOptions( ) {
	add_options_page('Twitter Sub-Heading', 'Twitter Sub-Heading', 1, 'Twitter Sub-Heading', twitterSubheadingAdmin);
}

// Function for including the HTML and PHP for the admin page. //
function twitterSubheadingAdmin( ) {
	include('php/twitter-subheading-admin.php');
}

// Adding filters. //
add_filter('bloginfo', 'changeBlogDescription', 1, 2);
add_action('admin_menu', 'twitterSubheadingAdminOptions');

?>
