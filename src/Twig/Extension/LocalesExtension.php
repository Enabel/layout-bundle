<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Twig\Extension;

use Symfony\Component\Intl\Locales;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LocalesExtension extends AbstractExtension
{
    /** @var array<string>  */
    private array $localeCodes;
    /** @var array<array<string, string>|string>|null  */
    private ?array $locales = null;

    // The $locales argument is injected thanks to the service container.
    public function __construct(string $supportedLocales = 'fr|en')
    {
        $localeCodes = explode('|', $supportedLocales);
        sort($localeCodes);
        $this->localeCodes = $localeCodes;
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }

    /**
     * Takes the list of codes of the locales (languages) enabled in the
     * application and returns an array with the name of each locale written
     * in its own language (e.g. English, Français, Nederlands, ...).
     *
     * @return array<array<string, string>|string> The array of locale in its own language
     */
    public function getLocales(): array
    {
        if (null !== $this->locales) {
            return $this->locales;
        }

        $this->locales = [];
        foreach ($this->localeCodes as $localeCode) {
            $this->locales[] = [
                'code' => $localeCode,
                'name' => Locales::getName($localeCode, $localeCode),
                'icon' => str_replace('en', 'gb', $localeCode),
            ];
        }

        return $this->locales;
    }
}
