<?php

namespace Yandex\Exception;

/**
 * Class TranslateException
 * 
 * @author GIGNIGHT
 * @link gignight.ru / vk.com/gignight1337
 */
class TranslateException extends BaseException
{
    /**
     * @var array
     */
     private $errorMessage =
     [
        401 => 'Неправильный API-ключ',
        402 => 'API-ключ заблокирован',
        404 => 'Превышено суточное ограничение на объем переведенного текста',
        413 => 'Превышен максимально допустимый размер текста',
        422 => 'Текст не может быть переведен',
        501 => 'Указанное направление перевода не поддерживается'
    ];
    
    public function __construct($errorCode)
    {
        parent::__construct($this->errorMessage[$errorCode], $errorCode);
    }
}