<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Components;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('alert', '@EnabelLayout/components/alert.html.twig')]
class AlertComponent
{
    #[ExposeInTemplate]
    private ?string $message = null;
    #[ExposeInTemplate]
    private string $type = '';
    #[ExposeInTemplate]
    private ?string $icon = null;

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

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
        $resolver->setDefaults(['alertType' => 'success']);
        $resolver->setAllowedValues('alertType', ['success', 'danger', 'error', 'warning', 'info']);
        $resolver->setRequired('message');
        $resolver->setAllowedTypes('message', 'string');

        return $resolver->resolve($data);
    }

    public function mount(string $alertType = 'success'): void
    {
        $this->setIconByType($alertType);
    }

    private function setIconByType(string $type): void
    {
        switch ($type) {
            case 'error':
            case 'danger':
                $this->icon = 'fa-circle-exclamation';
                $this->type = 'danger';
                break;

            case 'warning':
                $this->icon = 'fa-triangle-exclamation';
                $this->type = 'warning';
                break;

            case 'info':
                $this->icon = 'fa-circle-info';
                $this->type = 'info';
                break;

            case 'success':
            default:
                $this->icon = 'fa-circle-check';
                $this->type = 'success';
                break;
        }
    }
}
