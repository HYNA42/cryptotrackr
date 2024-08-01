<?php
session_start();
require_once('src/php/templates/header.php');
require_once('src/php/libs/api.php');
// require_once('src/php/libs/handle_crypto.php');


/** Récupérer toutes les cryptomonnaies de la base de données */
$sql = 'SELECT * FROM `Cryptocurrency`';
$cryptos = Database::getInstance()->request($sql)->fetchAll(PDO::FETCH_ASSOC);

// Compter le nombre total de cryptomonnaies
$total_cryptos = count($cryptos);

// Paramètres de Pagination
$per_page = 10; // Nombre de cryptomonnaies à afficher par page
$total_pages = ceil($total_cryptos / $per_page); // Nombre total de pages
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Numéro de la page actuelle
$page = max(1, min($page, $total_pages)); // S'assurer que la page est valide

// Obtenir les cryptomonnaies pour la page actuelle
$start = ($page - 1) * $per_page;
$current_page_cryptos = array_slice($cryptos, $start, $per_page);

/**Pagination */
$thead = ['rank' => '#', 'capit' => 'Monnaie', 'price' => 'Cours', 'evol24' => '24h', 'graph' => 'Evolution des prix sur 24h', 'favorite' => 'Favoris'];
/**Pagination */

/**Gestion des favoris */
// Récupération des favoris de l'utilisateur si connecté
$favorites = [];
if (is_logged_session()) {
  $userId = $_SESSION['id'];
  $favorites = getUserFavorites($userId);
  // echo $userId;
}
// echo '<pre>';
// print_r($favorites);
// echo '</pre>';
?>

<h1 class="title">Top <?= $total_cryptos; ?> des meilleures cryptos</h1>
<div class="crypto-lists-market">
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
        <!-- <th scope="col">Monnaie</th>
        <th scope="col">Cours</th>
        <th scope="col">24h</th>
        <th scope="col">Evolution 24h</th>
        <th scope="col">Favoris</th> -->
      </tr>
    </thead>
    <tbody>
      <?php foreach ($current_page_cryptos as $crypto) : ?>
        <?php
        $cryptoId = htmlspecialchars($crypto['id']);
        $rank = htmlspecialchars($crypto['rankCrypto']);
        $name = htmlspecialchars($crypto['name']);
        $symbol = htmlspecialchars(strtoupper($crypto['symbol']));
        $imageUrl = htmlspecialchars($crypto['image']);
        $price = htmlspecialchars($crypto['price']);
        $evol24 = htmlspecialchars($crypto['evolution']);
        $evol = $evol24 > 0 ? "+" . $evol24 : $evol24;
        $historicalData = json_decode($crypto['historical_data'], true); // Décodage des données historiques
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
              <canvas id="chart-<?= strtolower($name); ?>" data-historical='<?= json_encode($historicalData); ?>'></canvas>
            </div>
          </td>

          <?php if (is_logged_session()) : ?>
            <td>
              <button type="button" class="btn btn-favorite <?= $isFavorite; ?>" data-crypto-id="<?= $cryptoId; ?>">
                <i class="bi <?= $isFavorite ? 'bi-star-fill' : 'bi-star'; ?>" aria-hidden="true"></i>
              </button>
            </td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<!-- Pagination Links -->
<nav aria-label="Page navigation example" class="paginationList">
  <ul class="pagination justify-content-center">
    <?php if ($page > 1) : ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $page - 1; ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
      <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages) : ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $page + 1; ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>
<script>
  const historicalData = <?= json_encode($current_page_cryptos); ?>;

  console.log('log from PHP : ', historicalData); // Debugging log
</script>

<!-- <script src="<?= JS_URL ?>crypto.js" type="module" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script> -->

<?php require_once(TEMPLATE_PATH . 'footer.php'); ?>