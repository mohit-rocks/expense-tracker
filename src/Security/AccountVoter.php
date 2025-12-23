<?php

namespace App\Security;

use App\Entity\Account;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AccountVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Account) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Account $account */
        $account = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($account, $user),
            self::EDIT => $this->canEdit($account, $user),
            self::DELETE => $this->canDelete($account, $user),
            default => false,
        };
    }

    private function canView(Account $account, User $user): bool
    {
        return $user === $account->getCreatedBy();
    }

    private function canEdit(Account $account, User $user): bool
    {
        return $user === $account->getCreatedBy();
    }

    private function canDelete(Account $account, User $user): bool
    {
        return $user === $account->getCreatedBy();
    }
}
