<?php

namespace ZfbUser\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class LogRepository
 *
 * @package ZfbUser\Repository
 */
class LogRepository extends EntityRepository implements LogRepositoryInterface
{
    /**
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * TokenRepository constructor.
     *
     * @param                                         $em
     * @param \Doctrine\ORM\Mapping\ClassMetadata     $class
     * @param \ZfbUser\Options\ModuleOptionsInterface $moduleOptions
     */
    public function __construct($em, ClassMetadata $class, ModuleOptionsInterface $moduleOptions)
    {
        parent::__construct($em, $class);

        $this->moduleOptions = $moduleOptions;
    }
}
