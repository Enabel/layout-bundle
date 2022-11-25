<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle;

use Enabel\LayoutBundle\DependencyInjection\LayoutBundleExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EnabelLayoutBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new LayoutBundleExtension();
    }
}
