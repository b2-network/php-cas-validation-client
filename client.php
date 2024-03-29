<?php

/**
 *   Example for a simple cas 2.0 client
 *
 * PHP Version 7
 *
 * @file     example_simple.php
 * @category Authentication
 * @package  PhpCAS
 * @author   Joachim Fritschi <jfritschi@freenet.de>
 * @author   Adam Franco <afranco@middlebury.edu>
 * @author   Nicolas Belan <nbelan@b2.network>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link     https://wiki.jasig.org/display/CASC/phpCAS
 */

// Load the settings from the central config file
require_once 'config.php';

// Load the CAS lib
require_once $phpcas_path . '/CAS.php';

require_once './vendor/ec-europa/ecas-phpcas-parser/src/EcasPhpCASParser.php';

// Enable debugging
 phpCAS::setDebug("debug.log");

// Enable verbose error messages. Disable in production!
 phpCAS::setVerbose(true);

// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

// fix attributes parsing
phpCAS::setCasAttributeParserCallback(array(
	new \EcasPhpCASParser\EcasPhpCASParser(),
	'parse',
));

// For production use set the CA certificate that is the issuer of the cert
// on the CAS server and uncomment the line below
// phpCAS::setCasServerCACert($cas_server_ca_cert_path);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
phpCAS::setNoCasServerValidation();

// force CAS authentication
phpCAS::forceAuthentication();

// at this step, the user has been authenticated by the CAS server
// and the user's login name can be read with phpCAS::getUser().

// logout if desired
if (isset($_REQUEST['logout'])) {
	phpCAS::logout();
}

// for this test, simply print that the authentication was successfull
?>
<html>
  <head>
    <title>phpCAS simple client</title>
  </head>
  <body>
    <h1>Successfull Authentication!</h1>
    <dl style='border: 1px dotted; padding: 5px;'>
        <dt>Current script</dt><dd><?php print basename($_SERVER['SCRIPT_NAME']); ?></dd>
        <dt>session_name():</dt><dd> <?php print session_name(); ?></dd>
        <dt>session_id():</dt><dd> <?php print session_id(); ?></dd>
    </dl>
    <p>the user's login is <b><?php echo phpCAS::getUser();?></b>.</p>
    <p>phpCAS version is <b><?php echo phpCAS::getVersion();?></b>.</p>
<h3>User Attributes</h3>
<ul>
<?php
phpCAS::trace(print_r(phpCAS::getAttributes(), true));

// decode array recursive
function CAS_decodeAttributes($attributes) {
	foreach ($attributes as $key => $value) {
    if (is_array($value)) {
      echo '<li>' . $key . ': <ul>';
			CAS_decodeAttributes($value);
      echo '</ul></li>' . PHP_EOL;
		} else {
			echo '<li>' . $key . ': <strong>' . $value . '</strong></li>' . PHP_EOL;
		}
	}
}
CAS_decodeAttributes(phpCAS::getAttributes());

?>
</ul>
    <p><a href="?logout=">Logout</a></p>
    <p><?php echo date(DATE_RFC2822); ?></p>
  </body>
</html>
<?php
