# Menus plugin for Craft CMS 3.5.x

## Templating

Load menu : `{% set menu = craft.simplemenus.getMenu('handle') %}`

Render it : `{{ menu.render()|raw }}`

You can override the templates `simplemenus/menu.twig` and `simplemenus/item.twig` if you want more control.

You can also render the menu with a different template : `{{ menu.render('my-template')|raw }}`

Same with items : `{{ item.render('my-template')|raw }}`

Available variables in item templates :
- item
- url
- hasActiveChildren
- isActive

## Active items

The active item(s) will be detected automatically regarding the item url and the current request.

You can override the active item(s) in your template by calling :

`{% do craft.simplemenus.setActiveItems('menu-handle', 'item-shorcut') %}` before the menu is rendered.

Or several at once :

`{% do craft.simplemenus.setActiveItems('mainNavigation', ['shortcut1', 'shortcut2']) %}`

If the active items are set manually for a menu, the system **will not** look at the request to figure out active items.