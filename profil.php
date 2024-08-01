<?php
// session_start();
require_once('src/php/libs/auth_check.php');
require_once('src/php/templates/header.php');
//initailisation du tableau de messsage
$userInfos = getUserInformationFromSession();
$userInfosTitles = [
    'Prénom', 'Nom', 'Email'
];

// Récupération des favoris de l'utilisateur
$favorites = [];
$userId = $_SESSION['id'];
$favorites = getUserFavorites($userId);

// Récupérer les détails des cryptomonnaies favorites
$UserCryptoFavorites = [];
foreach ($favorites as $cryptoId) {
    $crypto = getCryptoById($cryptoId);
    if ($crypto !== false) {
        $UserCryptoFavorites[] = $crypto;
    }
}

$mapProfilhistoricalData = [];

echo '</pre>';
// print_r($favorites);
// print_r($UserCryptoFavorites);
echo '</pre>';
?>
<div class="profil">
    <div class="profil-userInfos">
        <!-- ----------- Photo profil -------------------->
        <div class="photo">
            <img src="<?= $userInfos['default_picture'] . '?' . time(); ?>" alt="photo-profil" id="profilPicture" data-bs-toggle="tooltip" title="Cliquez pour changer votre photo de profil">
            <!-- Modal upload photo-->
            <?php require_once('src/php/templates/modal_uploadPhoto.php') ?>
        </div>
        <!--  Collapse informations personnelles --->
        <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTableFields" aria-expanded="false" aria-controls="collapseTableFields">
            Gérer mon compte
        </button>
        <?php require_once('src/php/templates/collapseTableFields.php') ?>
    </div>
    <div class="profil-userFavorites">
        <?php if (empty($UserCryptoFavorites)) : ?>
            <p class="text-center">Vous n'avez pas encore ajouté de cryptomonnaies en favoris.</p>
        <?php else : ?>
            <div class="crypto-lists-profil">
                <h1 >Mes favoris</h1>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Monnaie</th>
                            <th scope="col">Cours</th>
                            <th scope="col">24h</th>
                            <th scope="col" class="text-center">Evolution des prix sur 24h</th>
                            <?php if (is_logged_session()) : ?>
                                <th scope="col">Favoris</th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($UserCryptoFavorites as $crypto) : ?>
                            <?php
                            $cryptoId = htmlspecialchars($crypto['id']);
                            $rank = htmlspecialchars($crypto['rankCrypto']);
                            $name = htmlspecialchars($crypto['name']);
                            $symbol = htmlspecialchars(strtoupper($crypto['symbol']));
                            $imageUrl = htmlspecialchars($crypto['image']);
                            $price = htmlspecialchars($crypto['price']);
                            $evol24 = htmlspecialchars($crypto['evolution']);
                            $evol = $evol24 > 0 ? "+" . $evol24 : $evol24;
                            $profilhistoricalData = json_decode($crypto['historical_data'], true); // Décodage des données historiques
                            $mapProfilhistoricalData[] = $profilhistoricalData;
                            $isFavorite = in_array($cryptoId, $favorites) ? 'active' : '';

                            ?>
                            <tr>
                                <td class="crypto-rank"><?= $rank; ?></td>
                                <td>
                                    <a href="crypto.php?id=<?= urlencode($name) ?>">
                                        <div class="crypto-info">
                                            <img src="<?= $imageUrl; ?>" alt="Logo <?= $name; ?>" class="crypto-logo">
                                            <span class="crypto-name"><?= $name ?></span>
                                            <span class="crypto-symbol">(<?= $symbol; ?>)</span>
                                        </div>
                                    </a>
                                </td>
                                <td class="crypto-price"><?= number_format($price, 2, '.', ' '); ?> €</td>
                                <td class="crypto-evol <?= (floatval($evol24) > 0) ? 'positive' : 'negative'; ?>">
                                    <?= $evol ?> %
                                </td>
                                <td class="crypto-graph">
                                    <div class="content-graph">
                                        <canvas id="chart-<?= strtolower($name); ?>" data-historical='<?= json_encode($profilhistoricalData); ?>'></canvas>
                                    </div>
                                </td>

                                <?php if (is_logged_session()) : ?>
                                    <td>
                                        <button type="button" class="btn btn-favorite <?= $isFavorite; ?>" data-crypto-id="<?= $cryptoId; ?>">
                                            <i class="bi bi-star-fill" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif ?>

    </div>
    <script>
        const profilhistoricalData = <?= json_encode($mapProfilhistoricalData); ?>;

        console.log('log from PHP : ', profilhistoricalData);
    </script>
</div>

<?php
require_once(TEMPLATE_PATH . 'footer.php');

?>