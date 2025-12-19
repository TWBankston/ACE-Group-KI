// Home page JavaScript
// Hero animations, featured projects

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
  // Hero animations
  const hero = document.querySelector('.hero');
  if (hero) {
    gsap.from(hero, {
      opacity: 0,
      y: 50,
      duration: 1,
      ease: 'power3.out',
    });
  }

  // Scroll-triggered animations
  gsap.utils.toArray('.fade-in').forEach((element) => {
    gsap.from(element, {
      opacity: 0,
      y: 30,
      scrollTrigger: {
        trigger: element,
        start: 'top 80%',
        toggleActions: 'play none none none',
      },
    });
  });
});

