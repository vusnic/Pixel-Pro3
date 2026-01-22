import './bootstrap';

// Inicialização da animação do navbar no scroll
const navbarAnimation = () => {
  const navScroll = document.getElementById('navScroll');
  // Verificar se o elemento existe para evitar erros
  if (navScroll) {
    // Detectar o scroll e aplicar a classe
    if (window.scrollY > 30) {
      navScroll.classList.add('navbar-scrolled');
    } else {
      navScroll.classList.remove('navbar-scrolled');
    }
  }
};

// Admin Sidebar TreeView - Removido e substituído por código inline no sidebar.blade.php

// Importar o componente de formulário de lead
import LeadForm from './components/LeadForm';

document.addEventListener('DOMContentLoaded', () => {
  const themeSwitcher = document.getElementById('themeSwitcher');
  const themeSwitcherMobile = document.getElementById('themeSwitcherMobile');

  if (themeSwitcher && themeSwitcherMobile) {
    // Ocultar os botões de troca de tema
    themeSwitcher.style.display = 'none';
    themeSwitcherMobile.style.display = 'none';
    
    const applyTheme = (theme) => {
      const html = document.documentElement;
      html.setAttribute('data-bs-theme', theme);
      
      if (theme === 'light') {
        try {
          // Replace dark classes with light classes
          document.querySelectorAll('.bg-dark').forEach(el => {
            if (el.classList.contains('bg-dark')) {
              el.classList.remove('bg-dark');
              el.classList.add('bg-light');
            }
          });
          
          document.querySelectorAll('.text-white').forEach(el => {
            if (el.classList.contains('text-white')) {
              el.classList.remove('text-white');
              el.classList.add('text-dark');
            }
          });
          
          document.querySelectorAll('.btn-outline-light').forEach(el => {
            if (el.classList.contains('btn-outline-light')) {
              el.classList.remove('btn-outline-light');
              el.classList.add('btn-outline-dark');
            }
          });
          
          document.querySelectorAll('.border-light').forEach(el => {
            if (el.classList.contains('border-light')) {
              el.classList.remove('border-light');
              el.classList.add('border-dark');
            }
          });
          
          document.querySelectorAll('.btn-close-white').forEach(el => {
            if (el.classList.contains('btn-close-white')) {
              el.classList.remove('btn-close-white');
              el.classList.add('btn-close-dark');
            }
          });
          
          document.querySelectorAll('.btn-light').forEach(el => {
            if (el.classList.contains('btn-light')) {
              el.classList.remove('btn-light');
              el.classList.add('btn-dark');
            }
          });
          
          document.querySelectorAll('.navbar-dark').forEach(el => {
            if (el.classList.contains('navbar-dark')) {
              el.classList.remove('navbar-dark');
              el.classList.add('navbar-light');
            }
          });
          
          // Adicionar troca da classe link-fancy-light para link-fancy
          document.querySelectorAll('.link-fancy-light').forEach(el => {
            if (el.classList.contains('link-fancy-light')) {
              el.classList.remove('link-fancy-light');
              el.classList.add('link-fancy');
            }
          });
          
          // Alterar o sublinhado dos links para usar a cor terciária
          const style = document.createElement('style');
          style.id = 'link-fancy-custom-style';
          style.textContent = `
            .link-fancy:before {
              background-image: linear-gradient(90deg, rgb(226, 48, 198) 0, rgb(226, 48, 198) 25%, transparent 0, transparent 50%, rgb(226, 48, 198) 0, rgb(226, 48, 198) 75%, transparent 0, transparent) !important;
            }
          `;
          document.head.appendChild(style);
          
          // Change logos
          document.querySelectorAll('.navLogo').forEach(el => {
            el.setAttribute('src', '/img/nav-brand-logo-black.svg');
          });
        } catch (error) {
          console.error("Error loading theme:", error);
        }
      } else {
        try {
          // Replace light classes with dark classes
          document.querySelectorAll('.bg-light').forEach(el => {
            if (el.classList.contains('bg-light')) {
              el.classList.remove('bg-light');
              el.classList.add('bg-dark');
            }
          });
          
          document.querySelectorAll('.text-dark').forEach(el => {
            if (el.classList.contains('text-dark')) {
              el.classList.remove('text-dark');
              el.classList.add('text-white');
            }
          });
          
          document.querySelectorAll('.btn-outline-dark').forEach(el => {
            if (el.classList.contains('btn-outline-dark')) {
              el.classList.remove('btn-outline-dark');
              el.classList.add('btn-outline-light');
            }
          });
          
          document.querySelectorAll('.border-dark').forEach(el => {
            if (el.classList.contains('border-dark')) {
              el.classList.remove('border-dark');
              el.classList.add('border-light');
            }
          });
          
          document.querySelectorAll('.btn-close-dark').forEach(el => {
            if (el.classList.contains('btn-close-dark')) {
              el.classList.remove('btn-close-dark');
              el.classList.add('btn-close-white');
            }
          });
          
          document.querySelectorAll('.btn-dark').forEach(el => {
            if (el.classList.contains('btn-dark')) {
              el.classList.remove('btn-dark');
              el.classList.add('btn-light');
            }
          });
          
          document.querySelectorAll('.navbar-light').forEach(el => {
            if (el.classList.contains('navbar-light')) {
              el.classList.remove('navbar-light');
              el.classList.add('navbar-dark');
            }
          });
          
          // Trocar link-fancy para link-fancy-light
          document.querySelectorAll('.link-fancy').forEach(el => {
            if (el.classList.contains('link-fancy') && !el.classList.contains('link-fancy-light')) {
              el.classList.add('link-fancy-light');
            }
          });
          
          // Remover estilo personalizado do link fancy
          const customStyle = document.getElementById('link-fancy-custom-style');
          if (customStyle) {
            customStyle.remove();
          }
          
          // Change logos
          document.querySelectorAll('.navLogo').forEach(el => {
            el.setAttribute('src', '/img/nav-brand-logo.svg');
          });
        } catch (error) {
          console.error("Error applying theme:", error);
        }
      }

      // Dispatch a custom event to notify that the theme was applied
      document.dispatchEvent(new CustomEvent('themeApplied', { 
        detail: { theme: theme } 
      }));
    };

    // Detectar preferência do sistema e aplicar tema
    const prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    
    // Aplicar o tema baseado na preferência atual do sistema
    applyTheme(prefersDarkMode.matches ? 'dark' : 'light');
    
    // Detectar mudanças nas preferências do sistema enquanto o site está aberto
    prefersDarkMode.addEventListener('change', e => {
      const systemTheme = e.matches ? 'dark' : 'light';
      applyTheme(systemTheme);
    });
  }

  // Inicializar formulários de lead
  const initLeadForms = () => {
    // Formulário da página de contato
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
      new LeadForm('contactForm', {
        submitButtonDefaultText: 'Submit',
        successMessage: 'Thank you for your message! We will contact you soon.',
        validationRules: {
          name: ['required'],
          email: ['required', 'email'],
          phone: ['phone'],
          website: ['url'],
          message: []
        }
      });
    }

    // Formulário da página inicial
    const homeLeadForm = document.getElementById('leadForm');
    if (homeLeadForm) {
      new LeadForm('leadForm', {
        submitButtonDefaultText: `<span>Get Started</span>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
          </svg>`,
        submitButtonLoadingText: `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          <span>Sending...</span>`,
        successMessage: 'Thank you for your interest! We will contact you soon.',
        validationRules: {
          name: ['required'],
          email: ['required', 'email'],
          phone: ['phone']
        }
      });
    }
  };

  // Inicializar os formulários de lead
  initLeadForms();

  // Inicializar o navbar animation
  window.addEventListener('scroll', navbarAnimation);
  navbarAnimation();
});

