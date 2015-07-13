<?php

namespace UserBundle\Security\Authorization\Voter;

use UserBundle\Entity\Reception;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class SuperAdminVoter
 * @package UserBundle\Security\Authorization\Voter
 */
class SuperAdminVoter implements VoterInterface
{
    /**
     * Name of super admin role
     */
    const SUPER_ADMIN_ROLE = 'ROLE_SUPER_ADMIN';

    /**
     * Checks if the voter supports the given attribute.
     *
     * @param string $attribute An attribute
     *
     * @return bool true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * Checks if the voter supports the given class.
     *
     * @param string $class A class name
     *
     * @return bool true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token      A TokenInterface instance
     * @param object|null $object     The object to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        /** @var UserInterface $user */
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $roles = $user->getRoles();
        if (in_array(self::SUPER_ADMIN_ROLE, $roles)) {
            return VoterInterface::ACCESS_GRANTED;
        }

        return VoterInterface::ACCESS_ABSTAIN;
    }

    /**
     * @param object $object
     * @param string $action
     * @return string
     */
    private function getBaseRoleName($object)
    {
        $className = get_class($object);
        if (!isset(self::$baseRoleNames[$className])) {
            $reflection = new \ReflectionClass($object);

            $underscoreClassName = strtoupper(Container::underscore($reflection->getShortName()));
            self::$baseRoleNames[$className] = sprintf('ROLE_%s', $underscoreClassName);
        }


        return self::$baseRoleNames[$className];
    }

    /**
     * @param object $object
     * @param string $action
     * @return string
     */
    private function getRoleNameForObject($object, $action)
    {
        $baseRoleName = $this->getBaseRoleName($object);
        return sprintf('%s_%s', $baseRoleName, $action);
    }

    /**
     * @param object $object
     * @param string $attribute
     * @return bool|string
     */
    private function getActionRole($object, $attribute)
    {
        $baseRoleName = $this->getBaseRoleName($object);
        if (strpos($attribute, $baseRoleName) === 0) {
            return substr($attribute, strlen($baseRoleName) + 1);
        }

        return false;
    }
}