// contact.js

// Simple Form Validation
document.addEventListener("DOMContentLoaded", () => {
    const contactForm = document.querySelector('.contact__form');
    
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      const name = document.querySelector('#name').value.trim();
      const email = document.querySelector('#email').value.trim();
      const message = document.querySelector('#message').value.trim();
  
      if (!name || !email || !message) {
        alert('Please fill out all fields!');
        return;
      }
  
      alert('Message sent successfully!');
      contactForm.reset();
    });
  });
  