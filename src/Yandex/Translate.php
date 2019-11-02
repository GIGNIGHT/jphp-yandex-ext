<?php

namespace Yandex;

use Yandex\classes\Yandex;
use Yandex\classes\BaseQuery;
use Yandex\Exception\TranslateException;


/**
 * Class Translate
 * 
 * @author GIGNIGHT
 * @link gignight.ru / vk.com/gignight1337
 */
class Translate extends BaseQuery
{

    /**
     * @var string
     */
    public $key;
    
    /**
     * @param string $key
     */
    function __construct($key)
    {
        $this->setUrl(Yandex::TRANSLATE_URL);
        $this->key = $key;
    }
    
    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
    
    /**
     * @param string $text
     * 
     * Определение языка
     */
     public function detect($text)
     {
        $detect = $this->query('detect', ['key' => $this->key, 'text' => $text]);

        if ($detect->isSuccess())
        {
            return $detect->body()['lang'];
        }
        
        throw new TranslateException($detect->body()['code']);
     }
    
    /**
     * Перевод текста
     * $lang — Язык перевода
     * $sourceLang — Язык исходного текста (по умолчанию автоопределение)
     * 
     * @param string $lang
     * @param string $sourceLang
     * @param string $text
     * 
     * @throws LanguageException
     * 
     * @return array
     */
     public function translate($text, $lang = 'ru', $sourceLang = null)
     {   
        $sourceLang = ($sourceLang != null) ? $sourceLang : $this->detect($text);
        $params = ['key' => $this->key, 'text' => $text, 'lang' => $sourceLang.'-'.$lang];
        $translate = $this->query('translate', $params);
        $res = [];
        
        if ($translate->isSuccess())
        {
            $res['source_lang'] = $sourceLang;
            $res['target_lang'] = $lang;
            $res['text'] = $translate->body()['text'][0];
            
            return $res;
        }

        throw new TranslateException($translate->body()['code']);
     }
     
    /**
     * Получение списка поддерживаемых языков
     * 
     * @param string $language
     * 
     * @return array
     */
     public function getLangs($language = 'ru')
     {
        $langs = $this->query('getLangs', ['key' => $this->key, 'ui' => $language]);
        
        if ($langs->body()['code'] === null)
        {
            return $langs->body()['langs'];
        }

        throw new TranslateException($langs->body()['code']);
     }
}