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
#[AsTwigComponent('locale-switch', '@EnabelLayout/components/locale-switch.html.twig')]
class LocaleSwitchComponent
{
    #[ExposeInTemplate]
    private string $routeName = '';
    #[ExposeInTemplate]
    private bool $showName = true;

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    #[PreMount]
    public function preMount(array $data): array
    {
        // validate data
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['routeName' => '']);
        $resolver->setAllowedTypes('routeName', 'string');
        $resolver->setDefaults(['showName' => true]);
        $resolver->setAllowedTypes('showName', 'bool');

        return $resolver->resolve($data);
    }

    public function mount(string $routeName = '', bool $showName = true): void
    {
        $this->setRouteName($routeName);
        $this->setShowName($showName);
    }

    public function getRouteName(): string
    {
        return $this->routeName;
    }

    public function setRouteName(string $routeName): void
    {
        $this->routeName = $routeName;
    }

    public function isShowName(): bool
    {
        return $this->showName;
    }

    public function setShowName(bool $showName): void
    {
        $this->showName = $showName;
    }
}
