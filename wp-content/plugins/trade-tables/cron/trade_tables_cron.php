<?php

class TradeTables {
    private int $STD = 3;
    private int $ECN = 5;
    private int $PRO = 8;
    private int $forex = 1;
    private int $metals = 2;
    private int $oils = 3;
    private int $indices = 4;
    private int $cryptos = 5;

    public function __construct()
    {
        $this->saveJsonFiles($this->forex, 'forex');
        $this->saveJsonFiles($this->metals, 'metals');
        $this->saveJsonFiles($this->oils, 'oils');
        $this->saveJsonFiles($this->indices, 'indices');
        $this->saveJsonFiles($this->cryptos, 'cryptos');
    }

    private function fetch_data($account, $market)
    {
        $url = "https://api.ecmarkets.co/api/home/quote/$account/$market/home?pageNum=1&pageSize=50";

        // Initialize cURL session
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (empty($response)) {
            $path = dirname(__DIR__,3). '\debug.log';
            error_log("Market: $market and Account: $account in Trade tables plugin: API response is empty\n", 3, $path);
            curl_close($ch);
            exit;
        }

        // Close cURL session
        curl_close($ch);

        return json_decode($response, true);
    }

    private function saveJsonFiles($market, $filename)
    {
        $std = $this->fetch_data($this->STD, $market);
        $ecn = $this->fetch_data($this->ECN, $market);
        $pro = $this->fetch_data($this->PRO, $market);

        $dataArr['std'] = $std['body']['list'];
        $dataArr['ecn'] = $ecn['body']['list'];
        $dataArr['pro'] = $pro['body']['list'];

        $plugin_dir = dirname(__DIR__,1);
        file_put_contents($plugin_dir.'/json/'.$filename.'.json', json_encode($dataArr));
    }
}

new TradeTables();

