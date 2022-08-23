<?php

namespace Api\Mailjet\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SimplifyLabelViewHelper extends AbstractViewHelper {

  public function render()
  {
      $label = $this->arguments['label'];
      $toLowerCase = $this->arguments['toLowerCase'];
      $label = $label ? $label : $this->renderChildren();
      $label = str_replace(['Ö', 'Ü', 'Ä', 'ö', 'ü', 'ä', 'ß'], [
        'Oe',
        'Ue',
        'Ae',
        'oe',
        'ue',
        'ae',
        'ss',
      ], $label);
      $filter = preg_replace('/[^a-zA-Z0-9]/', '', $label);
      if ($toLowerCase) {
        $filter = strtolower($filter);
      }
      return $filter;
  }

  public function initializeArguments(): void
  {
      $this->registerArgument('label', 'mixed', '', false, '');
      $this->registerArgument('toLowerCase', 'mixed', '', false, false);
  }
}