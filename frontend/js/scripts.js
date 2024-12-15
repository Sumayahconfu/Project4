const carouselContainer = document.querySelector('.carousel-container');
const leftButton = document.querySelector('.carousel-button.left');
const rightButton = document.querySelector('.carousel-button.right');

let scrollPosition = 0;

rightButton.addEventListener('click', () => {
    scrollPosition -= 300; // Adjust scroll step as per image width
    carouselContainer.style.transform = `translateX(${scrollPosition}px)`;
});

leftButton.addEventListener('click', () => {
    scrollPosition += 300;
    carouselContainer.style.transform = `translateX(${scrollPosition}px)`;
});