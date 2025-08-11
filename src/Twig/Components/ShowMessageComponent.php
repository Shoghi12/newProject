<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ShowMessageComponent
{
     use DefaultActionTrait;

    #[LiveProp]
    public bool $show = false;

    #[LiveAction]
    public function showMessage(): void
    {
        $this->show = true;
    }
}
