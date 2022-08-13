<?php

namespace Ryssbowh\Gtag\services;

use Ryssbowh\Gtag\Gtag as Plugin;
use craft\base\Component;
use craft\web\View;
use yii\base\Event;

class Gtag extends Component
{
    /**
     * Register tags code
     */
    public function registerCode()
    {
        $measurementId = $this->getMeasurementId();
        $onlyProduction = $this->getOnlyProduction();

        if (!$measurementId or ($onlyProduction and getenv('ENVIRONMENT') != 'production')) {
            return;
        }
        if (substr($measurementId, 0, 3) === 'GTM') {
            $this->registerGTMHead();
            $this->registerGTMBody();
            return;
        }
        $this->registerUAHead();
    }

    /**
     * Register head code for UA/UA4 tags
     */
    protected function registerUAHead()
    {
        $measurementId = $this->getMeasurementId();
        $site = \Craft::$app->sites->getCurrentSite();
        $domain = trim(preg_replace('/(http|https):\/\//', '', $site->getBaseUrl()), '/');

        \Craft::$app->view->registerJsFile('https://www.googletagmanager.com/gtag/js?id=' . $measurementId, ['position' => View::POS_HEAD, 'async'=>true]);
        \Craft::$app->view->registerJs('window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag("js", new Date());

  gtag("config", "' . $measurementId . '", {
    cookie_flags: "' . $this->getCookieFlags() . '",
    cookie_domain: "' . $domain . '"
    });', View::POS_HEAD);
    }

    /**
     * Register body code for GTM tags
     */
    protected function registerGTMBody()
    {
        Event::on(View::class, View::EVENT_BEGIN_BODY, function () {
            echo '<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . $this->getMeasurementId() . '"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->';
        });
    }

    /**
     * Register head code for GTM tags
     */
    protected function registerGTMHead()
    {
        \Craft::$app->view->registerJs("(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','" . $this->getMeasurementId() . "');", View::POS_HEAD);
    }

    /**
     * Get measurement id for current site
     * 
     * @return ?string
     */
    protected function getMeasurementId(): ?string
    {
        $settings = Plugin::$plugin->settings;
        return $settings->getMeasurementId(\Craft::$app->sites->getCurrentSite());
    }

    /**
     * Get production only setting for current site
     * 
     * @return bool
     */
    protected function getOnlyProduction(): bool
    {
        $settings = Plugin::$plugin->settings;
        return $settings->getOnlyProduction(\Craft::$app->sites->getCurrentSite());
    }

    /**
     * Get cookie flag for current site
     * 
     * @return ?string
     */
    protected function getCookieFlags(): ?string
    {
        $settings = Plugin::$plugin->settings;
        return $settings->getCookieFlags(\Craft::$app->sites->getCurrentSite());
    }
}