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
