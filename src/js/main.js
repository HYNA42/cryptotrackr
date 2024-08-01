import { adjustMainPadding as adjustMainPadding } from "./utils.js";
import * as utils from "./utils.js";

document.addEventListener("DOMContentLoaded", function () {
  adjustMainPadding();
  window.addEventListener("resize", adjustMainPadding);

  /*************** Deinition des variables ************ */

  const profilPicture = document.getElementById("profilPicture");

  const imagePreview = document.getElementById("imagePreview");
  const uploadPhotoForm = document.getElementById("uploadPhotoForm");
  const inputPhoto = document.getElementById("inputPhoto");

  const alertInputPhoto = document.getElementById("alertInputPhoto");
  ("alertLoginOffcanvas");

  /**************** TOOLTIPS sur la PHOTO ************** */
  const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');

  // Activer les tooltips pour chaque élément trouvé
  tooltips.forEach(function (tooltipEl) {
    new bootstrap.Tooltip(tooltipEl);
  });
  /********************* PHOTO ******************* */
  // const upload = document.getElementById("upload");
  if (profilPicture) {
    profilPicture.addEventListener("click", () => {
      console.log("Clic + PhotoProfil");
      const modalPicture = new bootstrap.Modal(
        document.getElementById("modalUploadPhoto")
      );
      modalPicture.show();
    });
  }
  // Sélection de l'input file et écoute de l'événement de changement

  if (inputPhoto) {
    inputPhoto.addEventListener("change", function () {
      const file = this.files[0]; // Récupère le premier fichier sélectionné

      if (file) {
        const reader = new FileReader(); // Crée un objet FileReader

        reader.onload = function (e) {
          // Lorsque le fichier est chargé, affiche l'aperçu de l'image
          const img = document.createElement("img");
          img.src = e.target.result;
          img.classList.add("img-fluid"); // Ajoutez des classes Bootstrap pour le style
          imagePreview.innerHTML = ""; // Efface tout contenu précédent
          imagePreview.appendChild(img);
        };

        reader.readAsDataURL(file); // Lit le fichier en tant que Data URL
      }
    });
  }

  if (uploadPhotoForm) {
    uploadPhotoForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      if (document.getElementById("inputPhoto").value.length) {
        console.log("NOT EMPTY");
        //prépere les données à envoyer au serveur
        const formData = new FormData(this);
        console.log(...formData.entries());
        const path = "src/php/libs/handler_uploadPhoto.php";

        await handler_uploadPhoto(formData, path);
      } else {
        console.log("EMPTY");
        alertInputPhoto.innerHTML = "";
        utils.alertMessage(
          "warning",
          "Vous devez selectionner une image",
          alertInputPhoto
        );
      }
    });
  }

  //upload photo profil
  async function handler_uploadPhoto(formData, path) {
    try {
      const data = await utils.contactDatabase(formData, path);
      if (!data.success) {
        //traitement en cas d'erreur--------
        alertInputPhoto.innerHTML = "";
        console.log("Error response", data);
        if (data.alert === "warning") {
          utils.alertMessage("warning", data.message, alertInputPhoto);
          // console.log("attention warning");
        } else if ((data.alert === "danger", alertInputPhoto)) {
          utils.alertMessage("danger", data.message, alertInputPhoto);
        }
      } else {
        console.log("Success response", data);
        //mettre à jour la nouvelle url de la photo de profil
        utils.updateProfilePicture(data.newProfilePictureUrl, profilPicture);
      }
    } catch (er) {
      console.error(
        "Une erreure est survenue dans la modification de la photo de profil",
        er
      );
    }
  }

  /********************** LOGIN ******************** */
  utils.addFormSubmitListener(
    "_loginUserHomeForm",
    "alerte_loginUserHome",
    "src/php/libs/handler_login.php",
    handler_login
  );

  utils.addFormSubmitListener(
    "_loginUserOffcanvasForm",
    "alerte_loginUserOffcanvas",
    "src/php/libs/handler_login.php",
    handler_login
  );

  async function handler_login(formData, path, alertContent) {
    try {
      const data = await utils.contactDatabase(formData, path);
      if (!data.success) {
        //traitement en cas d'erreur--------
        console.log("Error response", data);
        if (data.alerte) {
          if (alertContent) {
            alertContent.innerHTML = "";
            utils.alertMessage(data.alerte, data.message, alertContent);
          }
        }
      } else {
        //traitement en cas de succès--------
        console.log("Success response", data);
        if (data.redirect) {
          window.location.href = data.redirect;
        }
      }
    } catch (error) {
      console.error(
        "Une erreure est survenue dans la tentative de connexion au server",
        error
      );
    }
  }

  /********************** LOGOUT ******************** */
  const logoutBtn = document.getElementById("logoutBtn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", async function (e) {
      e.preventDefault();
      const path = "src/php/libs/handler_logout.php";
      await handler_logout(path);
      console.log("Logout ........");
    });
  }
  async function handler_logout(path) {
    try {
      const data = await utils.contactDatabase(null, path);
      if (!data.success) {
        console.log("Error response", data);
      } else {
        if (data.redirect) {
          window.location.href = data.redirect;
        }
        console.log("Success response", data);
      }
    } catch (error) {
      console.error(
        "Une erreure est survenue dans la tentative de connexion au server",
        error
      );
    }
  }

  /************** DELETE USER **************** */
  const deleteUserBtn = document.getElementById("deleteUserBtn");

  if (deleteUserBtn) {
    deleteUserBtn.addEventListener("click", async function (e) {
      e.preventDefault();
      //lancer la modal de confirmation
      const modalDeleteUser = new bootstrap.Modal(
        document.getElementById("modalDeleteUser")
      );
      modalDeleteUser.show();

      const confirmDeleteUserBtn = document.getElementById(
        "confirmDeleteUserBtn"
      );
      if (confirmDeleteUserBtn) {
        confirmDeleteUserBtn.addEventListener("click", async function (e) {
          console.log("Click DeleteBtn......");
          const path = "src/php/libs/handler_delete.php";
          await handler_deleteUser(path);
        });
      }
    });
  }

  async function handler_deleteUser(path) {
    try {
      const data = await utils.contactDatabase(null, path);
      if (!data.success) {
        console.log("Error response", data);
      } else {
        console.log("Success response", data);
        if (data.redirect) {
          // console.log(data.redirect);
          window.location.href = data.redirect;
        }
      }
    } catch (error) {
      console.error(
        "Une erreure est survenue dans la tentative de connexion au server",
        error
      );
    }
  }

  /************** SIGNUP **************** */
  const _signupForm = document.getElementById("_signupForm");
  const alerte_signup = document.getElementById("alerte_signup");
  if (_signupForm) {
    _signupForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(_signupForm);
      // console.log(...formData.entries());
      //on récupère la valeur associé à la clé password et on valide le mot de passe
      alerte_signup.innerHTML = "";
      const birthday = formData.get("birthday");
      const password = formData.get("password");
      const pseudo = formData.get("pseudo").trim();

      //on vérifie d'abord si le user est majeur
      if (utils.isAdult(birthday)) {
        //on valide le pseudo >= 4 char
        if (pseudo.length < 4) {
          utils.alertMessage(
            "danger",
            "Le nom d'utilisateur doit contenir au moins 4 caractères",
            alerte_signup
          );
        } else {
          //on valide le mot de passe
          if (!utils.checkPassword(password)) {
            console.log("mot de passe pas bon");
            utils.alertMessage(
              "danger",
              `<ul class="list-group">Le mot de passe doit contenir au mois 8 caractères : </ul> 
                <li>une majuscule</li>
                <li>une minuscule</li>
                <li>un chiffre</li>
                <li>un caractère spécial</li>
              </ul>`,
              alerte_signup
            );
          } else {
            console.log("mot de passe ok");
            // const path = "signup.php";
            const path = "src/php/libs/handler_signup.php";
            await handler_signup(formData, path);
          }
        }
      } else {
        utils.alertMessage(
          "danger",
          "Vous devez avoir au moins 18 ans pour vous inscrire.",
          alerte_signup
        );
      }
    });
  }
  async function handler_signup(formData, path) {
    try {
      const data = await utils.contactDatabase(formData, path);
      if (!data.success) {
        console.log("Error response", data);
        if (data.alerte) {
          utils.alertMessage(data.alerte, data.message, alerte_signup);
        }
      } else {
        console.log("Success response", data);
        if (data.alerte) {
          utils.alertMessage(data.alerte, data.message, alerte_signup);
        }
        if (data.redirect) {
          // Si la réponse contient une URL de redirection, on attend 10 secondes avant de rediriger vers la page de connexion
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 5000);
        }
      }
    } catch (error) {
      console.error(
        "Une erreure est survenue dans la tentative de connexion au server",
        error
      );
    }
  }

  /************** UPATE infos **************** */
  const _updateUserInfosForm = document.getElementById("_updateUserInfosForm");
  const alerte_update = document.getElementById("alerte_update");
  if (_updateUserInfosForm) {
    _updateUserInfosForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      alerte_update.innerHTML = "";
      const formData = new FormData(e.currentTarget);
      const new_password = document.getElementById("new_password").value;
      const confirm_password =
        document.getElementById("confirm_password").value;
      const path = "src/php/libs/handler_update.php";
      /**si pas de demande de nouveau passeword on vérifie
       *
       * 1. l'age
       * 2. le pseudo
       * 3. le password
       *
       * Après on soumet
       */

      //utilisateur adulte
      if (utils.isAdult(formData.get("birthday"))) {
        const pseudo = formData.get("pseudo").trim();
        console.log(...formData.entries());
        //pseudo > 4 caractères
        if (pseudo.length >= 4) {
          //pas de demande de màj du mot de passe
          // await handler_updateUser(formData, path);
          if (!new_password && !confirm_password) {
            await handler_updateUser(formData, path);
          } else {
            //si demande de màj du mot de passe
            if (new_password === confirm_password) {
              //vérifier que le nouveau mot de passe respecte les critères
              if (utils.checkPassword(confirm_password)) {
                await handler_updateUser(formData, path);
              } else {
                utils.alertMessage(
                  "danger",
                  `<ul class="list-group">Le nouveau mot de passe doit contenir au mois 8 caractères : </ul> 
                <li>une majuscule</li>
                <li>une minuscule</li>
                <li>un chiffre</li>
                <li>un caractère spécial</li>
              </ul>`,
                  alerte_update
                );
              }
              console.log("Mot de passe identiques");
            } else {
              // console.log("Mot de passe differents")
              utils.alertMessage(
                "danger",
                "Les mots de passe saisis ne correspondent pas. Veuillez réessayer.",
                alerte_update
              );
            }
          }
        } else {
          utils.alertMessage(
            "danger",
            "Le nom d'utilisateur doit contenir au moins 4 caractères",
            alerte_update
          );
        }
      } else {
        utils.alertMessage(
          "danger",
          "Vous devez avoir au moins 18 ans pour utiliser ce service. Merci de vérifier votre date de naissance et de la corriger si nécessaire. ",
          alerte_update
        );
      }
    });
  }
  async function handler_updateUser(formData, path) {
    try {
      const data = await utils.contactDatabase(formData, path);
      if (!data.success) {
        console.log("Error response", data);
        if (data.alerte) {
          utils.alertMessage(data.alerte, data.message, alerte_update);
        }
      } else {
        console.log("Success response", data);
        if (data.alerte) {
          utils.alertMessage(data.alerte, data.message, alerte_update);
          if (data.redirect) {
            setTimeout(() => {
              window.location.href = data.redirect;
            }, 5000);
          }
        }
      }
    } catch (error) {
      "Une erreure est survenue dans la tentative de connexion au server",
        error;
    }
  }

  /************** RESET **************** */
  const _resetForm = document.getElementById("_resetForm");
  if (_resetForm) {
    _resetForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(_resetForm);
      const path = "src/php/libs/handler_reset-password.php";

      // console.log(...formData.entries());
      const new_password = formData.get("new_password");
      const confirm_password = formData.get("confirm_password");
      const alerte_reset = document.getElementById("alerte_reset");
      alerte_reset.innerHTML = "";

      if (new_password !== confirm_password) {
        utils.alertMessage(
          "danger",
          "Les mots de passe saisis ne correspondent pas. Veuillez réessayer.",
          alerte_reset
        );
      } else {
        if (utils.checkPassword(new_password)) {
          await handler_resetpassword(formData, path);
          // console.log('mdp ok')
        } else {
          utils.alertMessage(
            "danger",
            `<ul class="list-group">Le nouveau mot de passe doit contenir au mois 8 caractères : </ul> 
                  <li>une majuscule</li>
                  <li>une minuscule</li>
                  <li>un chiffre</li>
                  <li>un caractère spécial</li>
                </ul>`,
            alerte_reset
          );
        }
      }
    });
  }

  async function handler_resetpassword(formData, path) {
    try {
      const data = await utils.contactDatabase(formData, path);
      if (!data.success) {
        console.log("Error Response", data);
        utils.alertMessage(data.alerte, data.message, alerte_reset);
      } else {
        console.log("Success Response", data);
        utils.alertMessage(data.alerte, data.message, alerte_reset);
        setTimeout(() => {
          window.location.href = data.redirect;
        }, 4000);
      }
    } catch (error) {
      console.error("Erreur dans la tentative de connexion au serveur", error);
    }
  }
});
