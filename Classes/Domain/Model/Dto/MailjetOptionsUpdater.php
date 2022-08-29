<?php

namespace Api\Mailjet\Domain\Model\Dto;

use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MailjetOptionsUpdater {

  /** @var string */
  protected $config_options;

  /** @var string */
  protected $ext_key = 'mailjet';

  public function __construct() {
    $this->config_options = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get($this->ext_key);
  }

    /**
     * @param string $key Extension configuration key
     * @param string $value Value for configuration key
     * @return void
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     * @throws ExtensionConfigurationPathDoesNotExistException
     */
  public function saveConfiguration($key, $value): void
  {
    $this->config_options[$key] = $value;

    $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
    $newConfiguration = $extensionConfiguration->get($this->ext_key);
    ArrayUtility::mergeRecursiveWithOverrule($newConfiguration,  $this->config_options);
    $extensionConfiguration->set($this->ext_key, $newConfiguration);
  }

}