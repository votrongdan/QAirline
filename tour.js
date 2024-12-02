document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.tour__filter-btn');
    const tourCards = document.querySelectorAll('.tour__card');
  
    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        button.classList.add('active');
  
        // Get the filter value
        const filter = button.getAttribute('data-filter').toLowerCase();
  
        // Filter tour cards
        tourCards.forEach(card => {
          const cardCategory = card.getAttribute('data-category').toLowerCase();
          
          if (filter === 'all' || cardCategory === filter) {
            card.style.display = 'block';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  });