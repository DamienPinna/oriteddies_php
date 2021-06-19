/**
 * Fonction qui permet de retourner l'id de commande et le prix total de la commande.
 * @returns {Array}
 */
const infosOrder = () => {
   const order = getTabSessionStorage();
   const orderId = order.orderId;
   const prixCommande = order.products.reduce((acc, product) => acc + parseInt(product.price), 0);
   return [orderId, prixCommande];
}

/**
 * Fonction qui permet d'afficher la référence et le prix total de la commande effectuée.
 */
const afficherInfosOrder = () => {
   const [refOrder, prixTotal] = infosOrder();
   const infosCommande = document.querySelector('.infos-commande');
   let txt = `
      <p class="ref-commmande pt-3">Référence (à conserver) : ${refOrder}</p>
      <p class="prix-total pb-3">Montant total : $${prixTotal}</p>`
   
   infosCommande.innerHTML = txt;
}

afficherInfosOrder();