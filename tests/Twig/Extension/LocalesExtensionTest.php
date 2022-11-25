<?php

namespace Enabel\LayoutBundle\Tests\Twig\Extension;

use Enabel\LayoutBundle\Twig\Extension\LocalesExtension;
use PHPUnit\Framework\TestCase;

class LocalesExtensionTest extends TestCase
{
    public function testGetFunctions(): void
    {
        $extension = new LocalesExtension();
        $functions = $extension->getFunctions();
        $this->assertSame('locales', $functions[0]->getName());
    }

    public function testGetLocalesDefault(): void
    {
        $extension = new LocalesExtension();
        $this->assertCount(2, $extension->getLocales());
    }

    public function testGetLocales(): void
    {
        $extension = new LocalesExtension('fr');
        /** @var array<array<string, string>> $locales */
        $locales = $extension->getLocales();
        $this->assertCount(1, $locales);
        $this->assertSame('fr', $locales[0]['code']);
        $this->assertSame('français', $locales[0]['name']);
        $this->assertSame('fr', $locales[0]['icon']);
    }

    public function testLocalesIconMutation(): void
    {
        // Check if locale en return gb as icon
        $extension = new LocalesExtension('en');
        /** @var array<array<string, string>> $locales */
        $locales = $extension->getLocales();
        $this->assertSame('en', $locales[0]['code']);
        $this->assertSame('gb', $locales[0]['icon']);
    }
}
