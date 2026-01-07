document.addEventListener('DOMContentLoaded', function() {
   // Открытие модального окна с картой
    const showMapButton = document.getElementById('show-map');
    const mapModal = document.getElementById('map-modal');
    const closeMapModal = document.getElementById('close-map-modal');
    
    showMapButton.addEventListener('click', function(e) {
        e.preventDefault();
        mapModal.style.display = 'flex';
    });
    
    // Закрытие модального окна с картой
    closeMapModal.addEventListener('click', function() {
        mapModal.style.display = 'none';
    });
    
    // Закрытие модального окна с картой при клике вне его
    mapModal.addEventListener('click', function(e) {
        if (e.target === mapModal) {
            mapModal.style.display = 'none';
        }
    });
    
    // Имитация загрузки данных квиза
    console.log('Страница квиза "Киномания: 90-е" загружена');
    
    // Добавление плавной прокрутки для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && href.startsWith('#')) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});