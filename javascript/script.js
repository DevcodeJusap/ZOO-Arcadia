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

    // Fonction pour initialiser le carrousel des avis
    function initAvisCarousel() {
        $('#carousel-avis').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
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
        var habitat = $(this).val();
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
        const rating = document.querySelector('.rating-star:checked').getAttribute('data-rating');

        console.log(`Nom : ${nom}, Avis : ${avis}, Note : ${rating}`);
    });
});

// Fonction pour ouvrir une page dans un nouvel onglet
function ouvrirPage(url) {
    window.open(url, '_blank');
}

// Gestion de l'ouverture de la modale vidéo
var specialEteButton = document.querySelector('.open-modal-btn');
specialEteButton.addEventListener('click', function() {
    var modal = document.querySelector('.modal-video');
    modal.classList.add('show');
    var video = document.querySelector('iframe');
    video.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
});

// Gestion du chargement de la vidéo
var video = document.querySelector('iframe');
video.addEventListener('load', function() {
    console.log('La vidéo est chargée');
    video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
});

// Gestion de la fermeture de la modale vidéo
var closeButton = document.querySelector('.close-btn');
closeButton.addEventListener('click', function() {
    console.log('La fenêtre modale est fermée');
    var video = document.querySelector('iframe');
    video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
    var modal = document.querySelector('.modal-video');
    modal.classList.remove('show');
});

// Fonction pour fermer le modal
function closeModal() {
    var modalVideo = document.getElementById('modalVideo');
    if (modalVideo) {
        modalVideo.style.display = 'none';
    }
    var videoFrame = document.getElementById('videoFrame');
    if (videoFrame) {
        videoFrame.src = videoFrame.src.replace("?autoplay=1", "");
    }
}

// Fermer le modal si l'utilisateur clique en dehors du contenu
window.onclick = function(event) {
    var modal = document.getElementById("modalVideo");
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

document.addEventListener('DOMContentLoaded', function() {
    initCarousel();
    initAvisCarousel();
    handleCarouselItemClick();
    handleAvisBtnClick();

    // Gestion du formulaire d'inscription
    $('#inscription-form').on('submit', function(event) {
        event.preventDefault();
    });

    // Gestion du changement de sélection d'habitat
    $('#habitat-select').on('change', function() {
        var habitat = $(this).val();
        window.location.href = habitat + '.html';
    });

    var videoFrame = document.getElementById('videoFrame');
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