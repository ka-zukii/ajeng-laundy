document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("mobile-menu-button");
    const menu = document.getElementById("mobile-menu");
    const mobileLinks = document.querySelectorAll('.mobile-link')

    if (btn && menu) {
        btn.addEventListener("click", () => {
            if (menu.classList.contains("hidden")) {
                menu.classList.remove("hidden");
                menu.classList.add("flex");
            } else {
                menu.classList.remove("flex");
                menu.classList.add("hidden");
            }
        });
    }

    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
        });
    });
});


// expand / collapse FAQ
document.addEventListener('DOMContentLoaded', () => {

    const faqCards = document.querySelectorAll('.faq-card-container');

    faqCards.forEach(card => {
        
        card.addEventListener('click', function() {
            const content = this.querySelector('.faq-content');
            const icon = this.querySelector('.faq-icon');

            if (content.style.gridTemplateRows === '1fr') {
                content.style.gridTemplateRows = '0fr';
                icon.classList.remove('rotate-180');
            } else {
                content.style.gridTemplateRows = '1fr';
                icon.classList.add('rotate-180');
            }
        });
        
    });
    
});