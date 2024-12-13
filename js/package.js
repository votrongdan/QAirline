// package.js

// Dynamic Loading of Packages or Filtering
document.addEventListener("DOMContentLoaded", () => {
    const packageCards = document.querySelectorAll('.package__card');
  
    packageCards.forEach(card => {
      card.addEventListener('click', () => {
        alert(`You selected: ${card.querySelector('h4').textContent}`);
      });
    });
  });
  