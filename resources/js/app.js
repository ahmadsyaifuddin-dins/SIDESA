import './bootstrap';

document.addEventListener('alpine:init', () => {
    Alpine.store('sidebar', {
        isOpen: window.innerWidth > 768, // Default terbuka di desktop, tertutup di mobile
        toggle() {
            this.isOpen = ! this.isOpen
        }
    })
})