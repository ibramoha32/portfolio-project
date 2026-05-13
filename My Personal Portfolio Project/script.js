// DOM Elements
const darkModeToggle = document.getElementById('darkModeToggle');
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const navLinks = document.querySelector('.nav-links');
const contactForm = document.getElementById('contactForm');
const projectsContainer = document.getElementById('projectsContainer');
const heroTitle = document.querySelector('.hero-title');

// Typing Effect for Hero Title
const typeWriter = (element, text, speed = 100) => {
    let i = 0;
    element.innerHTML = '';
    const type = () => {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    };
    type();
};

// Initialize typing effect on page load
document.addEventListener('DOMContentLoaded', () => {
    const originalText = heroTitle.innerHTML;
    // Delay typing effect until CSS animation completes
    setTimeout(() => {
        typeWriter(heroTitle, originalText.replace(/<[^>]*>/g, ''), 50);
        // Restore the highlight span after typing
        setTimeout(() => {
            heroTitle.innerHTML = originalText;
        }, originalText.length * 50 + 500);
    }, 1500);
});

// Dark Mode Toggle
darkModeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
    const icon = darkModeToggle.querySelector('i');
    if (document.body.classList.contains('dark-mode')) {
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
        localStorage.setItem('darkMode', 'enabled');
    } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
        localStorage.setItem('darkMode', 'disabled');
    }
});

// Check for saved dark mode preference
if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
    const icon = darkModeToggle.querySelector('i');
    icon.classList.remove('fa-moon');
    icon.classList.add('fa-sun');
}

// Mobile Menu Toggle
mobileMenuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    const icon = mobileMenuToggle.querySelector('i');
    if (navLinks.classList.contains('active')) {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-times');
    } else {
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    }
});

// Close mobile menu when clicking a link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        navLinks.classList.remove('active');
        const icon = mobileMenuToggle.querySelector('i');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
    });
});

// Smooth Scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Contact Form Validation with shake animation
const validateForm = () => {
    let isValid = true;
    
    // Name validation
    const name = document.getElementById('name');
    const nameError = document.getElementById('nameError');
    if (name.value.trim() === '') {
        name.classList.add('error');
        shakeElement(name);
        nameError.textContent = 'Name is required';
        isValid = false;
    } else if (name.value.trim().length < 2) {
        name.classList.add('error');
        shakeElement(name);
        nameError.textContent = 'Name must be at least 2 characters';
        isValid = false;
    } else {
        name.classList.remove('error');
        nameError.textContent = '';
    }
    
    // Email validation
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.value.trim() === '') {
        email.classList.add('error');
        shakeElement(email);
        emailError.textContent = 'Email is required';
        isValid = false;
    } else if (!emailRegex.test(email.value.trim())) {
        email.classList.add('error');
        shakeElement(email);
        emailError.textContent = 'Please enter a valid email address';
        isValid = false;
    } else {
        email.classList.remove('error');
        emailError.textContent = '';
    }
    
    // Subject validation
    const subject = document.getElementById('subject');
    const subjectError = document.getElementById('subjectError');
    if (subject.value.trim() === '') {
        subject.classList.add('error');
        shakeElement(subject);
        subjectError.textContent = 'Subject is required';
        isValid = false;
    } else if (subject.value.trim().length < 3) {
        subject.classList.add('error');
        shakeElement(subject);
        subjectError.textContent = 'Subject must be at least 3 characters';
        isValid = false;
    } else {
        subject.classList.remove('error');
        subjectError.textContent = '';
    }
    
    // Message validation
    const message = document.getElementById('message');
    const messageError = document.getElementById('messageError');
    if (message.value.trim() === '') {
        message.classList.add('error');
        shakeElement(message);
        messageError.textContent = 'Message is required';
        isValid = false;
    } else if (message.value.trim().length < 10) {
        message.classList.add('error');
        shakeElement(message);
        messageError.textContent = 'Message must be at least 10 characters';
        isValid = false;
    } else {
        message.classList.remove('error');
        messageError.textContent = '';
    }
    
    return isValid;
};

// Shake animation for invalid inputs
const shakeElement = (element) => {
    element.style.animation = 'shake 0.5s ease';
    setTimeout(() => {
        element.style.animation = '';
    }, 500);
};

// Add shake animation keyframes
const shakeStyle = document.createElement('style');
shakeStyle.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(shakeStyle);

// Real-time validation
document.querySelectorAll('#contactForm input, #contactForm textarea').forEach(input => {
    input.addEventListener('blur', validateForm);
    input.addEventListener('input', () => {
        input.classList.remove('error');
        const errorElement = document.getElementById(input.id + 'Error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    });
});

// Contact Form Submission with success animation
contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    if (!validateForm()) {
        return;
    }
    
    const btnText = contactForm.querySelector('.btn-text');
    const btnLoading = contactForm.querySelector('.btn-loading');
    const formMessage = document.getElementById('formMessage');
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    
    // Show loading state
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline';
    formMessage.style.display = 'none';
    submitBtn.disabled = true;
    
    const formData = new FormData(contactForm);
    
    try {
        const response = await fetch('api/contact.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            formMessage.textContent = '✨ Message sent successfully! I will get back to you soon.';
            formMessage.className = 'form-message success';
            contactForm.reset();
            
            // Celebrate with confetti effect
            createConfetti();
        } else {
            formMessage.textContent = result.message || 'Error sending message. Please try again.';
            formMessage.className = 'form-message error';
        }
    } catch (error) {
        formMessage.textContent = 'Error sending message. Please try again.';
        formMessage.className = 'form-message error';
    } finally {
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        formMessage.style.display = 'block';
        submitBtn.disabled = false;
    }
});

// Confetti effect for form success
const createConfetti = () => {
    const colors = ['#8b5cf6', '#a855f7', '#6366f1', '#c084fc'];
    for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.width = '10px';
        confetti.style.height = '10px';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.top = '-10px';
        confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
        confetti.style.zIndex = '10000';
        confetti.style.animation = `fall ${Math.random() * 2 + 2}s linear forwards`;
        document.body.appendChild(confetti);
        
        setTimeout(() => confetti.remove(), 4000);
    }
};

