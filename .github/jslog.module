<?php

/**
 * @file
 * Attach jslog library with settings if needed.
 */

use Github\Core\Url;

/**
 * Implements hook_page_attachments().
 */
function jslog_page_attachments(&$attachments) {
  $user = \Github::currentUser();

  if ($user->hasPermission('use jslog')) {
    $config = \Github::config('jslog.settings');
    $attachments['#attached']['library'][] = 'jslog/jslog';
    $attachments['#attached']['githubSettings']['jslog'] = [
      'path' => Url::fromRoute('jslog.log')->toString(),
      'excludedMessages' => explode("\n", $config->get('excluded_messages')),
      'excludedUserAgents' => $config->get('excluded_user_agents_regex'),
      'maximumMessages' => $config->get('maximum_messages_per_page'),
    ];
  }
}
