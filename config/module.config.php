<?php
/**
 * Base Configuration for the Module
 * @author George Steel <george@net-glue.co.uk>
 * @copyright Copyright (c) 2012 Net Glue Ltd (http://netglue.co)
 * @license http://opensource.org/licenses/MIT
 */

/**
 * Options for the module that are critical to its operation
 */
$config = array(
	'feed' => NULL, // To use the single feed service, you have to provide the full uri of a trip advisor feed
	
);

/**
 * Return config keyed with 'netglue_tripadvisor'
 */
return array(
	'netglue_tripadvisor' => $config,
);
