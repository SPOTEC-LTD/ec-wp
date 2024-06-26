<?php

class LivePricesCron {
    private int $popular = -2;
    private int $forex = 1;
    private int $metals = 2;
    private int $energy = 3;
    private int $indices = 4;
    private int $cryptos = 5;

    public function __construct()
    {
        $this->fetch_data($this->popular, 'popular');
        $this->fetch_data($this->forex, 'forex');
        $this->fetch_data($this->metals, 'metals');
        $this->fetch_data($this->energy, 'energy');
        $this->fetch_data($this->indices, 'indices');
        $this->fetch_data($this->cryptos, 'cryptos');
    }

    private function fetch_data($market, $filename)
    {
        $url = "https://api.ecmarkets.co/api/home/quote/$market/quote";

        // Initialize cURL session
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (empty($response)) {
            $path = dirname(__DIR__,3). '\debug.log';
            error_log("Market: $market in Trade tables plugin: API response is empty\n", 3, $path);
            curl_close($ch);
            exit;
        }

        // Close cURL session
        curl_close($ch);

        $response = json_decode($response, true);

        $plugin_dir = dirname(__DIR__,1);
        file_put_contents($plugin_dir.'/json/'.$filename.'.json', json_encode($response['body']));
    }
}

new LivePricesCron();


