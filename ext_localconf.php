<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!defined('TYPO3_MODE')) {
  die ('Access denied.');
}

$settings = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class)->get('mailjet');
if ($settings['Send'] == 1 && $settings['sync_field'] === 'on') {

  $host = "in-v3.mailjet.com";
  $smtpPort = 587;
  $smtpSecure = 'tls';
  if (!empty($settings_keys['smtp_host'])) {
    $host = $settings_keys['smtp_host'];
  }
  if (!empty($settings_keys['smtp_secure'])) {
    $smtpSecure = $settings_keys['smtp_secure'];
  }
  if (!empty($settings_keys['smtp_port'])) {
    $smtpPort = $settings_keys['smtp_port'];
  }

  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = $host . ':' . $smtpPort;
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_port'] = $smtpPort;
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = $smtpSecure; // ssl, sslv3, tls
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = $settings['apiKeyMailjet'];
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = $settings['secretKey'];

}
else {
  $GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'mail';
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
  'Mailjet',
  'Registration',
  [
    \Api\Mailjet\Controller\FormController::class => 'index,response,ajaxResponse',
  ],
  [
    \Api\Mailjet\Controller\FormController::class => 'index,response,ajaxResponse',
  ]
);


if (TYPO3_MODE === 'BE') {
    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
      'ext-mailjet-wizard-icon',
      \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
      ['source' => 'EXT:mailjet/ext_icon.png']
    );


  // Page module hook
  $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['list_type_Info']['mailjet' . '_registration']['mailjet'] =
    'Api\Mailjet\Hooks\Backend\PageLayoutViewHook->getExtensionSummary';


}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:mailjet/Configuration/TSconfig/ContentElementWizard.txt">');
