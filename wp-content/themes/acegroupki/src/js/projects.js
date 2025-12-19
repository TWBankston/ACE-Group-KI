// Projects page JavaScript
// Swiper gallery, filters

import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';

document.addEventListener('DOMContentLoaded', () => {
  // Initialize Swiper for project gallery
  const projectSwiper = document.querySelector('.project-swiper');
  if (projectSwiper) {
    new Swiper('.project-swiper', {
      modules: [Navigation, Pagination],
      slidesPerView: 1,
      spaceBetween: 30,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
        },
        992: {
          slidesPerView: 3,
        },
      },
    });
  }

  // Project filters
  const filterButtons = document.querySelectorAll('.project-filter');
  filterButtons.forEach((button) => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      const filter = button.dataset.filter;
      // Filter logic will be implemented
      console.log('Filter:', filter);
    });
  });
});

