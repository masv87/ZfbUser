<?php

namespace ZfbUser\Adapter;

use Zend\Crypt\Password\Bcrypt;
use ZfbUser\AuthenticationResult;
use ZfbUser\Entity\UserInterface;

/**
 * Class DbAdapter
 *
 * @package ZfbUser\Adapter
 */
class DbAdapter extends AbstractAdapter
{
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
                $bCrypt = new Bcrypt();
                $bCrypt->setCost($this->getModuleOptions()->getPasswordCost());
                if (!$bCrypt->verify($this->getCredential(), $user->getCredential())) {
                    $code = AuthenticationResult::FAILURE_CREDENTIAL_INVALID;
                }

                // Update user password hash if the cost parameter has changed
                $this->updateUserPasswordHash($user, $this->getCredential(), $bCrypt);
            }
        }

        $messages = [AuthenticationResult::MESSAGE_TEMPLATES[ $code ]];
        $result = new AuthenticationResult($code, $user, $messages);

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function cryptCredential(string $credential): string
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost($this->getModuleOptions()->getPasswordCost());

        return $bcrypt->create($credential);
    }

    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $password
     * @param \Zend\Crypt\Password\Bcrypt   $bCrypt
     *
     * @return \ZfbUser\Entity\UserInterface
     */
    protected function updateUserPasswordHash(UserInterface $user, string $password, Bcrypt $bCrypt): UserInterface
    {
        $hash = explode('$', $user->getCredential());
        if ($hash[2] !== $bCrypt->getCost()) {
            $user->setCredential($bCrypt->create($password));
            $this->getMapper()->update($user);
        }

        return $user;
    }
}
