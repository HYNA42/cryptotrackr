/** calculer la hauteur du header au chargement et définit un padding top équivalent pour le main*/

export function adjustMainPadding() {
  const header = document.querySelector("header");
  const main = document.querySelector("main");

  const headerHeight = header.offsetHeight;
  main.style.paddingTop = headerHeight + "px";
}

/**définit recois un type d'alerte et un message (texte) puis affiche ce message d'alerte dans  le container en paramètre*/
/**
 *
 * @param {*} alerteType
 * @param {*} message
 * @param {*} container
 */
export function alertMessage(alerteType, message, container) {
  /**
   * message : empty, extention, authentification
   * alerteType: warning,sucess, danger
   */
  const divAlert = document.createElement("div");
  divAlert.classList.add(
    "alert",
    `alert-${alerteType}`,
    "alert-dismissible",
    "fade",
    "show"
  );
  divAlert.setAttribute("role", "alert");
  divAlert.innerHTML = `
    <strong>${message}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  `;
  if (container) {
    container.appendChild(divAlert);
  }
}

/**contacter mon serveur et retourne une reponse JSON */
/**
 *
 * @param {*} formData
 * @param {*} path
 * @returns
 */
export async function contactDatabase(formData = null, path) {
  const body = formData ? formData : new FormData();
  const response = await fetch(path, {
    method: "POST",
    body: body,
  });

  if (!response.ok) {
    throw new Error("HTTP error! status:", response.status);
  }

  return response.json();
}

/**connecte l'utilisateur soit via le formulaire d'inscription ou le offcanvas
 * selectionne le formulaire adéquat
 * récupère les input du formlaire en paramètre
 * contact la fonction pour connecter l'utilisateur avec les bon paramère
 * définit et affiche un message d'alerte adéquat au bon endroit
 */
/**
 *
 * @param {*} formID
 * @param {*} alertID
 * @param {*} path
 * @param {*} handler_login
 */
export function addFormSubmitListener(formID, alertID, path, handler_login) {
  const formElement = document.getElementById(formID);
  const alertElement = document.getElementById(alertID);

  if (formElement) {
    formElement.addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      // console.log(...formData.entries());
      if (alertElement) {
        await handler_login(formData, path, alertElement);
      }
    });
  }
}

/**validation du mot de passe (au mois 8 caractères
 * une majuscule,
 * une minuscule,
 * un chiffre,
 * un caractère spécial
 *
 *  */
/**
 *
 * @param {*} password
 * @returns
 */
export function checkPassword(password) {
  const regex = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return regex.test(password);
}

/**vérifie si l'utilisaeur est adulte */

/**
 *
 * @param {*} dateOfbirthday
 * @returns
 */
export function isAdult(dateOfbirthday) {
  const today = new Date();
  const birthDate = new Date(dateOfbirthday);
  let age = today.getFullYear() - birthDate.getFullYear();
  const monthDifference = today.getMonth() - birthDate.getMonth();

  //si nous sommes avant le mois de naissance ou c'est le mois de naissance mais avant le jour de naissance: on soustrait une anéé de l'age

  if (
    monthDifference < 0 ||
    (monthDifference === 0 && today.getDate() < birthDate.getDate())
  ) {
    age--;
  } else return age >= 18;
}

/**
 *La fonction doit forcer le navigateur à recharger l'image à partir du serveur, même si l'URL reste la même. Cela permet à l'utilisateur de voir immédiatement sa nouvelle photo de profil après l'avoir téléchargée, sans avoir besoin de rafraîchir la page ou de se déconnecter/reconnecter.
 *
 * @param {*} newUrl
 * @param {*} profilPictureElementId
 */
export function updateProfilePicture(newUrl, profilPictureElementId) {
  profilPictureElementId.src = newUrl + "?" + new Date().getTime();
}

/**
 *
 * @param {*} url
 * @param {*} options
 * @returns
 */
export async function fetchCoinGeckoAPI(url, options) {
  try {
    const response = await fetch(url, options);
    if (!response.ok) {
      throw new Error("HTTP error ! status : ", response.statusText);
    } else {
      const data = await response.json();
      return data;
    }
  } catch (error) {
    console.error("Error fetching data : ", error);
  }
}
