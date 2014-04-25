<?php
/**
 * Contains Maintenance Clean Cache class.
 *
 * PHP version 5
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal which can be used to access the Eve Online
 * API data and place it into a database.
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Michael Cummings <mgcummings@yahoo.com>
 * @copyright  Copyright (c) 2008-2014, Michael Cummings
 * @license    http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @link       http://code.google.com/p/yapeal/
 * @link       http://www.eveonline.com/
 */
namespace Yapeal\Database\Maint;

use Yapeal\Database\DBConnection;

/**
 * Class used to clean out old unused cached API XML files from cache directory.
 */
class CleanCache
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sections =
            array('account', 'char', 'corp', 'eve', 'map', 'server');
    }
    /**
     * This function finds and deletes any XML files in cache/ that haven't been
     * modified for seven days or more.
     *
     * By default all the APIs are setup to refresh in a day or less in
     * utilCachedInterval so any XML file older then that aren't being used and
     * are just taking up space since Yapeal will have to grab them again
     * anyway.
     *
     * @return bool Always returns TRUE.
     */
    public function doWork()
    {
        $limit = strtotime('7 days ago');
        foreach ($this->sections as $section) {
            $path = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'cache'
                . DIRECTORY_SEPARATOR . $section . DIRECTORY_SEPARATOR;
            $files = new \DirectoryIterator($path);
            /**
             * @var \DirectoryIterator $item
             */
            foreach ($files as $item) {
                $name = $item->getFileName();
                // Only need to be concerned with expired XML Files.
                if ($item->isFile() && $item->isWritable()
                    && substr($name, -3) == 'xml'
                    && $item->getMTime() < $limit
                ) {
                    $result = @unlink($name);
                    if ($result === false) {
                        $mess = 'Could not delete ' . $name;
                        \Logger::getLogger('yapeal')
                               ->warn($mess);
                    }
                }
            }
        }
        $sql = ' delete from `' . YAPEAL_TABLE_PREFIX . 'utilXmlCache`';
        $sql .= ' where';
        $sql .= ' `modified` = ';
        try {
            $con = DBConnection::connect(YAPEAL_DSN);
            $sql .= $con->qstr(gmdate('Y-m-d H:i:s', $limit));
            $con->Execute($sql);
        } catch (\ADODB_Exception $e) {
            // Nothing to do here was already report to logs.
        }
        return true;
    }
}

