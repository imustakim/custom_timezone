<?php

namespace Drupal\custom_timezone;

use Drupal\Core\Config\ConfigFactoryInterface;

class LoadTimeDate
{
  
    /**
     * The config factory object.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * Constructs a LoadTimeDate object.
     *
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     *   A configuration factory instance.
     */ 
    public function __construct(ConfigFactoryInterface $config_factory)
    {
        $this->configFactory = $config_factory;
    }

    public function dateTime()
    {
        $result = [];
        $city = $this->configFactory->getEditable('timezone.settings')->get('city');
        $country = $this->configFactory->getEditable('timezone.settings')->get('country');
        $timezone = $this->configFactory->getEditable('timezone.settings')->get('timezone');
        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
            $time = date('jS M o - h:i A');
        }
        $result['city'] = $city;
        $result['country'] = $country;
        $result['timezone'] = $timezone;
        $result['time'] = $time;
        
        return $result;
    }
}