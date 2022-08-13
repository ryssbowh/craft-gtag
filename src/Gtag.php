<?php

namespace Ryssbowh\Gtag;

use Craft;
use Ryssbowh\Gtag\models\Settings;
use Ryssbowh\Gtag\services\Gtag as GtagService;
use craft\base\Model;
use craft\base\Plugin;
use craft\web\View;
use yii\base\Event;

class Gtag extends Plugin
{
    public static $plugin;

    public bool $hasCpSettings = true;

    /**
     * @inheritDoc
     */
    public function init(): void
    {
        parent::init();

        static::$plugin = $this;

        $this->setComponents([
            'gtag' => GtagService::class
        ]);

        if (Craft::$app->request->getIsSiteRequest()) {
            Gtag::$plugin->gtag->registerCode();
        }
    }

    /**
     * @inheritDoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @inheritDoc
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
