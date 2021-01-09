# Gtag plugin for Craft CMS 3.5.x

## 1.3 update

The \_ga cookie will now be loaded with a flag "SameSite=Lax;Secure" by default.
This will be a problem for sites that don't run under https, check your browser console for issues, it can be disabledin the settings.

## 1.2 update

Enter your measurement ID again for all sites after updating to 1.2

## Installation

- Install : `composer require ryssbowh/craft-gtag`

- Enable : `./craft plugin/install gtag`

- Enter your measurement Id in the settings. No measurement ID means gtag is disabled.

Done