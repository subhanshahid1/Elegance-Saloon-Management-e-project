// ===== TOPBAR DATE =====
/**
 * Updates the date display in the topbar to the current date
 */
function updateTopbarDate() {
    const dateEl = document.getElementById('topbar-date');
    if (dateEl) {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        dateEl.textContent = now.toLocaleDateString('en-US', options);
    }
}

// ===== MOBILE SIDEBAR TOGGLE =====
/**
 * Handles the opening/closing of sidebar on mobile devices
 */
function initMobileSidebar() {
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    // Create overlay element if it doesn't exist
    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);
    }

    if (toggleBtn && sidebar) {
        // Toggle Sidebar
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('active');
        });

        // Close when clicking overlay
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('active');
        });

        // Close sidebar when a link is clicked (for smoother mobile navigation)
        sidebar.querySelectorAll('.nav-link-custom').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('active');
            });
        });
    }
}

// ===== PAGE NAVIGATION =====
/**
 * Sets the active state on sidebar links based on the current URL
 */
function handleSidebarActiveState() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link-custom');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href');
        // Check if path ends with the link destination
        if (href && currentPath.endsWith(href)) {
            link.classList.add('active');
        }
    });
}

// ===== MODAL LOGIC =====
/**
 * Opens a modal by ID
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden'; 
    }
}

/**
 * Closes all open modals
 */
function closeModal() {
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(modal => {
        modal.classList.remove('open');
    });
    document.body.style.overflow = ''; 
}

// Global click listener for closing modals
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeModal();
    }
});

// Global key listener for closing modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// ===== TAB PILLS =====
/**
 * Switches active state for tab pills
 */
function activateTab(el) {
    const group = el.closest('.tab-pills');
    if (group) {
        group.querySelectorAll('.tab-pill').forEach(t => t.classList.remove('active'));
    }
    el.classList.add('active');
}

// ===== TOGGLE SWITCHES =====
/**
 * Initializes toggle switch click events
 */
function initToggles() {
    document.querySelectorAll('.toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            this.classList.toggle('off');
        });
    });
}

// ===== STAR RATING =====
/**
 * Star rating hover and click logic
 */
function initStarRating() {
    const starsEl = document.getElementById('stars');
    if (starsEl) {
        let rating = 0;
        const stars = starsEl.querySelectorAll('.star');

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const val = parseInt(this.dataset.val);
                stars.forEach((s, i) => s.classList.toggle('active', i < val));
            });
            
            star.addEventListener('click', function() {
                rating = parseInt(this.dataset.val);
            });
            
            star.addEventListener('mouseleave', function() {
                stars.forEach((s, i) => s.classList.toggle('active', i < rating));
            });
        });
    }
}

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    updateTopbarDate();
    handleSidebarActiveState();
    initMobileSidebar();
    initToggles();
    initStarRating();
});