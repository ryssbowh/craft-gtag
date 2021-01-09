<?php

namespace Ryssbowh\Gtag;

use Craft;
use Ryssbowh\Gtag\Models\Settings;
use craft\base\Plugin;
use craft\web\View;
use yii\base\Event;

class Gtag extends Plugin
{
    public static $plugin;

    public $hasCpSettings = true;

    public $controllerNamespace = "Ryssbowh\\Gtag\\Controllers";

    public function init()
    {
        parent::init();

        $site = Craft::$app->sites->getCurrentSite();
        $measurementId = $this->getSettings()->getMeasurementId($site);
        $onlyProduction = $this->getSettings()->getOnlyProduction($site);
        $cookieFlag = $this->getSettings()->getCookieFlags($site);
        $domain = trim(preg_replace('/(http|https):\/\//', '', $site->getBaseUrl()), '/');

        if (!Craft::$app->request->getIsSiteRequest() or !$measurementId or ($onlyProduction and getenv('ENVIRONMENT') != 'production')) {
            return;
        }

        Event::on(View::class, View::EVENT_BEGIN_BODY, function () use ($measurementId, $cookieFlag, $domain) {
            echo '<script async src="https://www.googletagmanager.com/gtag/js?id='.$measurementId.'"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "'.$measurementId.'", {
    cookie_flags: "'.$cookieFlag.'",
    cookie_domain: "'.$domain.'"
    });
</script>';
        });
    }

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'gtag/settings',
            [
                'settings' => $this->getSettings(),
                'sites' => \Craft::$app->sites->getAllSites()
            ]
        );
    }
}
