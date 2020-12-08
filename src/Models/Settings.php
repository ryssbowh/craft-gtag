<?php

namespace Ryssbowh\Gtag\Models;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public $measurementId = '';
    public $onlyProduction = true;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['measurementId', 'string'],
            ['onlyProduction', 'boolean']
        ];
    }
}
