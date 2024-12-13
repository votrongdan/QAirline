// Enhanced Website Functionality

// Existing code from main.js (kept for context)
const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

// Scroll Progress Bar
function createScrollProgressBar() {
  const progressBar = document.createElement('div');
  progressBar.id = 'scroll-progress';
  progressBar.style.position = 'fixed';
  progressBar.style.top = '0';
  progressBar.style.left = '0';
  progressBar.style.width = '0%';
  progressBar.style.height = '4px';
  progressBar.style.backgroundColor = 'var(--primary-color)';
  progressBar.style.zIndex = '10';
  document.body.appendChild(progressBar);

  window.addEventListener('scroll', () => {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    progressBar.style.width = scrolled + '%';
  });
}

// Newsletter Subscription with Validation
function setupNewsletterSubscription() {
  const subscribeForm = document.querySelector('footer form');
  const emailInput = subscribeForm.querySelector('input');

  subscribeForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simple email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!emailRegex.test(emailInput.value)) {
      alert('Please enter a valid email address.');
      return;
    }

    // Simulate subscription (replace with actual backend logic)
    alert(`Thank you for subscribing with ${emailInput.value}!`);
    emailInput.value = ''; // Clear input
  });
}

// Animated Destination Ratings
function animateDestinationRatings() {
  const ratingElements = document.querySelectorAll('.destination__rating');
  
  ratingElements.forEach(rating => {
    rating.addEventListener('mouseenter', () => {
      rating.style.transform = 'scale(1.1)';
      rating.style.transition = 'transform 0.3s ease';
    });

    rating.addEventListener('mouseleave', () => {
      rating.style.transform = 'scale(1)';
    });
  });
}

// Smooth Scroll to Sections
function enableSmoothScrolling() {
  const navLinks = document.querySelectorAll('nav .nav__links a');
  
  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      
      // Only handle internal links
      if (targetId.startsWith('#') && targetId !== '#') {
        e.preventDefault();
        const targetSection = document.querySelector(targetId);
        
        if (targetSection) {
          targetSection.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
          });
        }
      }
    });
  });
}

// Dynamic Copyright Year
function updateCopyrightYear() {
  const copyrightElement = document.querySelector('.footer__bar');
  const currentYear = new Date().getFullYear();
  
  copyrightElement.textContent = `Copyright © ${currentYear} Web Design Mastery. All rights reserved.`;
}

// Initialize all functions
function initializeWebsiteFunctionality() {
  createScrollProgressBar();
  setupNewsletterSubscription();
  animateDestinationRatings();
  enableSmoothScrolling();
  updateCopyrightYear();
}

// Run initialization when DOM is fully loaded
document.addEventListener('DOMContentLoaded', initializeWebsiteFunctionality);

// Existing Swiper and ScrollReveal initializations
const scrollRevealOption = {
  origin: "bottom",
  distance: "50px",
  duration: 1000,
};