<?php

namespace Disjfa\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\MenuFactory;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SiteMenuBuilder
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var MenuFactory
     */
    private $factory;

    /**
     * @var MatcherInterface
     */
    private $matcher;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * MainBuilder constructor.
     */
    public function __construct(ContainerInterface $container, FactoryInterface $factory, MatcherInterface $matcher, EventDispatcherInterface $eventDispatcher)
    {
        $this->container = $container;
        $this->factory = $factory;
        $this->matcher = $matcher;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return ItemInterface
     */
    public function build()
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'navbar-nav mr-auto',
            ],
        ]);

        $this->eventDispatcher->dispatch(new ConfigureSiteMenu($this->factory, $menu));
        $this->eventDispatcher->dispatch(new ConfigureMenuEvent($this->factory, $menu), ConfigureMenuEvent::SITE);

        $this->setupMenuData($menu->getChildren());

        return $menu;
    }

    /**
     * @param MenuItem[] $children
     */
    public function setupMenuData(array $children)
    {
        $childIndex = 0;
        foreach ($children as $child) {
            ++$childIndex;

            if (count($child->getChildren()) > 0) {
                $itemId = sprintf('menu-%d-%d', $child->getLevel(), $childIndex + 1);

                $child->setUri('#'.$itemId);
                $child->setAttribute('class', 'nav-item dropdown');
                $child->setLinkAttribute('class', 'nav-link dropdown-toggle ');

                $child->setLinkAttribute('data-toggle', 'dropdown');
                $child->setChildrenAttribute('class', 'dropdown-menu');

                $child->setChildrenAttribute('id', $itemId);

                $this->setupMenuData($child->getChildren());
            } else {
                if ($child->getLevel() > 1) {
                    $child->setLinkAttribute('class', 'dropdown-item');
                } else {
                    $child->setLinkAttribute('class', 'nav-link ');
                }
                $child->setAttribute('class', 'nav-item');
            }
        }
    }
}
