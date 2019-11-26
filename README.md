# Menu bundle

[![Check on packagist][packagist-badge]][packagist]
[![MIT License][license-badge]][LICENSE]

[![Watch on GitHub][github-watch-badge]][github-watch]
[![Star on GitHub][github-star-badge]][github-star]
[![Tweet][twitter-badge]][twitter]


[packagist-badge]: https://img.shields.io/packagist/v/disjfa/menu-bundle
[packagist]: https://packagist.org/packages/disjfa/menu-bundle
[license]: https://github.com/disjfa/menu-bundle/blob/master/LICENSE
[license-badge]: https://img.shields.io/github/license/disjfa/menu-bundle.svg
[github-watch-badge]: https://img.shields.io/github/watchers/disjfa/menu-bundle.svg?style=social
[github-watch]: https://github.com/disjfa/menu-bundle/watchers
[github-star-badge]: https://img.shields.io/github/stars/disjfa/menu-bundle.svg?style=social
[github-star]: https://github.com/disjfa/menu-bundle/stargazers
[twitter-badge]: https://img.shields.io/twitter/url/https/github.com/disjfa/menu-bundle.svg?style=social
[twitter]: https://twitter.com/intent/tweet?text=Check%20out%20menu-bundle!%20-%20Cool%mail%20setup%20for%20symfony!%20Thanks%20@disjfa%20https://github.com/disjfa/menu-bundle%20%F0%9F%A4%97

### What does it do

This bundle adds two menu builders for your project. One for the site side, and one for the admin. This can help it to make live easier to generate menu structures. You can take a look at [glynn-admin-symfony4](https://github.com/disjfa/glynn-admin-symfony4) for a simple working example. It is using the [KnpMenuBundle](https://symfony.com/doc/master/bundles/KnpMenuBundle/index.html).

It is opinionated, it is setup using the bootstrap4 template

### Instalation

```
composer req disjfa/menu-bundle
```

## Setup

In the template you have to add a menu.
```twig
{{ knp_menu_render('admin', {'currentClass': 'active', 'ancestorClass': 'active', 'depth':3, 'template': 'admin/menu.html.twig'}) }}
```
or
```twig
{{ knp_menu_render('site', {'currentClass': 'active', 'ancestorClass': 'active', 'depth':2, 'template': 'admin/menu.html.twig'}) }}
```

### Resister a menu

And then, in your code you can just subscribe to the menus to add your own

```php
<?php

namespace App\Menu;

use Disjfa\MenuBundle\Menu\ConfigureSiteMenu;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuListener implements EventSubscriberInterface
{
    public function onMenuConfigure(ConfigureSiteMenu $event)
    {
        $menu = $event->getMenu();

        $menu->addChild('my_route', [
            'route' => 'my_route',
            'label' => 'My route title',
        ])->setExtra('icon', 'fa-home');
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigureSiteMenu::class => ['onMenuConfigure', 999]
        ];
    }
}
```

Or you can subscribe to the `ConfigureAdminMenu` event to do the same for the admin menu.

### And done

And now we are done. Make menus, be awesome!
