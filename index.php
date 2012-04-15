<?php
    /**
     *  ルビ振り君(β)
     *      - Version 1.1
     *      - Published at http://rskull.com/ruby/home/
     *
     *  Copyright © 2012 R.SkuLL
    **/
    header("Content-Type: text/javascript; charset=utf-8");
    header("Access-Control-Allow-Origin: *");
    
    //Yahoo ルビ振りAPI
    define('API', 'http://jlp.yahooapis.jp/FuriganaService/V1/furigana?');
    $api = array(
        'appid'     => 'YAHOO_APP_ID',
        'grade'     => 1,
        'sentence'  => $word = urlencode($_GET['word'])
    );
    
    if (!empty($word)) {
    
        foreach ($api as $key=>$val) {
            $prams[] = $key.'='.$val;
        }
        
        //リクエストURI
        $request = API.join('&', $prams);
        $xml = simplexml_load_file($request);
        
        //リスト抽出
        $check = array();
        foreach ($xml->Result->WordList->Word as $word) {
            if (array_key_exists('Furigana', $word)) {
                $surface = (string) $word->Surface;
                if (!in_array($surface, $check)) {
                    $check[] = $surface;
                    $list[] = array(
                        'Surface'   => $surface,
                        'Furigana'  => (string) $word->Furigana
                    );
                }
            }
        }
        echo json_encode($list);
    }
