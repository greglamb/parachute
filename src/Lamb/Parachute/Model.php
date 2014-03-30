<?php namespace Lamb\Parachute;

use LaravelBook\Ardent\Ardent;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory as ValidationFactory;

class Model extends Ardent {

  public static function setValidator(DB $db) {
    $translator = new Translator('en');
    $translator->addLoader('file_loader', new PhpFileLoader());
    $translator->addResource('file_loader',
        dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.'en'.
        DIRECTORY_SEPARATOR.'validation.php', 'en');

    self::$externalValidator = true;
    self::$validationFactory = new ValidationFactory($translator);
    self::$validationFactory->setPresenceVerifier(new DatabasePresenceVerifier($db->getDatabaseManager()));
  }

}
