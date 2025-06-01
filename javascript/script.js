$(document).ready(function() {
    // Initialisation du carrousel d'accueil
    $('#swiper-accueil').owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        responsive: {
            0: { items: 1 },
            900: { items: 1 },
            5000: { items: 1 }
        }
    });

    // Initialisation des autres carrousels
    function initCarousel() {
        console.log("Initialisation de la carrousel");
        $(".custom-carousel").owlCarousel({
            autoWidth: true,
            loop: true
        });
    }

    // Gestion des clics sur les éléments du carrousel
    function handleCarouselItemClick() {
        $(".custom-carousel .item").click(function() {
            const currentItem = $(this);
            const otherItems = $(".custom-carousel .item").not(currentItem);
            otherItems.removeClass("active");
            currentItem.toggleClass("active");
            currentItem.removeClass("inactive");
        });
    }

    // Gestion des clics sur le bouton "Déposer un avis"
    function handleAvisBtnClick() {
        $(".avis-btn").click(function() {
            console.log("Clic sur le bouton Déposer un avis");
            window.location.href = "avis.html";
        });
    }

    // Initialisation des carrousels et gestion des événements
    initCarousel();
    handleCarouselItemClick();
    handleAvisBtnClick();

    // Gestion du formulaire d'inscription
    $('#inscription-form').on('submit', function(event) {
        event.preventDefault();
    });

    // Gestion du changement de sélection d'habitat
    $('#habitat-select').on('change', function() {
        let habitat = $(this).val();
        window.location.href = habitat + '.html';
    });

    // Gestion des clics sur les étoiles de notation
    const ratingStars = document.querySelectorAll('.rating-star');
    ratingStars.forEach((star) => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            console.log(`Note : ${rating}`);
            ratingStars.forEach((s) => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.setAttribute('checked', true);
                } else {
                    s.removeAttribute('checked');
                }
            });
        });
    });

    // Gestion du clic sur le bouton "Envoyer"
    const envoyerBtn = document.getElementById('envoyer-btn');
    envoyerBtn.addEventListener('click', () => {
        const nom = document.getElementById('nom').value;
        const avis = document.getElementById('avis').value;
        const rating = document.querySelector('.rating-star[checked]').getAttribute('data-rating');

        console.log(`Nom : ${nom}, Avis : ${avis}, Note : ${rating}`);
    });
});

// Fonction pour ouvrir une page dans un nouvel onglet
function ouvrirPage(url) {
    window.open(url, '_blank');
}

// Gestion de l'ouverture de la modale vidéo
let specialEteButton = document.querySelector('.open-modal-btn');
specialEteButton.addEventListener('click', function() {
    let modal = document.querySelector('.modal-video');
    modal.classList.add('show');
    let video = document.querySelector('iframe');
    video.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', 'https://www.youtube.com');
});

// Gestion du chargement de la vidéo
let video = document.querySelector('iframe');
video.addEventListener('load', function() {
    console.log('La vidéo est chargée');
    video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', 'https://www.youtube.com');
});

// Gestion de la fermeture de la modale vidéo
let closeButton = document.querySelector('.close-btn');
closeButton.addEventListener('click', function() {
    console.log('La fenêtre modale est fermée');
    let video = document.querySelector('iframe');
    video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', 'https://www.youtube.com');
    let modal = document.querySelector('.modal-video');
    modal.classList.remove('show');
});



document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    handleCarouselItemClick();
    handleAvisBtnClick();

    // Gestion du formulaire d'inscription
    $('#inscription-form').on('submit', function(event) {
        event.preventDefault();
    });

    // Gestion du changement de sélection d'habitat
    $('#habitat-select').on('change', function() {
        let habitat = $(this).val();
        window.location.href = habitat + '.html';
    });

    let videoFrame = document.getElementById('videoFrame');
    if (videoFrame) {
        videoFrame.src += "?autoplay=1";
    }

    // Gestion des clics sur les étoiles de notation
    const ratingStars = document.querySelectorAll('.rating-star');
    ratingStars.forEach((star) => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            console.log(`Note : ${rating}`);
            ratingStars.forEach((s) => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.setAttribute('checked', true);
                } else {
                    s.removeAttribute('checked');
                }
            });
        });
    });
});

