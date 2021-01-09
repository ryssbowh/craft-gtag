<?php

namespace Ryssbowh\Gtag\Models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public $measurementId = [];
    public $onlyProduction = [];
    public $cookieFlags = [];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['measurementId', 'each', 'rule' => ['string']],
            ['onlyProduction', 'each', 'rule' => ['boolean']],
            ['cookieFlags', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * Measurement ID getter
     * 
     * @param  Site $site
     * @return ?string
     */
    public function getMeasurementId($site)
    {
        if (!$site) {
            return null;
        }
        if (isset($this->measurementId[$site->uid])) {
            return \Craft::parseEnv($this->measurementId[$site->uid]);
        }
        return null;
    }

    /**
     * Only production getter
     * 
     * @param  Site $site
     * @return bool
     */
    public function getOnlyProduction($site)
    {
        if (!$site) {
            return true;
        }
        if (isset($this->onlyProduction[$site->uid])) {
            return $this->onlyProduction[$site->uid];
        }
        return true;
    }

    public function getCookieFlags($site)
    {
        if (!$site) {
            return null;
        }
        if (isset($this->cookieFlags[$site->uid])) {
            return $this->cookieFlags[$site->uid];
        }
        return 'SameSite=Lax;Secure';
    }
}