// Helper function for asset paths
function asset_path(path) {
  // Remove leading slash if exists
  if (path.startsWith('/')) {
    path = path.substring(1);
  }
  return path;
}

// Lazy Loading de Imagens
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar AOS (Animate on Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: false,
            mirror: false,
            disable: window.innerWidth < 768 // Desabilitar em dispositivos móveis
        });
    }
    
    // Inicializar Swiper se existir na página
    if (typeof Swiper !== 'undefined' && document.querySelector('.portfolio-slider .swiper-container')) {
        new Swiper('.portfolio-slider .swiper-container', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.portfolio-slider .swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.portfolio-slider .swiper-button-next',
                prevEl: '.portfolio-slider .swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            }
        });
    }
    
    // Implementar lazy loading para imagens
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    // Configuração do Intersection Observer
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                
                // Se tiver data-srcset, também atualizar
                if (img.dataset.srcset) {
                    img.srcset = img.dataset.srcset;
                }
                
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px 0px',
        threshold: 0.01
    });
    
    // Observar todas as imagens
    lazyImages.forEach(img => {
        imageObserver.observe(img);
    });
    
    // Adicionar classe .loaded para animação de imagens carregadas
    document.querySelectorAll('.img-lazy').forEach(img => {
        if (img.complete) {
            img.classList.add('loaded');
        } else {
            img.addEventListener('load', function() {
                this.classList.add('loaded');
            });
        }
    });
});

// Otimização de scroll
let scrollTimeout;
window.addEventListener('scroll', function() {
    if (!scrollTimeout) {
        window.requestAnimationFrame(function() {
            // Seu código de scroll otimizado aqui
            scrollTimeout = null;
        });
        scrollTimeout = true;
    }
}, { passive: true });

// Atualizar AOS quando a janela for redimensionada
window.addEventListener('resize', function() {
    if (typeof AOS !== 'undefined') {
        setTimeout(() => {
            AOS.refresh();
        }, 100);
    }
}, { passive: true });

// Função para detecção de modo escuro do sistema
function detectDarkMode() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

// Definir tema com base na preferência do sistema
function setThemeBasedOnSystem() {
    // Não aplicar mudança automática de tema se estivermos na área admin
    if (window.location.pathname.startsWith('/admin')) {
        return; // Sair sem fazer nada na área admin
    }
    
    if (detectDarkMode()) {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-bs-theme', 'light');
    }
}

// Inicializar tema apenas se não estivermos na área admin
if (!window.location.pathname.startsWith('/admin')) {
    setThemeBasedOnSystem();
    
    // Alternar tema quando a preferência do sistema mudar
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', setThemeBasedOnSystem);
}

// Expor funções ao escopo global
window.setThemeBasedOnSystem = setThemeBasedOnSystem;

