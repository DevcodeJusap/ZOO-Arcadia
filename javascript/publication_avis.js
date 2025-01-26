function ajouterAvis(texte, nom, age, note) {
    const newItem = document.createElement('div');
    newItem.classList.add('item');

    const avisContent = `
        <div class="avis-content">
            <p>"${texte}"</p>
            <span>— ${nom}, ${age} ans</span>
        </div>
        <div class="rating">
            ${genererEtoiles(note)}
        </div>`;

    newItem.innerHTML = avisContent;

    document.querySelector('.carousel-avis').appendChild(newItem);
}

function genererEtoiles(note) {
    let etoiles = '';
    for (let i = 1; i <= 5; i++) {
        if (i <= note) {
            etoiles += '<i class="fas fa-star"></i>';
        } else if (i === Math.ceil(note) && note % 1 !== 0) {
            etoiles += '<i class="fas fa-star-half-alt"></i>';
        } else {
            etoiles += '<i class="far fa-star"></i>';
        }
    }
    return etoiles;
}

function validerAvis() {
    const texte = "C'était une expérience incroyable !";
    const nom = "Jean";
    const age = 30;
    const note = 4.5;

    ajouterAvis(texte, nom, age, note);
}
