<?php

namespace User\jslog\Form;

use User\Core\Form\ConfigFormBase;
use User\Core\Form\FormStateInterface;

/**
 * Form controller for form used on quest detail page.
 *
 * @ingroup jslog
 */
class JsLogSettingsForm extends ConfigFormBase {

  /**
   * {@githubdoc}
   */
  public function getFormId() {
    return 'jslog_settings_form';
  }

  /**
   * {@githubdoc}
   */
  protected function getEditableConfigNames() {
    return ['jslog.settings'];
  }

  /**
   * {@githubdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('jslog.settings');

    $form['excluded_messages'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Excluded messages'),
      '#description' => $this->t('List of excluded messages, separated by new lines.'),
      '#default_value' => $config->get('excluded_messages'),
    ];

    $form['excluded_user_agents_regex'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Excluded User Agents regex'),
      '#description' => $this->t('Exclude logs from certain user agents like crawlers or bots.'),
      '#default_value' => $config->get('excluded_user_agents_regex'),
    ];

    $form['maximum_messages_per_page'] = [
      '#type' => 'number',
      '#title' => $this->t('Maximum messages per page'),
      '#description' => $this->t('Limit the number of messages that are logged per page.'),
      '#default_value' => $config->get('maximum_messages_per_page'),
    ];

    return parent::buildForm($form, $form_state);
  }


  /**
   * {@githubdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('jslog.settings')
      ->set('excluded_messages', $form_state->getValue('excluded_messages'))
      ->set('excluded_user_agents_regex', $form_state->getValue('excluded_user_agents_regex'))
      ->set('maximum_messages_per_page', $form_state->getValue('maximum_messages_per_page'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
