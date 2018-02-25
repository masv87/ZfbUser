<?php

namespace ZfbUser\Service;

use ZfbUser\Entity\UserInterface;

/**
 * Interface MailSenderInterface
 *
 * @package ZfbUser\Service
 */
interface MailSenderInterface
{
    /**
     * @param \ZfbUser\Entity\UserInterface $user
     * @param string                        $template
     * @param array                         $data
     */
    public function send(UserInterface $user, string $template, array $data): void;
}
