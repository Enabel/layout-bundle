<?php

declare(strict_types=1);

namespace Enabel\LayoutBundle\Tests;

use Enabel\LayoutBundle\EnabelLayoutBundle;
use PHPUnit\Framework\TestCase;

class EnabelLayoutBundleTest extends TestCase
{
    public function testGetPath(): void
    {
        $this->assertSame(\dirname(__DIR__), (new EnabelLayoutBundle())->getPath());
    }
}