// Add confetti animation
const confettiStyle = document.createElement('style');
confettiStyle.textContent = `
    @keyframes fall {
        to {
            transform: translateY(100vh) rotate(720deg);
            opacity: 0;
        }
    }
`;
document.head.appendChild(confettiStyle);

// Load Projects via AJAX with staggered animation
const loadProjects = async () => {
    try {
        const response = await fetch('api/projects.php');
        const projects = await response.json();
        
        if (projects.length === 0) {
            projectsContainer.innerHTML = '<p class="loading">No projects found. Check back soon!</p>';
            return;
        }
        
        projectsContainer.innerHTML = projects.map((project, index) => `
            <div class="project-card" style="animation-delay: ${index * 0.1}s">
                <div class="project-image">
                    <i class="fas fa-code"></i>
                </div>
                <div class="project-content">
                    <h3>${project.title}</h3>
                    <p>${project.description}</p>
                    <div class="project-tags">
                        ${project.tags.map(tag => `<span class="tag">${tag}</span>`).join('')}
                    </div>
                    <a href="${project.link || '#'}" target="_blank" rel="noopener noreferrer" class="project-link">
                        View Project <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        `).join('');
        
        // Re-observe new project cards
        document.querySelectorAll('.project-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            observer.observe(card);
        });
    } catch (error) {
        projectsContainer.innerHTML = '<p class="loading">Error loading projects. Please try again later.</p>';
    }
};

// Load projects when page loads
document.addEventListener('DOMContentLoaded', loadProjects);

// Custom cursor effect
const cursor = document.createElement('div');
cursor.className = 'custom-cursor';
document.body.appendChild(cursor);

const cursorDot = document.createElement('div');
cursorDot.className = 'custom-cursor-dot';
document.body.appendChild(cursorDot);

// Add cursor styles
const cursorStyle = document.createElement('style');
cursorStyle.textContent = `
    .custom-cursor {
        width: 30px;
        height: 30px;
        border: 2px solid rgba(139, 92, 246, 0.5);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.1s ease, width 0.3s ease, height 0.3s ease;
        transform: translate(-50%, -50%);
    }
    
    .custom-cursor-dot {
        width: 8px;
        height: 8px;
        background: rgba(139, 92, 246, 0.8);
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transform: translate(-50%, -50%);
    }
    
    .custom-cursor.hover {
        width: 50px;
        height: 50px;
        border-color: rgba(168, 85, 247, 0.8);
        background: rgba(168, 85, 247, 0.1);
    }
    
    body.dark-mode .custom-cursor {
        border-color: rgba(168, 85, 247, 0.6);
    }
    
    body.dark-mode .custom-cursor-dot {
        background: rgba(168, 85, 247, 1);
    }
    
    @media (max-width: 768px) {
        .custom-cursor, .custom-cursor-dot {
            display: none;
        }
    }
`;
document.head.appendChild(cursorStyle);

// Move cursor with mouse
document.addEventListener('mousemove', (e) => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top = e.clientY + 'px';
    cursorDot.style.left = e.clientX + 'px';
    cursorDot.style.top = e.clientY + 'px';
});

// Add hover effect to interactive elements
const interactiveElements = document.querySelectorAll('a, button, .project-card, .skill-card');
interactiveElements.forEach(el => {
    el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
    el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
});

// Parallax effect for hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero');
    if (hero) {
        const heroContent = hero.querySelector('.hero-content');
        const heroImage = hero.querySelector('.hero-image');
        
        if (heroContent) {
            heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
        }
        if (heroImage) {
            heroImage.style.transform = `translateY(${scrolled * 0.2}px)`;
        }
    }
});

// Scroll-triggered animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
            
            // Counter animation for stat numbers
            if (entry.target.classList.contains('stat-number')) {
                animateCounter(entry.target);
            }
        }
    });
}, observerOptions);

// Observe all sections and cards
document.querySelectorAll('.section, .skill-card, .project-card, .stat-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'all 0.6s ease';
    observer.observe(el);
});

// Add animate-in class styles dynamically
const style = document.createElement('style');
style.textContent = `
    .animate-in {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
`;
document.head.appendChild(style);

// Counter animation for stats
const animateCounter = (element) => {
    const target = parseInt(element.textContent);
    const duration = 2000;
    const step = target / (duration / 16);
    let current = 0;
    
    const counter = setInterval(() => {
        current += step;
        if (current >= target) {
            element.textContent = target + '+';
            clearInterval(counter);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
};

// Navbar scroll effect with enhanced styling
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 8px 16px -4px rgba(139, 92, 246, 0.2)';
        navbar.style.padding = '0.5rem 2rem';
    } else {
        navbar.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
        navbar.style.padding = '1rem 2rem';
    }
});