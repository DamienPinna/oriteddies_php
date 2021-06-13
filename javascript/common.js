/**
 * Fonction qui permet d'ajouter dans le localStorage ce qui est passé en paramètre.
 * @param {Array} tabProduitsPanier tableau comprenant un ou des objects correspondant à un article.
 */
const ajouterProduitDansLocalStorage = tabProduitsPanier => {
   tabProduitsPanier = JSON.stringify(tabProduitsPanier);
   localStorage.setItem('produitsPanier', tabProduitsPanier);
};


/**
 * Fonction qui permet d'ajouter dans le localStorage la commande.
 * @param {String} responseData réponse du serveur au format JSON de l'objet contact, un tableau des produits commandés et l'id de la commande.
 */
const ajouterCommandeDansSessionStorage = responseData => sessionStorage.setItem('order', responseData);


/**
 * Fonction qui permet d'afficher à coté de l'icône panier la quantité d'articles se trouvant dans le panier.
 */
const afficherCompteurPanier = () => {
   const compteurPanier = tabObjetsLocalStorage.reduce((acc, teddy) => acc + parseInt(teddy.quantite), 0);
   const badge = document.querySelector('.badge');
   badge.innerHTML = compteurPanier;
};