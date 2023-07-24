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
#[AsTwigComponent('user-menu', '@EnabelLayout/components/user-menu.html.twig')]
class UserMenuComponent
{
    private string $loginRoute;
    private string $logoutRoute;
    /**
     * @var array{}|array{int, array{
     *     icon: string,
     *     label: string,
     *     url: string
     * }}
     */
    private array $actions;

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
        $resolver->setDefaults(['loginRoute' => '']);
        $resolver->setAllowedTypes('loginRoute', 'string');
        $resolver->setDefaults(['logoutRoute' => '']);
        $resolver->setAllowedTypes('loginRoute', 'string');
        $resolver->setDefaults(['actions' => []]);
        $resolver->setAllowedTypes('actions', 'array');

        return $resolver->resolve($data);
    }

    /**
     * @param array{}|array{int, array{
     *     icon: string,
     *     label: string,
     *     url: string
     * }} $actions
     */
    public function mount(string $loginRoute = '', string $logoutRoute = '', array $actions = []): void
    {
        $this->loginRoute = $loginRoute;
        $this->logoutRoute = $logoutRoute;
        $this->actions = $actions;
    }

    #[ExposeInTemplate]
    public function getLoginRoute(): string
    {
        return $this->loginRoute;
    }

    #[ExposeInTemplate]
    public function getLogoutRoute(): string
    {
        return $this->logoutRoute;
    }

    /**
     * @return array{}|array{int, array{
     *     icon: string,
     *     label: string,
     *     url: string
     * }}
     */
    #[ExposeInTemplate]
    public function getActions(): array
    {
        return $this->actions;
    }
}
