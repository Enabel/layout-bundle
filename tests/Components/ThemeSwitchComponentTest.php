<?php

namespace Enabel\LayoutBundle\Tests\Components;

use Enabel\LayoutBundle\Components\ThemeSwitchComponent;
use PHPUnit\Framework\TestCase;

class ThemeSwitchComponentTest extends TestCase
{
    public function testComponentInstantiation(): void
    {
        // Even though this component is simple with no methods, 
        // we should still test that it can be instantiated without errors
        $component = new ThemeSwitchComponent();
        
        // Simple assertion to verify component is created
        $this->assertInstanceOf(ThemeSwitchComponent::class, $component);
    }
}