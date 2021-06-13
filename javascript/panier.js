window.onload = () => {
   const lesBoutonsSup = document.querySelectorAll('.supprimerUneLigne');
   for (const unBoutonSup of lesBoutonsSup) {
      unBoutonSup.addEventListener('click', () => {
      const index = unBoutonSup.querySelector('input').value;
      supprimerLignePanier(index);
      })
   };
};

//Objet envoyé au serveur :
let order = {
   contact: {
      firstName: String,
      lastName: String,
      address: String,
      city: String,
      email: String
      },
   products: [String]
};

//Les élements du formulaire :
const form = document.querySelector('form');
const inputFirstName = document.querySelector('#firstName');
const missFirstName = document.querySelector('#missFirstName');
const inputLastName = document.querySelector('#lastName');
const missLastName = document.querySelector('#missLastName');
const inputAddress = document.querySelector('#address')
const missAddress = document.querySelector('#missAddress')
const inputCity = document.querySelector('#city');
const missCity = document.querySelector('#missCity');
const inputEmail = document.querySelector('#email');
const missEmail = document.querySelector('#missEmail');
const allMiss = document.querySelectorAll('form span');


/**
 * Fonction qui permet de créer une ligne du panier en HTML.
 * @param {Object} teddy correspond à un élement du tableau de produit(s).
 * @returns {String} HTML
 */
const creerLignePanier = (teddy, index) => {
   const tr = document.createElement('tr');
 
   const thSupprimer = document.createElement('th');
   thSupprimer.setAttribute('scope', 'row');
   thSupprimer.innerHTML= `<div class="supprimerUneLigne">
                              <i class="fas fa-times-circle"></i>
                              <input type="hidden" value="${index}">
                           </div>`;
   tr.appendChild(thSupprimer);

   const tdArticle = document.createElement('td');
   tdArticle.innerText = teddy.name;
   tr.appendChild(tdArticle);

   const tdImage = document.createElement('td');
   tdImage.classList.add('w-25');
   tdImage.innerHTML = `<img src="${teddy.imageUrl}" alt="photographie de l'ourson ${teddy.name}" class="img-thumbnail"></img>`;
   tr.appendChild(tdImage);

   const tdQuantite = document.createElement('td');
   tdQuantite.innerText = teddy.quantite;
   tr.appendChild(tdQuantite);

   const tdPrix = document.createElement('td');
   tdPrix.innerText = `$${teddy.sousTotal}`;
   tr.appendChild(tdPrix);
   
   return tr;
};


/**
 * Fonction qui permet d'afficher sur le navigateur la liste des produits du panier.
 * @param {Array} teddies les produits sélectionnés par l'utilisateur.
 */
const afficherTabPanier = teddies => {
   const tbody = document.querySelector('tbody');
   const total = document.querySelector('.total');

   const newTeddies = teddies.map(e => ({...e, sousTotal: e.quantite * e.price})); //Création d'une projection du tableau teddies nommée newTeddies et ajout du sous total.

   newTeddies.forEach((teddy, index) => tbody.appendChild(creerLignePanier(teddy, index)));

   const prixTotalDuPanier = newTeddies.reduce((acc, teddy) => acc + teddy.sousTotal, 0); //On additionne le sous total à chaque itération pour avoir le total.

   total.innerText = `$${prixTotalDuPanier}`;
};


/**
 * Fonction qui permet de supprimer un objet du tableau se trouvant dans le localStorage.
 * @param {Number} index position du clique sur un bouton "supprimer".
 */
const supprimerLignePanier = index => {
   tabObjetsLocalStorage.splice(index, 1);
   ajouterProduitDansLocalStorage(tabObjetsLocalStorage);
   document.location.reload();
};


/**
 * Permet de supprimer l'item produitsPanier du localStorage et de raffraichir la page au clique sur le bouton "vider le panier".
 */
document.querySelector('#viderPanier').addEventListener('click', () => {
   localStorage.removeItem('produitsPanier');
   document.location.reload();
});


