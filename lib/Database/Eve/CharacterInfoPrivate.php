<?php
/**
 * Contains CharacterInfoPrivate class.
 *
 * PHP version 5.4
 *
 * LICENSE:
 * This file is part of Yet Another Php Eve Api Library also know as Yapeal
 * which can be used to access the Eve Online API data and place it into a
 * database.
 * Copyright (C) 2014-2015 Michael Cummings
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
 * @author    Stephen Gulick <stephenmg12@gmail.com>
 */
namespace Yapeal\Database\Eve;

use LogicException;
use Yapeal\Xml\EveApiPreserverInterface;
use Yapeal\Xml\EveApiReadWriteInterface;
use Yapeal\Xml\EveApiRetrieverInterface;

/**
 * Class CharacterInfoPrivate
 */
class CharacterInfoPrivate extends CharacterInfo
{
    /**
     * @param EveApiReadWriteInterface $data
     * @param EveApiRetrieverInterface $retrievers
     * @param EveApiPreserverInterface $preservers
     * @param int                      $interval
     *
     * @throws LogicException
     */
    public function autoMagic(
        EveApiReadWriteInterface $data,
        EveApiRetrieverInterface $retrievers,
        EveApiPreserverInterface $preservers,
        $interval
    ) {
        $this->getLogger()
             ->debug(
                 sprintf(
                     'Starting autoMagic for %1$s/%2$s',
                     $this->getSectionName(),
                     $this->getApiName()
                 )
             );
        /**
         * Update CharacterInfo public first so it does NOT overwrite additional
         * information from private in cases were keys have overlap.
         */
        $class = new CharacterInfoPublic(
            $this->getPdo(), $this->getLogger(), $this->getCsq()
        );
        $class->autoMagic(
            $data,
            $retrievers,
            $preservers,
            $interval
        );
        $active = $this->getActiveCharacters();
        if (0 === count($active)) {
            $this->getLogger()
                 ->info('No active characters found');
            return;
        }
        foreach ($active as $char) {
            $data->setEveApiSectionName(strtolower($this->getSectionName()))
                 ->setEveApiName($this->getApiName());
            if ($this->cacheNotExpired(
                $this->getApiName(),
                $this->getSectionName(),
                $char['characterID']
            )
            ) {
                continue;
            }
            $data->setEveApiArguments($char)
                 ->setEveApiXml();
            $untilInterval = $interval;
            if (!$this->oneShot(
                $data,
                $retrievers,
                $preservers,
                $untilInterval
            )
            ) {
                continue;
            }
            $this->updateCachedUntil(
                $data->getEveApiXml(),
                $untilInterval,
                $char['characterID']
            );
        }
    }
    /**
     * @type int $mask
     */
    protected $mask = 16777216;
}
