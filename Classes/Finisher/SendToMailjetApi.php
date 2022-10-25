<?php

namespace Api\Mailjet\Finisher;

use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Domain\Service\ConfigurationService;
use In2code\Powermail\Finisher\AbstractFinisher;
use In2code\Powermail\Utility\ObjectUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

class SendToMailjetApi extends AbstractFinisher
{
    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var array
     */
    protected $powermailConfiguration;

    /**
     * @var array
     */
    protected $mailjetSettings;

    /**
     * MyFinisher
     *
     * @return void
     */
    public function mailjetSubscriptionFinisher(): void
    {
        // get relevant information from defined variables
        $e_mail = $this->getMail()->getAnswersByFieldMarker()['e_mail'] ? $this->getMail()->getAnswersByFieldMarker()['e_mail']->getValue() : '';
        $anrede = $this->getMail()->getAnswersByFieldMarker()['anrede'] ? $this->getMail()->getAnswersByFieldMarker()['anrede']->getValue() : '';
        $vorname = $this->getMail()->getAnswersByFieldMarker()['vorname'] ? $this->getMail()->getAnswersByFieldMarker()['vorname']->getValue() : '';
        $nachname = $this->getMail()->getAnswersByFieldMarker()['nachname'] ? $this->getMail()->getAnswersByFieldMarker()['nachname']->getValue() : '';
        $params = [
            'Email' => $e_mail,
            "Action" => "addnoforce",
            #"Name" => $e_mail,
            "Properties" => [
                "anrede" => $anrede,
                "vorname" => $vorname,
                "nachname" => $nachname
            ]
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->powermailConfiguration['targetUrl']);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        #curl_setopt($curl, CURLOPT_HEADER, 1);
        if (!empty($this->mailjetSettings['apiKeyMailjet']) && !empty($this->mailjetSettings['secretKey'])) {
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_USERPWD, $this->mailjetSettings['apiKeyMailjet'] . ':' . $this->mailjetSettings['secretKey']);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_exec($curl);
        $result = curl_exec($curl);
        curl_close($curl);
    }

    /**
     * @return void
     * @throws Exception
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    public function initializeFinisher(): void
    {
        $configurationService = ObjectUtility::getObjectManager()->get(ConfigurationService::class);
        $configuration = $configurationService->getTypoScriptConfiguration();
        $this->powermailConfiguration = $configuration['finishers.']['11.']['config.'];

        $this->mailjetSettings = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('mailjet');
    }
}