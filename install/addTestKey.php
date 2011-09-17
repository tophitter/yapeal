#!/usr/bin/php -Cq
<?php
/**
 * Used to add test key to utilRegisteredKey table.
 *
 * PHP version 5
 *
 * LICENSE: This file is part of Yet Another Php Eve Api library also know
 * as Yapeal which will be used to refer to it in the rest of this license.
 *
 *  Yapeal is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Yapeal is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with Yapeal. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2008-2011, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @package    Yapeal
 * @subpackage Install
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
/**
 * @internal Allow viewing of the source code in web browser.
 */
if (isset($_REQUEST['viewSource'])) {
  highlight_file(__FILE__);
  exit();
};
/**
 * @internal Only let this code be ran in CLI.
 */
if (PHP_SAPI != 'cli') {
  header('HTTP/1.0 403 Forbidden', TRUE, 403);
  $mess = basename(__FILE__) . ' only works with CLI version of PHP but tried';
  $mess = ' to run it using ' . PHP_SAPI . ' instead';
  die($mess);
};
/**
 * @internal Only let this code be ran directly.
 */
$included = get_included_files();
if (count($included) > 1 || $included[0] != __FILE__) {
  $mess = basename(__FILE__) . ' must be called directly and can not be included';
  fwrite(STDERR, $mess);
  fwrite(STDOUT, 'error' . PHP_EOL);
  exit(1);
};
// Used to over come path issues caused by how script is ran on server.
$dir = realpath(dirname(__FILE__));
chdir($dir);
/**
 * Define short name for directory separator which always uses unix '/'.
 * @ignore
 */
define('DS', '/');
// Pull in Yapeal revision constants.
$path = $dir . DS . '..' . DS . 'revision.php';
require_once realpath($path);
// Move down and over to 'inc' directory to read common_backend.php
$path = $dir . DS . '..' . DS . 'inc' . DS . 'common_backend.php';
require_once realpath($path);
if ($argc < 5) {
  $mess = 'keyID, vCode, type, isActive are required in ';
  $mess .= $argv[0] . PHP_EOL;
  fwrite(STDERR, $mess);
  fwrite(STDOUT, 'error');
  exit(2);
};
// Strip any quotes
$replace = array("'", '"');
for ($i = 1; $i < $argc; ++$i) {
  $argv[$i] = str_replace($replace, '', $argv[$i]);
};
$keyID = (int)$argv[1];
$vCode = $argv[2];
$type = $argv[3];
$isActive = $argv[4];
try {
  // Need list of allowed APIs
  $section = new Sections('account', FALSE);
  $key = new RegisteredKey($keyID);
  $user->activeAPIMask = (string)$section->activeAPI;
  $user->fullApiKey = $fullAPIKey;
  $user->limitedApiKey = $limitedAPIKey;
  $user->isActive = $isActive;
  $user->proxy = '';
  if (TRUE == $user->store()) {
    fwrite(STDOUT, 'true');
  } else {
    fwrite(STDOUT, 'false');
  };
  exit(0);
} catch (Exception $e) {
  $mess = <<<MESS
EXCEPTION:
     Code: {$e->getCode()}
  Message: {$e->getMessage()}
     File: {$e->getFile()}
     Line: {$e->getLine()}
Backtrace:
{$e->getTraceAsString()}
MESS;
  fwrite(STDERR, $mess);
  fwrite(STDOUT, 'false');
  exit(3);
}
?>