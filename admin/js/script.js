function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Prevent body scroll on mobile
    if(sidebar.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}

// Close sidebar on link click (mobile)
document.querySelectorAll('#sidebar .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        if(window.innerWidth <= 768) toggleSidebar();
    });
});