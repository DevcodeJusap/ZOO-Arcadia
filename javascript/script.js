$(document).ready(function() {
    $('#swiper-accueil').owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        responsive: {
            0: {
                items: 1
            },
            900: {
                items: 1
            },
            5000: {
                items: 1
            }
        }
    });
});


$(document).ready(function() {
    
    const initCarousel = () => {
        console.log("Initialisation de la carrousel");
        $(".custom-carousel").owlCarousel({
            autoWidth: true,
            loop: true
        });
    };

    const initAvisCarousel = () => {
        console.log("Initialisation de la carrousel d'avis");
        $('.carousel-avis').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 8000,
            autoplayHoverPause: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });
    };

    const handleCarouselItemClick = () => {
        $(".custom-carousel .item").click(function() {
            const currentItem = $(this);
            const otherItems = $(".custom-carousel .item").not(currentItem);
            otherItems.removeClass("active");
            currentItem.toggleClass("active");
            currentItem.removeClass("inactive");
        });
    };

    const handleAvisBtnClick = () => {
        $(".avis-btn").click(function() {
            console.log("Clic sur le bouton Déposer un avis");
            window.location.href = "avis.html";
        });
    };

    initCarousel();
    initAvisCarousel();
    handleCarouselItemClick();
    handleAvisBtnClick();

    $('#inscription-form').on('submit', function(event) {
        event.preventDefault();
    });

    $('#habitat-select').on('change', function() {
        var habitat = $(this).val();
        window.location.href = habitat + '.html';
    });

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

    const envoyerBtn = document.getElementById('envoyer-btn');
    envoyerBtn.addEventListener('click', () => {
        const nom = document.getElementById('nom').value;
        const avis = document.getElementById('avis').value;
        const rating = document.querySelector('.rating-star:checked').getAttribute('data-rating');

        console.log(`Nom : ${nom}, Avis : ${avis}, Note : ${rating}`);
    });
});

function ouvrirPage(url) {
    window.open(url, '_blank');
}

var specialEteButton = document.querySelector('.open-modal-btn');
specialEteButton.addEventListener('click', function() {
    var modal = document.querySelector('.modal-video');
    modal.classList.add('show');
var video = document.querySelector('iframe');
    video.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
});

var video = document.querySelector('iframe');

video.addEventListener('load', function() {
    console.log('La vidéo est chargée');

video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
});

var closeButton = document.querySelector('.close-btn');
closeButton.addEventListener('click', function() {
    console.log('La fenêtre modale est fermée');

var video = document.querySelector('iframe');
    video.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');

var modal = document.querySelector('.modal-video');
    modal.classList.remove('show');
});