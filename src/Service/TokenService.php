<?php

namespace ZfbUser\Service;

use ZfbUser\Entity\TokenInterface;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Repository\TokenRepositoryInterface;
use ZfbUser\Mapper\TokenMapperInterface;
use ZfbUser\Options\ModuleOptionsInterface;

/**
 * Class TokenService
 *
 * @package ZfbUser\Service
 */
class TokenService
{
    /**
     * Токен для подтверждения аккаунта
     */
    public const TYPE_CONFIRMATION = 'confirmation_account';

    /**
     * Токен для сброса пароля
     */
    public const TYPE_RESET_PASSWORD = 'reset_password';

    /**
     * Token for set password for new added user
     */
    public const TYPE_SET_PASSWORD = 'set_password';

    /**
     * Время жизни токенов в минутах
     */
    protected const TYPE_TTL = [
        self::TYPE_CONFIRMATION   => 60 * 24 * 365, // 1 year
        self::TYPE_RESET_PASSWORD => 60 * 1, // 1 hour
        self::TYPE_SET_PASSWORD   => 60 * 24 * 7, // 7 days
    ];

    /**
     * TokenService constructor.
     *
     * @param \ZfbUser\Repository\TokenRepositoryInterface $repository
     * @param \ZfbUser\Mapper\TokenMapperInterface         $mapper
     * @param \ZfbUser\Options\ModuleOptionsInterface      $moduleOptions
     */
    public function __construct(
        TokenRepositoryInterface $repository,
        TokenMapperInterface $mapper,
        ModuleOptionsInterface $moduleOptions
    )
    {
        $this->repository = $repository;
        $this->mapper = $mapper;
        $this->moduleOptions = $moduleOptions;
    }

    /**
     * @return array
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_CONFIRMATION,
            self::TYPE_RESET_PASSWORD,
            self::TYPE_SET_PASSWORD,
        ];
    }

    /**
     * @var TokenRepositoryInterface
     */
    private $repository;

    /**
     * @var TokenMapperInterface
     */
    private $mapper;

    /**
     * @var ModuleOptionsInterface
     */
    private $moduleOptions;

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $type
     * @param bool                          $revokeOld
     *
     * @return \ZfbUser\Entity\TokenInterface
     * @throws \ZfbUser\Service\Exception\UnsupportedTokenTypeException
     */
    public function generateToken(UserInterface $user, string $type, bool $revokeOld = false): TokenInterface
    {
        if (!in_array($type, self::getTypes())) {
            throw new Exception\UnsupportedTokenTypeException();
        }

        if ($revokeOld === true) {
            $this->revokeTokens($user, $type);
        }

        $length = 50;
        $tokenValue = bin2hex(random_bytes($length));

        $className = $this->moduleOptions->getTokenEntityClass();
        /** @var TokenInterface $token */
        $token = new $className();

        $token->setUser($user);
        $token->setType($type);
        $token->setCreatedAt(new \DateTime());
        $token->setRevoked(false);
        $token->setValue($tokenValue);

        $ttl = self::TYPE_TTL[$type];
        $expiredAt = (new \DateTime())->modify("+ {$ttl} minutes");
        $token->setExpiredAt($expiredAt);

        $token = $this->mapper->insert($token);

        return $token;
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $type
     */
    public function revokeTokens(UserInterface $user, string $type)
    {
        $tokens = $this->repository->getActualTokens($user, $type);

        /** @var TokenInterface $token */
        foreach ($tokens as $token) {
            $token->setRevoked(true);
            $this->mapper->update($token);
        }
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param                               $code
     * @param string                        $type
     * @param bool                          $revokeOnValid Отозвать после успешной проверки? (одноразовый токен)
     *
     * @return bool
     */
    public function checkToken(UserInterface $user, $code, string $type, bool $revokeOnValid = true): bool
    {
        $token = $this->repository->getToken($user, $code, $type);
        if ($token === null) {
            return false;
        }

        if ($token->isRevoked()) {
            return false;
        }

        $now = new \DateTime();
        if ($token->getExpiredAt() <= $now) {
            return false;
        }

        if ($revokeOnValid === true) {
            $token->setRevoked(true);
            $this->mapper->update($token);
        }

        return true;
    }
}