/**
 * Fonction permettant de controler les entrées du formulaire.
 * @param {String} firstName prénom saisi dans le formulaire.
 * @param {String} lastName nom saisi dans le formulaire.
 * @param {String} address adresse saisie dans le formulaire.
 * @param {String} city ville saisie dans le formulaire.
 * @param {String} email adresse mail saisie dans le formulaire.
 * @returns {Boolean} retourne true si le contrôle du formulaire est OK.
 */
const checkForm = (firstName, lastName, address, city, email) => {
   let compteurCheckForm = 0;

   const firstNameOK = /^[A-ZÀ-Ý]{1}[a-zà-ý\s'-]+$/;
   const lastNameOK = /^([A-ZÀ-Ý\s-]){2,}$/;
   const addressOK = /^[a-zà-ý0-9-'\s]*$/i;
   const cityOK = /^[a-zà-ý-'\s]*$/i;
   const emailOK = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   
   allMiss.forEach(oneMiss => oneMiss.textContent = "");
   
   //Test du prénom :
   if (firstName === "") {
      missFirstName.textContent = "Veuillez renseigner votre prénom.";
   } else if (firstNameOK.test(firstName) == false) {
      missFirstName.textContent = "Le prénom saisi n'est pas valide.";
   } else {
      order.contact.firstName = firstName;
      compteurCheckForm++;
   };

   //Test du nom :
   if (lastName === "") {
      missLastName.textContent = "Veuillez renseigner votre nom.";
   } else if (lastNameOK.test(lastName) == false) {
      missLastName.textContent = "Le nom saisi n'est pas valide.";
   } else {
      order.contact.lastName = lastName;
      compteurCheckForm++;
   };

   //Test de l'adresse :
   if (address === "") {
      missAddress.textContent = "Veuillez renseigner votre adresse.";
   } else if (addressOK.test(address) == false) {
      missAddress.textContent = "l'adresse saisie n'est pas valide.";
   } else {
      order.contact.address = address;
      compteurCheckForm++;
   };

   //Test de la ville :
   if (city === "") {
      missCity.textContent = "Veuillez renseigner votre ville.";
   } else if (cityOK.test(city) == false) {
      missCity.textContent = "la ville saisie n'est pas valide.";
   } else {
      order.contact.city = city;
      compteurCheckForm++;
   };

   //Test de l'adresse mail :
   if (email === "") {
      missEmail.textContent = "Veuillez renseigner votre email.";
   } else if (emailOK.test(email) == false) {
      missEmail.textContent = "L'email saisi n'est pas valide.";
   } else {
      order.contact.email = email;
      compteurCheckForm++;
   };

   return (compteurCheckForm == 5) ? true : false;
};


/**
 * Permet au clique sur le bouton "commander" d'envoyer les informations de la commande au serveur et d'enregistrer le retour dans la sessionStorage après contrôle des inputs.
 */
form.addEventListener('submit', event => {
   event.preventDefault();

   const firstName = inputFirstName.value;
   const lastName = inputLastName.value;
   const address = inputAddress.value;
   const city = inputCity.value;
   const email = inputEmail.value;

   const resulatcheckForm = checkForm(firstName, lastName, address, city, email);

   const products = tabObjetsLocalStorage.map(e => e._id);
   order.products = products;

   if (resulatcheckForm) {
      insertPost(order)
      .then(responseData => ajouterCommandeDansSessionStorage(responseData))
      .then( () => { 
         localStorage.removeItem('produitsPanier'); 
         window.location.href = 'confirm_order.html';
      });
   };
});


//Affichage :
if (localStorage.getItem('produitsPanier') === null || localStorage.getItem('produitsPanier') === "[]") {
   document.querySelector('#content').classList.add('d-none');
   document.querySelector('footer').classList.add('fixed-bottom');
} else {
   document.querySelector('#emptyPanier').classList.add('d-none');
   afficherTabPanier(tabObjetsLocalStorage);
};

afficherCompteurPanier();