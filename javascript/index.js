/**
 * Permet d'afficher tous les articles dans le navigateur.
 */
const afficherTeddies = async () => {
   const data = await get('http://localhost:3000/api/teddies');
   const articles = document.querySelector('#articles');
   let teddies = ""; 
   for (let teddy of data) {
      teddies +=`
            <div class="col-md-6 col-lg-4 mb-4">
               <div class="card h-100">
                  <a href="./views/produit.html#${teddy._id}"><img class="card-img-top" src="${teddy.imageUrl}" alt="photographie d'un ourson en peluche"></a>
                  <div class="card-body">
                     <h4 class="card-title">
                        <a href="./views/produit.html#${teddy._id}">${teddy.name}</a>
                     </h4>
                     <h5>$${teddy.price}</h5>
                     <p class="card-text">${teddy.description}</p>
                  </div>
                  <div class="card-footer text-center">
                     <a href="./views/produit.html#${teddy._id}" class="btn btn-secondary">Ca m'intéresse</a>
                  </div>
               </div>
            </div>`;
   }
   articles.innerHTML = teddies;
};

afficherTeddies();

afficherCompteurPanier();