import * as utils from "./utils.js";

document.addEventListener("DOMContentLoaded", function () {
  const pageClass = document.documentElement.className;
  console.log(pageClass);

  const chartLineColor = getComputedStyle(
    document.documentElement
  ).getPropertyValue("--chart-line-color");

  // Configuration des graphiques pour la page market.php
  if (typeof historicalData !== "undefined") {
    console.log("log from JS : ", historicalData); // Debugging log
    document.querySelectorAll("canvas[id^='chart-']").forEach((canvas) => {
      const historicalData = JSON.parse(canvas.dataset.historical);
      // console.log(historicalData)
      if (historicalData) {
        new Chart(canvas, {
          type: "line",
          data: {
            labels: historicalData.map((entry) => new Date(entry.time)),
            datasets: [
              {
                label: "Prix",
                data: historicalData.map((entry) => entry.priceUsd),
                borderColor: chartLineColor,
                borderWidth: 2,
                pointRadius: 0, // courbe plus lisse, pas de point
                fill: false,
              },
            ],
          },
          options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
              x: {
                type: "time",
                time: {
                  unit: "hour",
                },
                display: false, // Masquer l'axe x
              },
              y: {
                display: false, // Masquer l'axe y
              },
            },
            plugins: {
              legend: {
                display: false, // Masquer la légende
              },
            },
          },
        });
      }
    });
  }

  // Configuration des graphiques pour la page profil.php
  if (typeof profilhistoricalData !== "undefined") {
    console.log("log from JS : ", profilhistoricalData); // Debugging log
    document.querySelectorAll("canvas[id^='chart-']").forEach((canvas) => {
      const profilhistoricalData = JSON.parse(canvas.dataset.historical);
      // console.log(historicalData)
      if (profilhistoricalData) {
        new Chart(canvas, {
          type: "line",
          data: {
            labels: profilhistoricalData.map((entry) => new Date(entry.time)),
            datasets: [
              {
                label: "Prix",
                data: profilhistoricalData.map((entry) => entry.priceUsd),
                borderColor: chartLineColor,
                borderWidth: 2,
                pointRadius: 0, // courbe plus lisse, pas de point
                fill: false,
              },
            ],
          },
          options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
              x: {
                type: "time",
                time: {
                  unit: "hour",
                },
                display: false, // Masquer l'axe x
              },
              y: {
                display: false, // Masquer l'axe y
              },
            },
            plugins: {
              legend: {
                display: false, // Masquer la légende
              },
            },
          },
        });
      }
    });
  }

  // Configuration du graphique pour la page crypto.php
  if (typeof cryptoHistoricalData !== "undefined" && cryptoHistoricalData) {
    console.log("JS - historique 24h du", symbol, cryptoHistoricalData);
    const chartElement = document.getElementById("chart-24h");
    if (chartElement) {
      const ctx = chartElement.getContext("2d");
      new Chart(ctx, {
        type: "line",
        data: {
          labels: cryptoHistoricalData.map((entry) => new Date(entry.time)),
          datasets: [
            {
              label: "Prix",
              data: cryptoHistoricalData.map((entry) => entry.priceUsd),
              borderColor: chartLineColor,
              borderWidth: 2,
              pointRadius: 0, // courbe plus lisse, sans point
              fill: false,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {
              type: "time",
              time: {
                unit: "hour",
                displayFormats: {
                  hour: "HH:mm", //format 24h
                },
              },
              display: true,
            },
            y: {
              display: true,
              ticks: {
                callback: function (value) {
                  return value + " €"; // ajoute l'unité monétaire "€" à chaque étiquette
                },
              },
            },
          },
          plugins: {
            legend: {
              display: false,
            },
          },
        },
      });
    }
  }

  // Initialisation du widget TradingView
  if (typeof symbol !== "undefined") {
    console.log(symbol);
    new TradingView.widget({
      container_id: "tradingview-widget-container",
      autosize: true,
      symbol: `BINANCE:${symbol}EUR`,
      interval: "D",
      timezone: "Etc/UTC",
      theme: "light",
      style: "1",
      locale: "fr",
      toolbar_bg: "#f1f3f6",
      enable_publishing: false,
      withdateranges: true,
      hide_side_toolbar: false,
      allow_symbol_change: true,
      details: true,
      hotlist: true,
      calendar: true,
      // studies: ["BB", "MACD", "RSI"],
      studies: [],
    });
  }

  /******************** GESTION DES FAVORIS ***************/
  // Récupération des boutons de favoris
  const favoriteButtons = document.querySelectorAll(".btn-favorite");
  // Gestion du clic sur les boutons de favoris
  favoriteButtons.forEach((button) => {
    button.addEventListener("click", async () => {
      const cryptoId = button.dataset.cryptoId;
      console.log(cryptoId);
      const formData = new FormData();
      formData.append("cryptoId", cryptoId);
      const path = "src/php/libs/handler_favorite.php";
      const data = await handler_favorite(formData, path);
      const icon = button.querySelector("i");
      if (data.success) {
        //selectionner la ligne parent du bn favoris pour pouvoir la supprimer quand le favoris est retiré
        if (data.alert === "add") {
          button.classList.add("active");
          icon.classList.add("bi-star-fill");
          icon.classList.remove("bi-star");
        } else if (data.alert === "delete") {
          //if delate request => delete actual tr on  profil-page
          if (pageClass.includes("profil-page")) {
            const row = button.closest("tr");
            // console.log(row);
            row.remove();
          }
          button.classList.remove("active");
          icon.classList.add("bi-star");
          icon.classList.remove("bi-star-fill");
        }
      }
    });
  });

  // contacter l'API pour mettre a jour les favoris
  async function handler_favorite(formData, path) {
    try {
      const response = await utils.contactDatabase(formData, path);
      if (!response.success) {
        console.log(response);
      } else {
        console.log(response);
      }
      return response;
    } catch (error) {
      console.error(
        "Une erreur est survenue dans la tentative de connexion au serveur",
        error
      );
    }
  }
});
