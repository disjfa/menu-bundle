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
    const ADMIN = 'admin.menu_configure';
    const SITE = 'site.menu_configure';
    /**
     * @var FactoryInterface
     */
    private $factory;
    /**
     * @var ItemInterface
     */
    private $menu;

    public function __construct(FactoryInterface $factory, ItemInterface $menu)
    {
        $this->factory = $factory;
        $this->menu = $menu;
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
