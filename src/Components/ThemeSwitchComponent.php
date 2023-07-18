<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

/**
 * @codeCoverageIgnore
 */
#[AsTwigComponent('theme-switch', '@EnabelLayout/components/theme-switch.html.twig')]
class ThemeSwitchComponent
{
}
