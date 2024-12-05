// about.js

// ScrollReveal for About Page Animations
document.addEventListener("DOMContentLoaded", () => {
    ScrollReveal().reveal('.section__header, .section__description', { 
      origin: 'left', 
      distance: '50px', 
      duration: 1000 
    });
  
    ScrollReveal().reveal('.about__container p', { 
      origin: 'right', 
      distance: '50px', 
      duration: 1000, 
      delay: 200 
    });
  });
  