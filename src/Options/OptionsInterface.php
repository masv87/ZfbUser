<?php

namespace ZfbUser\Options;

/**
 * Interface OptionsInterface
 *
 * @package ZfbUser\Options
 */
interface OptionsInterface
{
    /**
     * @see \Zend\Stdlib\AbstractOptions::setFromArray
     *
     * @param array|\Traversable|OptionsInterface $options
     *
     * @return $this
     */
    public function setFromArray($options);

    /**
     * @return array
     */
    public function toArray();
}
