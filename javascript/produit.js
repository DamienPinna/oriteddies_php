const idTeddy = document.location.hash.substring(1); //Récupération de l'id produit passé dans l'url.

/**
 * Permet d'afficher un produit en fonction de l'id transmis par la page index.html.
 * @param {String} idTeddy id de l'article sélectionné.
 * @returns {String} retourne du HTML.
 */
const afficherUnTeddy = async idTeddy => {
   const data = await get(`http://localhost:3000/api/teddies/${idTeddy}`);
   const article = document.querySelector('#article');

   //Création dynamiquement de la liste de couleurs.
   let listeDesCouleurs = "";
   for (let couleur of data.colors) {
      listeDesCouleurs += `<option value="${couleur}">${couleur}</option>`;
   }

   article.innerHTML =`
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto">
               <div class="card h-100">
                  <img class="card-img-top" src="${data.imageUrl}" alt="photographie d'un ourson en peluche">
                  <div class="card-body">
                     <h4 class="card-title text-primary">${data.name}</h4>
                     <h5>$${data.price}</h5>
                     <p class="card-text">${data.description}</p>
                  </div>
                  <ul class="list-group list-group-flush">
                     <li class="list-group-item"">
                        <label for="couleur">Couleur :</label>
                        <select class="custom-select" name="couleur" id="couleur">
                           ${listeDesCouleurs}
                        </select>
                     </li>
                     <li class="list-group-item"">
                        <label for="quantite">Quantité :</label>
                        <input type="number" class="form-control" name="quantite" id="quantite" min="1" value="1">
                     </li>
                  </ul>
                  <div class="card-footer text-center">
                     <button id="ajoutPanier" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirmationAjoutPanier">Ajouter au panier</button>
                  </div>
               </div>
            </div>`;
   return article;
};


/**
 * Fonction qui permet d'ajouter le produit dans le localStorage.
 * @param {String} idTeddy id de l'article sélectionné.
 * @param {String} quantite quantité d'articles sélectionnée par l'utilisateur.
 */
const ajoutTeddyLocalStorage = async (idTeddy, quantite) => {
   let data = await get(`http://localhost:3000/api/teddies/${idTeddy}`);
   data.quantite = quantite;
   let tabProduitsPanier = localStorage.getItem('produitsPanier');

   if (tabProduitsPanier == null) {
      tabProduitsPanier = [data];
      ajouterProduitDansLocalStorage(tabProduitsPanier);
   } else {
      tabProduitsPanier = JSON.parse(tabProduitsPanier);
      tabProduitsPanier.push(data);
      ajouterProduitDansLocalStorage(tabProduitsPanier);
   };
};

afficherUnTeddy(idTeddy)
   .then( article => {
      const btnAjoutPanier = article.querySelector('#ajoutPanier');
      btnAjoutPanier.addEventListener('click', () => {
         const quantite = article.querySelector('#quantite').value;
         
         if (parseInt(quantite) > 0 && Number.isInteger(parseFloat(quantite))) {
            ajoutTeddyLocalStorage(idTeddy, quantite);
         } else {
            btnAjoutPanier.removeAttribute('data-toggle');
            btnAjoutPanier.removeAttribute('data-target');
            alert("Il faut saisir un entier supérieur à 0");
            location.reload();
         }

      })
   });

afficherCompteurPanier();

document.querySelector('.close').addEventListener('click', () => document.location.reload());