<?php
namespace app\classes;
use JsonMachine\Items;
use JsonMachine\JsonDecoder\DecodingError;
use JsonMachine\JsonDecoder\ErrorWrappingDecoder;
use JsonMachine\JsonDecoder\ExtJsonDecoder;
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

class FixJson{
        
    public static function fix($json){

    $data = [];   
    $items = Items::fromString($json, ['decoder' => new ErrorWrappingDecoder(new ExtJsonDecoder())]);
        foreach ($items as $key => $item) {
            if ($key instanceof DecodingError || $item instanceof DecodingError) {
                // handle error of this malformed json item
                continue;
            }
            $data[$key] = $item;
        }
    return json_encode($data);

    }
}