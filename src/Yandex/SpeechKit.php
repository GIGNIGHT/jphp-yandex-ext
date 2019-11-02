<?php
namespace Yandex;

use Yandex\classes\Yandex;
use script\MediaPlayerScript;

/**
 * Class Yandex SpeechKit Cloud
 * 
 * @author GIGNIGHT
 * @link gignight.ru / vk.com/gignight1337
 */
class SpeechKit extends BaseQuery
{
    
    /**
     * @var string
     */
    public $key = '';
    
    /**
     * Голос синтезированной речи
     * jane | oksana | alyss | omazh | zahar | ermil
     * 
     * @var string
     */
    public $speaker = 'zahar';
    
    /**
     * Расширение синтезируемого файла
     * mp3 | wav | opus
     * 
     * @var string
     */
    public $format = 'mp3';
    
    /**
     * Язык текста
     * ru-RU | en-US | uk-UK | tr-TR
     * 
     * @var string
     */
    public $language = 'ru-RU';
    
    /**
     * Скорость воспроизведения
     * Max — 3.0
     * Min — 0.1
     * Normal — 1.0
     * 
     * @var double
     */
    public $speed = 1.0;
    
    /**
     * Эмоциональная окраска голоса
     * good — радостный
     * evil — раздраженный
     * neutral — нейтральный
     * 
     * @var string
     */
    public $emotion = 'good';
    
    /**
     * Частота дискретизации и битрейт синтезируемого PCM-аудио
     * hi — частота дискретизации 48 кГц и битрейт 768 кб/c
     * lo — частота дискретизации 8 кГц и битрейт 128 кб/c
     * 
     * @var string
     */
    public $quality = null;
    
    /**
     * Автоопределение языка
     *
     * @var bool
     */
    public $autoDetect = true;
    
    /**
     * @var MediaPlayerScript
     */
    protected $media;
    
    public function __construct($key)
    {
        $this->api->setUrl(Yandex::SPEECHKIT_URL);
        $this->key = $key;
        $this->media = new MediaPlayerScript();
    }
    
    /**
     * Воспроизвести
     * 
     * @param string $text
     */
    public function speak($text)
    {
        $params = 
        [
            'key' => $this->key, 'text' => urlencode($text),
            'format' => $this->format, 'quality' => $this->quality,
            'lang' => $this->language, 'speaker' => $this->speaker,
            'speed' => $this->speed, 'emotion' => $this->emotion
        ];
        $speak = $this->api->query('generate', $params)->body();

        /*if ($this->autoDetect)
        {
            $detect = new Translate()->detect($text);
            $this->language = $detect . '-' . strtoupper($detect);
        }*/
        
        $file = sprintf("%s\\%s.%s", $_ENV['TEMP'], md5('yandex_speech'), $this->format);
        file_put_contents($file, $speak);
        $this->media->open($file); $this->media->play();
    }
}