<?php

namespace ZfbUser\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use ZfbUser\Entity\TokenInterface;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class UserRepository
 *
 * @package ZfbUser\Repository
 */
class TokenRepository extends EntityRepository implements TokenRepositoryInterface
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

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $value
     * @param string                        $type
     *
     * @return null|\ZfbUser\Entity\TokenInterface
     */
    public function getToken(UserInterface $user, string $value, string $type): ?TokenInterface
    {
        /** @var TokenInterface|null $token */
        $token = $this->findOneBy([
            'user'  => $user,
            'value' => $value,
            'type'  => $type,
        ]);

        return $token;
    }

    /**
     * @param null|\ZfbUser\Entity\UserInterface $user
     * @param null|string                        $type
     *
     * @return TokenInterface[]
     */
    public function getActualTokens(?UserInterface $user, ?string $type): array
    {
        $now = new \DateTime();

        $qb = $this->createQueryBuilder('t')
            ->select('t')
            ->where('t.revoked = :revoked')->setParameter('revoked', false)
            ->andWhere('t.expiredAt > :expiredAt')->setParameter('expiredAt', $now)
            ->orderBy('t.id', 'ASC');

        if ($user !== null) {
            $qb->andWhere('t.user = :user')->setParameter('user', $user);
        }

        if ($type !== null) {
            $qb->andWhere('t.type = :type')->setParameter('type', $type);
        }


        /** @var TokenInterface[] $tokens */
        $tokens = $qb->getQuery()->getResult();

        return $tokens;
    }
}
