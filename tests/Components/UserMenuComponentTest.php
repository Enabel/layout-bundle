<?php

namespace Enabel\LayoutBundle\Tests\Components;

use Enabel\LayoutBundle\Components\UserMenuComponent;
use PHPUnit\Framework\TestCase;

class UserMenuComponentTest extends TestCase
{
    public function testMountWithDefaults(): void
    {
        $component = new UserMenuComponent();
        $component->mount();

        $this->assertSame('', $component->getLoginRoute());
        $this->assertSame('', $component->getLogoutRoute());
        $this->assertSame([], $component->getActions());
    }

    public function testMountWithCustomValues(): void
    {
        $component = new UserMenuComponent();
        $loginRoute = 'app_login';
        $logoutRoute = 'app_logout';
        $actions = [
            [
                'icon' => 'user',
                'label' => 'Profile',
                'url' => '/profile'
            ]
        ];

        $component->mount($loginRoute, $logoutRoute, $actions);

        $this->assertSame($loginRoute, $component->getLoginRoute());
        $this->assertSame($logoutRoute, $component->getLogoutRoute());
        $this->assertSame($actions, $component->getActions());
    }

    public function testPreMount(): void
    {
        $component = new UserMenuComponent();

        $data = [
            'loginRoute' => 'app_login',
            'logoutRoute' => 'app_logout',
            'actions' => [
                [
                    'icon' => 'user',
                    'label' => 'Profile',
                    'url' => '/profile'
                ]
            ]
        ];

        $result = $component->preMount($data);

        $this->assertSame($data['loginRoute'], $result['loginRoute']);
        $this->assertSame($data['logoutRoute'], $result['logoutRoute']);
        $this->assertSame($data['actions'], $result['actions']);
    }

    public function testPreMountWithDefaults(): void
    {
        $component = new UserMenuComponent();

        $result = $component->preMount([]);

        $this->assertSame('', $result['loginRoute']);
        $this->assertSame('', $result['logoutRoute']);
        $this->assertSame([], $result['actions']);
    }
}
