<?php

namespace UserBundle\Entity;

/**
 * Interface HasOwnerInterface
 * @package UserBundle\Entity
 */
interface HasOwnerInterface
{
    /**
     * Return array of owner fields
     *
     * @return array
     */
    public static function getOwnerFields();
}