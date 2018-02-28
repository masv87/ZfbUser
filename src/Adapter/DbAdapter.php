<?php

namespace ZfbUser\Adapter;

use Zend\Crypt\Password\Bcrypt;
use ZfbUser\AuthenticationResult;
use ZfbUser\Entity\UserInterface;
use ZfbUser\Mapper\UserMapperInterface;
use ZfbUser\Options\ModuleOptionsInterface;
use ZfbUser\Repository\UserRepositoryInterface;

/**
 * Class DbAdapter
 *
 * @package ZfbUser\Adapter
 */
class DbAdapter extends AbstractAdapter
{

    /**
     * @var Bcrypt
     */
    protected $bcrypt;

    /**
     * DbAdapter constructor.
     *
     * @param \ZfbUser\Options\ModuleOptionsInterface     $moduleOptions
     * @param \ZfbUser\Mapper\UserMapperInterface         $mapper
     * @param \ZfbUser\Repository\UserRepositoryInterface $repository
     */
    public function __construct(ModuleOptionsInterface $moduleOptions, UserMapperInterface $mapper, UserRepositoryInterface $repository)
    {
        parent::__construct($moduleOptions, $mapper, $repository);

        $this->bcrypt = new Bcrypt();
        $this->bcrypt->setCost($this->getModuleOptions()->getPasswordCost());
    }

    /**
     * @inheritdoc
     */
    public function authenticate(): AuthenticationResult
    {
        $code = AuthenticationResult::SUCCESS;

        /** @var UserInterface $user */
        $user = $this->getRepository()->getUserByIdentity($this->getIdentity());
        if (is_null($user)) {
            $code = AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND;
        } else {
            if ($this->getModuleOptions()->isEnableIdentityConfirmation() && $user->isIdentityConfirmed() !== true) {
                $code = AuthenticationResult::FAILURE_IDENTITY_NOT_CONFIRMED;
            } else {
                if (!$this->verifyCredential($this->getCredential(), $user->getCredential())) {
                    $code = AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
                }

                // Update user password hash if the cost parameter has changed
                $this->updateUserPasswordHash($user, $this->getCredential());
            }
        }

        $messages = [AuthenticationResult::MESSAGE_TEMPLATES[$code]];
        $result = new AuthenticationResult($code, $user, $messages);

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function cryptCredential(string $credential): string
    {
        return $this->bcrypt->create($credential);
    }

    /**
     * @inheritdoc
     */
    public function verifyCredential(string $credential, string $hash): bool
    {
        return $this->bcrypt->verify($credential, $hash);
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $password
     *
     * @return \ZfbUser\Entity\UserInterface
     */
    protected function updateUserPasswordHash(UserInterface $user, string $password): UserInterface
    {
        $hash = explode('$', $user->getCredential());
        if ($hash[2] !== $this->bcrypt->getCost()) {
            $user->setCredential($this->bcrypt->create($password));
            $this->getMapper()->update($user);
        }

        return $user;
    }
}
