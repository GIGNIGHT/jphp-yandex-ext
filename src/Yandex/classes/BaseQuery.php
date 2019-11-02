<?php
namespace Yandex\classes;

use httpclient;
use Yandex\Yandex;


/**
 * Abstract Class BaseQuery
 * 
 * @author GIGNIGHT
 * @link gignight.ru / vk.com/gignight1337
 */
class BaseQuery
{

     /**
      * @var HttpClient
      */
     protected $hClient;
    
     /**
      * init
      */
     function __construct()
     {
         $this->hClient = new HttpClient();
     }

     /**
      * @param string $url
      */
     public function setUrl($url)
     {
         if (!$this->hClient instanceof HttpClient)
             $this->hClient = new HttpClient();
             
         $this->hClient->responseType = 'JSON';
         $this->hClient->connectTimeout = 15000;
         $this->hClient->baseUrl = $url;
     }
     
     /**
      * @param string $method
      * @param array $data
      * 
      * @return HttpResponse
     */
     public function query($method, $data)
     {
         return $this->hClient->get($method, $data);
     }
}