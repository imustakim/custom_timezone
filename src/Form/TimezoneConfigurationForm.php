<?php
/**
 * @file
 * Contains Drupal\custom_timezone\Form\TimezoneConfigurationForm
 */

namespace Drupal\custom_timezone\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form to add country, city and timezone.
 */
class TimezoneConfigurationForm extends ConfigFormBase
{

    /** 
     * Config settings.
     *
     * @var string
     */

    const SETTINGS = 'timezone.settings';

    /** 
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'timezone_admin_settings';
    }

    /** 
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
        static::SETTINGS,
        ];
    }

    /** 
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config(static::SETTINGS);

        $form['country'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Country'),
            '#default_value' => $config->get('country'),
        ];

        $form['city'] = [
            '#type' => 'textfield',
            '#title' => $this->t('City'),
            '#default_value' => $config->get('city'),
        ];
        
        $form['timezone'] = [
            '#type' => 'select',
            '#title' => $this->t('Select timezone'),
            '#default_value' => $config->get('timezone'),
            '#options' => [
              'America/Chicago' => $this->t('America/Chicago'),
              'America/New_York' => $this->t('America/New York'),
              'Asia/Tokyo' => $this->t('Asia/Tokyo'),
              'Asia/Dubai' => $this->t('Asia/Dubai'),
              'Asia/Kolkata' => $this->t('Asia/Kolkata'),
              'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
              'Europe/Oslo' => $this->t('Europe/Oslo'),
              'Europe/London' => $this->t('Europe/London'),
            ],
          ];

        return parent::buildForm($form, $form_state);
    }

    /** 
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) 
    {
        // Retrieve the configuration.
        $this->configFactory->getEditable(static::SETTINGS)
            ->set('country', $form_state->getValue('country'))
            ->set('city', $form_state->getValue('city'))
            ->set('timezone', $form_state->getValue('timezone'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}