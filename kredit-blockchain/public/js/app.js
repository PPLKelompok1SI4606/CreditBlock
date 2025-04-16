const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show-animated');
        } else {
            entry.target.classList.remove('show-animated');
        }
    });
});

const hiddenElements = document.querySelectorAll('.hidden-animated');
hiddenElements.forEach((el) => observer.observe(el));

document.addEventListener('DOMContentLoaded', () => {
    // Select all accordion sections
    const accordionSections = document.querySelectorAll('.accordion-section');

    // Initialize each accordion
    accordionSections.forEach(section => {
        const toggleIcon = section.querySelector('.toggle-icon');
        const explanation = section.querySelector('.explanation');

        // Add click event listener to each toggle icon
        toggleIcon.addEventListener('click', () => {
            const isExpanded = section.getAttribute('data-expanded') === 'true';

            if (isExpanded) {
                // Collapse
                explanation.classList.remove('active');
                section.classList.remove('py-5', 'bg-white');
                section.classList.add('py-6');
                toggleIcon.src = "images/plus.png";
                section.setAttribute('data-expanded', 'false');
            } else {
                // Expand
                explanation.classList.add('active');
                section.classList.remove('py-6');
                section.classList.add('py-5', 'bg-white');
                toggleIcon.src = "images/-.png";
                section.setAttribute('data-expanded', 'true');
            }
        });
    });
});
