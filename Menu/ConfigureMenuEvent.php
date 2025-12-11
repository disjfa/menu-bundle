<?php

namespace Disjfa\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @deprecated use ConfigureAdminMenu or ConfigureSiteMenu instead
 */
class ConfigureMenuEvent extends Event
{
    public const ADMIN = 'admin.menu_configure';
    public const SITE = 'site.menu_configure';

    public function __construct(private readonly FactoryInterface $factory, private readonly ItemInterface $menu)
    {
    }

    /**
     * @return FactoryInterface
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @return ItemInterface
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
