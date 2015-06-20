<?php
/**
 * Contains CommandToolsTrait trait.
 *
 * PHP version 5.4
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal
 * which can be used to access the Eve Online API data and place it into a
 * database. Copyright (C) 2014-2015 Michael Cummings
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * You should be able to find a copy of this license in the LICENSE.md file. A
 * copy of the GNU GPL should also be available in the GNU-GPL.md file.
 *
 * @copyright 2014-2015 Michael Cummings
 * @license   http://www.gnu.org/copyleft/lesser.html GNU LGPL
 * @author    Michael Cummings <mgcummings@yahoo.com>
 */
namespace Yapeal\Console;

use InvalidArgumentException;
use PDO;
use PDOException;
use Yapeal\Container\ContainerInterface;
use Yapeal\Sql\CommonSqlQueries;
use Yapeal\Exception\YapealConsoleException;
use Yapeal\Exception\YapealDatabaseException;

/**
 * Trait CommandToolsTrait
 */
trait CommandToolsTrait
{
    /**
     * @param CommonSqlQueries $value
     *
     * @return self
     */
    public function setCsq(CommonSqlQueries $value)
    {
        $this->csq = $value;
        return $this;
    }
    /**
     * @param string $value
     *
     * @throws InvalidArgumentException
     * @return self
     */
    public function setCwd($value)
    {
        if (!is_string($value)) {
            $mess = 'Cwd MUST be string but given ' . gettype($value);
            throw new InvalidArgumentException($mess);
        }
        $this->cwd = $value;
        return $this;
    }
    /**
     * @param ContainerInterface $value
     *
     * @return self
     */
    public function setDic(ContainerInterface $value)
    {
        $this->dic = $value;
        return $this;
    }
    /**
     * @param PDO $value
     *
     * @return self
     */
    public function setPdo(PDO $value)
    {
        $this->pdo = $value;
        return $this;
    }
    /**
     * @return CommonSqlQueries
     * @throws YapealConsoleException
     */
    protected function getCsq()
    {
        if (null === $this->csq) {
            $this->csq = $this->getDic()['Yapeal.Database.CommonQueries'];
        }
        return $this->csq;
    }
    /**
     * @return string
     */
    protected function getCwd()
    {
        return $this->cwd;
    }
    /**
     * @return ContainerInterface
     * @throws \Yapeal\Exception\YapealConsoleException
     */
    protected function getDic()
    {
        if (null === $this->dic) {
            $mess = 'Tried to use dic before it was set';
            throw new YapealConsoleException($mess, 1);
        }
        return $this->dic;
    }
    /**
     * @return PDO
     * @throws YapealConsoleException
     * @throws YapealDatabaseException
     */
    protected function getPdo()
    {
        if (null === $this->pdo) {
            try {
                $this->pdo = $this->getDic()['Yapeal.Database.Connection'];
            } catch (PDOException $exc) {
                $mess = sprintf(
                    'Could NOT connect to database. Database error was (%1$s) %2$s',
                    $exc->getCode(),
                    $exc->getMessage()
                );
                throw new YapealDatabaseException($mess, 1, $exc);
            }
        }
        return $this->pdo;
    }
    /**
     * @type CommonSqlQueries $csq
     */
    protected $csq;
    /**
     * @type string $cwd
     */
    protected $cwd;
    /**
     * @type ContainerInterface $dic
     */
    protected $dic;
    /**
     * @type PDO $pdo
     */
    protected $pdo;
}
