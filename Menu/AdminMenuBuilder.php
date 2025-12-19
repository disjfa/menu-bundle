<?php

namespace Disjfa\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AdminMenuBuilder
{
    /**
     * MainBuilder constructor.
     */
    public function __construct(private readonly FactoryInterface $factory, private readonly MatcherInterface $matcher, private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * @return ItemInterface
     */
    public function build()
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav nav-underline flex-column',
            ],
        ]);

        $this->eventDispatcher->dispatch(new ConfigureAdminMenu($this->factory, $menu));
        $this->eventDispatcher->dispatch(new ConfigureMenuEvent($this->factory, $menu), ConfigureMenuEvent::ADMIN);

        $this->setupMenuData($menu->getChildren());

        return $menu;
    }

    /**
     * @param MenuItem[] $children
     * @param bool       $hasCurrent
     *
     * @return bool
     */
    public function setupMenuData(array $children, $hasCurrent = false)
    {
        $childIndex = 0;
        foreach ($children as $child) {
            ++$childIndex;

            if (count($child->getChildren()) > 0) {
                $itemId = sprintf('menu-%d-%d', $child->getLevel(), $childIndex + 1);

                $child->setUri('#'.$itemId);
                $child->setAttribute('class', 'nav-item');

                if ($this->matcher->isAncestor($child)) {
                    $child->setChildrenAttribute('class', 'nav nav-underline flex-column ps-3 border-start border-primary');
                    $child->setLinkAttribute('class', 'nav-link');
                } else {
                    $child->setLinkAttribute('class', 'nav-link');
                    $child->setChildrenAttribute('class', 'nav nav-underline flex-column ps-3 border-start border-primary');
                }
                $child->setChildrenAttribute('id', $itemId);

                $this->setupMenuData($child->getChildren());
            } else {
                $child->setAttribute('class', 'nav-item');
                $child->setLinkAttribute('class', 'nav-link');
            }
        }

        return $hasCurrent;
    }
}
