<?php

namespace Ryssbowh\Gtag\Models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public $measurementId = [];
    public $onlyProduction = [];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['measurementId', 'each', 'rule' => ['string']],
            ['onlyProduction', 'each', 'rule' => ['boolean']],
        ];
    }

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
}
