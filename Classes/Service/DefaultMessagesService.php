<?php


namespace Api\Mailjet\Service;


use Api\Mailjet\Domain\Model\Dto\FormDto;

class DefaultMessagesService
{
    private $form;

    private $confMessage = 'Die Anmeldebestätigung wurde an %email gesendet. Bitte schauen Sie in Ihrem Postfach nach und bestätigen die Anmeldung.';

    private $subscribeError = 'Fehler! Bitte versuchen Sie es später erneut.';

    private static $memberExist = 'Die Adresse %email ist bereits registriert';

    private $thanksMessage = 'Vielen Dank für Ihre Anmeldung!';

    private $headingText = 'Bitte bestätigen Sie Ihre Anmeldung zu';

    private $emailFooterMsg = 'Haben Sie nicht darum gebeten, diese Liste zu abonnieren? Oder haben Sie Ihre Meinung geändert? Dann ignorieren Sie diese E-Mail einfach und Sie werden nicht abonniert.';

    private $confirmationBtnText = 'Hier klicken zum Bestätigen';

    private $bodyMessage = 'Bitte bestätigen Sie mit einem Klick:';

    private $owner = 'RhönSprudel';

    private static $successMessage = 'Sie haben sich erfolgreich angemeldet.';

    private static $dataTypeMessage = 'Please enter the correct values according to the example in the field: %id.';

    public function __construct(FormDto $formDto)
    {
        $this->form = $formDto;
    }

    public function getConfirmMessage()
    {
        $message = $this->confMessage;
        $email = $this->form->getEmail();

        if (!empty($this->form->getConfMessage())) {
            $message = $this->form->getConfMessage();
        }
        $message = str_replace('%email', $email, $message);

        return $message;
    }

    public function getMemberExist()
    {
        $message = self::$memberExist;
        $email = $this->form->getEmail();

        if (!empty($this->form->getMemberExist())) {
            $message = $this->form->getMemberExist();
        }
        $message = str_replace('%email', $email, $message);

        return $message;
    }

    public function getHeadingText()
    {
        if(!empty($this->form->getHeadingText())){
            return $this->form->getHeadingText();
        }

        return $this->headingText;
    }

    public function getSubscribeError()
    {
        if(!empty($this->form->getSubscribeError())){
            return $this->form->getSubscribeError();
        }

        return $this->subscribeError;
    }

    public function getThanksMessage()
    {
        if(!empty($this->form->getThanks())){
            return $this->form->getThanks();
        }

        return $this->thanksMessage;
    }

    public function getEmailFooterMessage()
    {
        if(!empty($this->form->getEmailFooterMail())){
            return $this->form->getEmailFooterMail();
        }

        return $this->emailFooterMsg;
    }

    public function getConfButtonText()
    {
        if(!empty($this->form->getConfButton())){
            return $this->form->getConfButton();
        }

        return $this->confirmationBtnText;
    }

    public function getBodyMessage()
    {
        if(!empty($this->form->getBodyText())){
            return $this->form->getBodyText();
        }

        return $this->bodyMessage;
    }

    public function getOwner()
    {
        if(!empty($this->form->getOwner())){
            return $this->form->getOwner();
        }

        return $this->owner;
    }

    public static function getSuccessMessage($message)
    {
        if (!empty($message)){
            return $message;
        }

        return self::$successMessage;
    }

    public static function getDataTypeMsg($message)
    {
        if (!empty($message)){
            return $message;
        }

        return self::$dataTypeMessage;
    }

    public static function getSubscribedMessage($email)
    {
        $message = self::$memberExist;

        return str_replace('%email', $email, $message);
    }
}
