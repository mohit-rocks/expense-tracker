<?php

namespace App\Security;

use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CategoryVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports(string $attribute, $subject): bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])) {
            return false;
        }

        if (!$subject instanceof Category) {
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

        /** @var Category $category */
        $category = $subject;

        return match ($attribute) {
            self::VIEW => $this->canView($category, $user),
            self::EDIT => $this->canEdit($category, $user),
            self::DELETE => $this->canDelete($category, $user),
            default => false,
        };
    }

    private function canView(Category $category, User $user): bool
    {
        return $user === $category->getCreatedBy();
    }

    private function canEdit(Category $category, User $user): bool
    {
        return $user === $category->getCreatedBy();
    }

    private function canDelete(Category $category, User $user): bool
    {
        return $user === $category->getCreatedBy();
    }
}
