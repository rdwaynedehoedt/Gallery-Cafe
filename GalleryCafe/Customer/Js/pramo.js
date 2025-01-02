document.addEventListener('DOMContentLoaded', () => {
    const carouselContainer = document.querySelector('.carousel-container');
    const promotions = document.querySelectorAll('.promotion');
    const prevButton = document.getElementById('prev');
    const nextButton = document.getElementById('next');
    let currentIndex = 0;

    const updateCarousel = () => {
        carouselContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
    };

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex === 0) ? promotions.length - 1 : currentIndex - 1;
        updateCarousel();
    });

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex === promotions.length - 1) ? 0 : currentIndex + 1;
        updateCarousel();
    });

    setInterval(() => {
        currentIndex = (currentIndex === promotions.length - 1) ? 0 : currentIndex + 1;
        updateCarousel();
    }, 5000); 
});
