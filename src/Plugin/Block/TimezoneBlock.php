<?php
/**
 * @file
 * Contains Drupal\custom_timezone\Plugin\Block\TimezoneBlock
 */

namespace Drupal\custom_timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_timezone\LoadTimeDate;

/**
 * Block to show Date and Time according to timezone.
 *
 * @Block(
 *   id = "timezone_block",
 *   admin_label = @Translation("Timezone Block"),
 * )
 */

class TimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * @var $time_provider \Drupal\custom_timezone\Services\LoadTimeDate
     */

    protected $timeDate;
    
    /**
     * @param array                                        $configuration
     * @param string                                       $plugin_id
     * @param mixed                                        $plugin_definition
     * @param \Drupal\custom_timezone\Service\LoadTimeDate $time_date
     */
    public function __construct(array $configuration, $plugin_id, $plugin_definition, LoadTimeDate $time_date)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->timeDate = $time_date;
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array                                                     $configuration
     * @param string                                                    $plugin_id
     * @param mixed                                                     $plugin_definition
     *
     * @return static
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('custom_timezone.timezone_handler')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $result = $this->timeDate->dateTime();
        $build = [];
        $build['#theme'] = 'timezone_block';
        $build['#markup'] = 'Country: ' . $result['country'] . '<br>' . 'City: ' . $result['city'] . '<br>' . 'Timezone: ' . $result['timezone'] . '<br>' . 'Time: ' . $result['time'];
        $build['#cache'] = [
            'tags' => ['config:timezone.settings'], //invalidate when any node updates
          ];
        return $build;
    }
    
    /**
     * @return int
     */
    public function getCacheMaxAge() 
    {
        return 0;
    }
}