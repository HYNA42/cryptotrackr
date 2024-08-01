<?php
require_once('required_files.php');
fetchAndInsertCryptoData();

function fetchAndInsertCryptoData()
{
    //API données de la crypto : rank, name, symbol, price$ , evolution24h

    $urlCoinCap = "https://api.coincap.io/v2/assets?limit=10&offset=20";
    $dataApiCoinCap = fetchApiCC($urlCoinCap);

    // API Taux de change USD/EUR (price / tauxdechange)
    $urlCoinCapExchangeRate = "https://api.coincap.io/v2/rates/euro";
    $dataApiExchangeRate = fetchApiCC($urlCoinCapExchangeRate);
    $usdToEuro = $dataApiExchangeRate['data']['rateUsd'];




    /**url img */
    // API Url de l'image de la crypto : image
    function getCryptoIconUrl($cryptoSymbol)
    {
        $MyCryptoCompareApiKey = '1bd5b4245f1801e40d668c51731aaf229db4bfcd4918c3e5fc406851a67778d5';
        $url_image = "https://data-api.cryptocompare.com/asset/v1/data/by/symbol?asset_symbol=$cryptoSymbol&api_key=$MyCryptoCompareApiKey";
        $response = fetchApiCC($url_image);
        if (isset($response['Data']['LOGO_URL'])) {
            return  $response['Data']['LOGO_URL'];
        }
        return 'https://resources.cryptocompare.com/asset-management/1/1659708726266.png'; // URL par défaut pour Bitcoin
    }

    // Tableau pour stocker les URLs des icônes de chaque crypto
    $UrlsLogoCrypto = [];

    // Parcourir les données des crypto-monnaies et récupérer les URLs d'icônes
    foreach ($dataApiCoinCap['data'] as $crypto) {
        $symbol = strtoupper($crypto['symbol']);
        $UrlsLogoCrypto[$symbol] = getCryptoIconUrl($symbol);
    }


    /**données historiques 24h : historical_data*/
    // API données historiques 24h de la crypto : historical_data
    $historicalData = [];
    foreach ($dataApiCoinCap['data'] as $crypto) {
        $cryptoId = strtolower($crypto['id']);
        $urlHistorical = "https://api.coincap.io/v2/assets/$cryptoId/history?interval=h1&start=" . (time() - 86400) * 1000 . "&end=" . time() * 1000;
        $dataApiCryptoHistorical = fetchApiCC($urlHistorical);

        $cryptoHistoricalElement = $dataApiCryptoHistorical['data'];
        $historicalData[$cryptoId] = array_map(function ($entry) {
            return [
                'time' => $entry['time'],
                'priceUsd' => $entry['priceUsd']
            ];
        }, $cryptoHistoricalElement);
    }



    foreach ($dataApiCoinCap['data'] as $crypto) {
        $cryptoId = strtolower($crypto['id']);
        $rank = $crypto['rank'];
        $symbol = $crypto['symbol'];
        $name = $crypto['name'];
        $price = $crypto['priceUsd'];
        $evolution = $crypto['changePercent24Hr'];
        $urlImage = $UrlsLogoCrypto[strtoupper($crypto['symbol'])];
        // $urlImage = "testUrl";
        // $historical_data = json_encode([
        //     ['testTime' => 1625097600000, 'TestPriceUsd' => 29000],
        //     ['testTime' => 1625184000000, 'TestPriceUsd' => 29500],
        //     ['testTime' => 1625270400000, 'TestPriceUsd' => 30000]
        // ]);
        $historical_data = json_encode($historicalData[$cryptoId]);

        // Préparation de la requête SQL d'insertion ou de mise à jour
        $req = 'INSERT INTO cryptocurrency(id, rankCrypto, image, name, symbol, price, evolution, historical_data)
                VALUES(UUID(), :rankCrypto, :image, :name, :symbol, :price, :evolution, :historical_data)
                ON DUPLICATE KEY UPDATE 
                    rankCrypto = VALUES(rankCrypto), 
                    image = VALUES(image), 
                    symbol = VALUES(symbol), 
                    price = VALUES(price), 
                    evolution = VALUES(evolution), 
                    historical_data = VALUES(historical_data)';

        // Tableau associatif des paramètres
        $params = [
            ':rankCrypto' => $rank,
            ':image' => $urlImage,
            ':name' => $name,
            ':symbol' => $symbol,
            ':price' => $price,
            ':evolution' => $evolution,
            ':historical_data' => $historical_data
        ];

        // Exécution de la requête SQL
        Database::getInstance()->request($req, $params);
    }
}

