export default function fornav() {
    window.addEventListener('scroll', function() {
        var nav = document.querySelector('.site-nav');
        var scrollPosition = window.scrollY;
    
        if (scrollPosition > 0) {
            nav.classList.add('sticky');
        } else {
            nav.classList.remove('sticky');
        }
    });
}