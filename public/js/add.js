//on récupère le formulaire
const f_product = document.getElementById('form_product');

//on récupère les div d'erreurs
const f_erreur = document.getElementsByClassName('verif');

//on ajoute un écouteur d'évènement sur la soumision du formulaire
f_product.addEventListener('submit', e => {
    //on empêche l'envoie naturel du formulaire
    e.preventDefault();

    //on vide le champ des erreurs
    for (let erreur of f_erreur) {
        erreur.innerHTML ="";
    }

    //on récupère les données du formulaire sous forme de data (clé=>valeur)
    const formData = new FormData(f_product);

    //on envoie les données du formulaire en ajax
    fetch('./application/class/Ad.php', {
        body: formData,
        method: "POST"
    })
    .then(response => response.json())
    .then(datas => {
        if (datas.validation === true) {
            location.href = "produit.php"
        }
        datas.erreurs.forEach((data) => {
            if(data.name) {
                let champ = document.createElement("p");
                champ.innerHTML = data.name;
                document.getElementById("check_mail").appendChild(champ);
            }
            if(data.reference) {
                let champ = document.createElement("p");
                champ.innerHTML = data.reference;
                document.getElementById("check_firstname").appendChild(champ);
            }
            if(data.localisation) {
                let champ = document.createElement("p");
                champ.innerHTML = data.localisation;
                document.getElementById("check_lastname").appendChild(champ);
            }
            if(data.adresse) {
                let champ = document.createElement("p");
                champ.innerHTML = data.adresse;
                document.getElementById("check_phone").appendChild(champ);
            }
            if(data.categorie) {
                let champ = document.createElement("p");
                champ.innerHTML = data.categorie;
                document.getElementById("check_price").appendChild(champ);
            }
            if(data.date_achat) {
                let champ = document.createElement("p");
                champ.innerHTML = data.date_achat;
                document.getElementById("check_picture").appendChild(champ);
            }
            if(data.date_guarantee) {
                let champ = document.createElement("p");
                champ.innerHTML = data.date_guarantee;
                document.getElementById("check_note").appendChild(champ);
            }
        });
    });
});
// *********** Fin Form ***********