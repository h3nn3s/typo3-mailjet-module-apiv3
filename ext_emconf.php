<?php

$EM_CONF[$_EXTKEY] = [
  'title' => 'Mailjet Email Marketing',
  'description' => "Use Mailjet's SMTP to send Typo3 transactional emails. Add newsletter subscribers from Typo3 to your Mailjet contact lists.",
  'category' => 'plugin',
  'author' => 'Mailjet',
  'author_email' => 'plugins@mailjet.com',
  'state' => 'stable',
  'version' => '2.0.0',
  'constraints' => [
    'depends' => [
      'typo3' => '10.4.0-11.5.99',
    ],
    'conflicts' => [],
    'suggests' => [
      'typoscript_rendering' => '2.4.0-2.99.999',
    ],
  ],
];
