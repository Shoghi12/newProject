<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Form\ContactDynamiqueForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('ContactDynamique')]
final class ContactDynamique
{
    use DefaultActionTrait;

    #[LiveProp]
    public $name = '';

    #[LiveProp]
    public $email = '';

    #[LiveAction]
    public function shouldShowEmail(): bool
    {
        return strtolower($this->name) === 'john';
    }
}
