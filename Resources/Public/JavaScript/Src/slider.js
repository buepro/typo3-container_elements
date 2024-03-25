;(function () {
    document.querySelectorAll('.ce-slider').forEach(slider => {
        const config = {};
        const uid = slider.dataset.ceUid;
        const userConfig = JSON.parse(slider.dataset.ceConfig);
        if ( slider.dataset.ceShowPagination ) {
            config.pagination = {
                el: '#ce-slider-pagination-' + uid,
                clickable: true,
            };
        }
        if ( slider.dataset.ceShowNavigation ) {
            config.navigation = {
                nextEl: '#ce-slider-next-' + uid,
                prevEl: '#ce-slider-prev-' + uid
            };
        }
        new Swiper('.ce-slider.swiper', Object.assign(config, userConfig));
    })
}());
