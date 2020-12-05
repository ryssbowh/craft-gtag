<?php

namespace Ryssbowh\Gtag;

use Craft;
use craft\base\Plugin;

class Gtag extends Plugin
{
    public static $plugin;

    public $hasCpSettings = true;

    public $controllerNamespace = "Ryssbowh\\Gtag\\Controllers";

    public function init()
    {
        parent::init();

        $measurementId = $this->getSettings()->measurementId;

        $js = '<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'GA_MEASUREMENT_ID');
</script>
';
        if ($measurementId) {
            Event::on(View::class, View::EVENT_BEFORE_RENDER_PAGE_TEMPLATE, function () {
                dd(1);
            });
        }
    }
}
