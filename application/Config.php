<?php

/**
 * Database config variables
 * Change this according to your server settings
 */

class Constants
{
	// Definitely your Database Host name
	const DB_HOST = "localhost";

	// change the user access, CPanel have user roles, when writing and reading files
	// set it to allow the certain User to read/write
	const DB_USER = "root";

	// change this according to your account credentials
	const DB_PASSWORD = "root";

	// if you wish you create your own name for 
	// Database then change the word "db_storefinder"
	const DB_DATABASE = "db_storefinder_flutter";

	// If deployed in a web server, change this according to your configuration
	// For Example. the domain name is www.someUrl.com, then if the php files are stored in
	// a folder named as "responsive" then the complete url would be
	// www.someUrl.com/responsive/
	const ROOT_URL = "http://192.168.254.109:80/mg/storefinder/";

	// DO NOT CHANGE THIS
	// FOLDER DIRECTORY FOR IMAGES UPLOADED FROM
	// THE DESKTOP
	const IMAGE_UPLOAD_DIR = "upload_pic";

	// NO OF ITEMS TO LOAD PER PAGINATION
	const NO_OF_ITEMS_PER_PAGE = 10;

	// Default latitude for the map to be set when it is loaded
	const MAP_DEFAULT_LATITUDE = 37.770185;

	// Default  longitude for the map to be set when it is loaded
	const MAP_DEFAULT_LONGITUDE = -122.419061;

	// Adjust map zoom for Store Insertion
	const MAP_DEFAULT_ZOOM_LEVEL = 18;

	// API KEY use to handshake both iOS and Android apps.
	// Note: this key must the same both iOS and Android otherwise, it wont work.
	// any key to be written here. Make sure it is the same key also for both iOS and Android.
	const API_KEY = "45090dcae2aYMK";

	// Your mapbox key access token here
	const MAP_BOX_ACCESS_TOKEN = "pk.eyJ1IjoibWd1c2VyMDAxIiwiYSI6ImNqeGE1cjl0NzAyd2gzeHBhcTM2YnVidm8ifQ.tyON58eWXU-2z0i3rUmEfQ";

	// mapbox marker color
	const MARKER_COLOR = "#ff662e";

	// one signal app id
	const ONESIGNAL_ID = "d4434348-a84b-4164-ac3a-ee44e6f57a97";
}

?>