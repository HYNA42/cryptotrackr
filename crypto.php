<?php
session_start();
// Récupérer l'identifiant de la cryptomonnaie depuis l'URL
$cryptoName = isset($_GET['id']) ? $_GET['id'] : null;

if (!$cryptoName) {
    header('Location: market.php');
    exit;
}

require_once('src/php/libs/user_crypto.php');
// Interroger la base de données pour vérifier les détails de la crypto
$crypto = verifyCryptoInfos($cryptoName);
if (!$crypto) { // La crypto n'est pas trouvée
    header('Location: market.php');
    exit;
}
require_once('src/php/templates/header.php');
// Si la crypto est trouvée
$rank = htmlspecialchars($crypto['rankCrypto']);
$cryptoId = htmlspecialchars($crypto['id']);
$name = htmlspecialchars($crypto['name']);
$symbol = htmlspecialchars(strtoupper($crypto['symbol']));
$price = htmlspecialchars($crypto['price']);
$imageUrl = htmlspecialchars($crypto['image']);
$evol24 = htmlspecialchars($crypto['evolution']);
$cryptoHistoricalData = json_decode($crypto['historical_data'], true); // On décode les données historiques

$isFavorites = false;
if (is_logged_session()) {
    // Test@2024!
    $userId = $_SESSION['id'];
    $favorites = getUserFavorites($userId);
    $isFavorite = in_array($cryptoId, $favorites);
    //   echo $userId;
}

// Test@2024!

// echo '<pre>';
// print_r($isFavorite);
// echo '</pre>';
?>
<div>
    <div class="cryptoDetails">
        <div class="crypto">
            <div class="crypto-infos">
                <div class="crypto-infos-top ">
                    <img src="<?= $imageUrl; ?>" alt="Logo <?= $name ?>" class="crypto-logo">
                    <span class="crypto-name"><?= $name; ?></span>
                    <span class="crypto-symbol">Cours du <?= $symbol; ?></span>
                    <span class="crypto-rank">#<?= $rank; ?></span>
                    <span>
                        <?php if (is_logged_session()) : ?>
                            <button type="button" class="btn btn-favorite <?= $isFavorite ? 'active' : ''; ?>" data-crypto-id="<?= $cryptoId; ?>">
                                <i class="bi <?= $isFavorite ? 'bi-star-fill' : 'bi-star'; ?>" aria-hidden="true"></i>
                            </button>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="crypto-infos-bottom">
                    <span class="crypto-price"><?= $price; ?>€</span>
                    <span class="crypto-evol <?= (floatval($evol24) > 0) ? 'positive' : 'negative'; ?>"><?= floatval($evol24) > 0 ? "+" . $evol24 : $evol24 ?>%</span>
                </div>
            </div>
            <div class="crypto-infos-buttons">
                <button class="btn btn-primary mx-auto" data-bs-toggle="collapse" href="#graphicalViewCollapse" role="button" aria-expanded="false" aria-controls="graphicalViewCollapse">Graphique 24h <i class="bi bi-chevron-down"></i></button>
                <button class="btn btn-primary" data-bs-toggle="collapse" href="#tradingViewCollapse" role="button" aria-expanded="false" aria-controls="tradingViewCollapse">Trading View <i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        <div class="tradingView">
            <div class="collapse" id="graphicalViewCollapse">
                <div class="card card-body">
                    <canvas id="chart-24h"></canvas>
                </div>
            </div>
            <div class="collapse" id="tradingViewCollapse">
                <div class="card card-body">
                    <div id="tradingview-widget-container" style="height:600px"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const symbol = <?= json_encode(strtoupper($symbol)) ?>;
        const cryptoHistoricalData = <?= json_encode($cryptoHistoricalData) ?>;
        console.log(`PHP - historique 24h du ${symbol}`, cryptoHistoricalData);
    </script>
</div>

<!-- <script src="<?= JS_URL ?>crypto.js" type="module" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script> -->

<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>