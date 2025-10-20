'use strict';

const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
const slideImages = document.getElementById('slider');
const getIndicator = document.querySelectorAll('.indicator');
const indicatorArray = Array.from(getIndicator);
let slideNumber = 3;
let isAnimating = false;

function next(nextIndiClick) {
  if (isAnimating) return;
  isAnimating = true;
  removeIndicator(slideNumber);
  slideNumber = slideNumber === 5 ? 1 : slideNumber + 1;
  let imgNum = ((slideNumber + 1) % 5) + 1;
  imgNum = imgNum === 0 ? 5 : imgNum;
  slideImages.insertAdjacentHTML('beforeend',
    `<li><img src="images/topGal${imgNum}.jpg"></li>`
  );
  slide(`translateX(-${getSlideWidth()}px)`);
  moveIndicator(slideNumber);
  const removeElement = document.querySelector('#slider li:first-child');
  slideAnimation(removeElement, 'next', nextIndiClick);
}

function prev(prevIndiClick) {
  if (isAnimating) return;
  isAnimating = true;
  removeIndicator(slideNumber);
  slideNumber = slideNumber === 1 ? 5 : slideNumber - 1;
  let imgNum = ((slideNumber + 2) % 5) + 1;
  imgNum = imgNum === 0 ? 5 : imgNum;
  slideImages.style.transition = 'none';
  slideImages.style.transform = `translateX(-${getSlideWidth()}px)`;
  slideImages.insertAdjacentHTML('afterbegin',
    `<li><img src="images/topGal${imgNum}.jpg"></li>`
  );
  slide(`translateX(0px)`);
  moveIndicator(slideNumber);
  const removeElement = document.querySelector('#slider li:last-child')
  slideAnimation(removeElement, 'prev', prevIndiClick);
}

//ウィンドウサイズによってスライド幅を決める関数
function getSlideWidth() {
  return window.innerWidth <= 768 ? 315 : 375;
}

//要素を追加した後のアニメーション処理
function slide(transition) {
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      slideImages.style.transition = 'transform 0.3s ease';
      slideImages.style.transform = transition;
    });
  });
}

function slideAnimation(removeElement, func, indicatorEvent) {
  slideImages.addEventListener('transitionend', function handler() {
    removeElement.remove();
    if(func === 'next') {
      slideImages.style.transition = 'none';
      slideImages.style.transform = 'translateX(0)';
    }
    slideImages.removeEventListener('transitionend', handler);
    isAnimating = false;
    if (typeof indicatorEvent === 'function') indicatorEvent();
  });
}


function moveIndicator(newSlideNumber) {
  slideNumber = newSlideNumber;
  indicatorArray[slideNumber - 1].classList.add('slActive');
}
function removeIndicator(slideNumber) {
  indicatorArray[slideNumber - 1].classList.remove('slActive');
}

//インジケータークリックでの移動
function indicatorClick() {
  indicatorArray.forEach((element, index) => {
    element.addEventListener('click', () => {
      autoSlideActive = false;
      let movePoint = slideNumber - (index + 1);
      function nextIndiClick() {
        if (movePoint < 0) {
          next(nextIndiClick);
          movePoint++;
        }
      }
      function prevIndiClick() {
        if (movePoint > 0) {
          prev(prevIndiClick);
          movePoint--;
        }
      }
      if (movePoint > 0) {
        prevIndiClick();
      } else if (movePoint < 0) {
        nextIndiClick();
      }
    });
  });
}
indicatorClick();

//ボタンにイベントを設定
prevBtn.addEventListener('click', function() {
  prev();
  autoSlideActive = false;
});
nextBtn.addEventListener('click', function() {
  next();
  autoSlideActive = false;
});

//自動でスライドする機能
let autoSlideActive = true;
let count = 0;
async function autoSlide() {
  while(count <= 10) {
    await sleep(4000);
    if(!autoSlideActive) {
      break;
    }
    next();
    count++;
  }
}
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
autoSlide();

//スワイプ
const carousel = document.getElementById('slider');
let startX = 0;
let currentX = 0;
let isDragging = false;

carousel.addEventListener('pointerdown', (e) => {
  startX = e.clientX;
  isDragging = true;
});

carousel.addEventListener('pointermove', (e) => {
  if (!isDragging) return;
  currentX = e.clientX;
});

carousel.addEventListener('pointerup', () => {
  handleSwipe();
  isDragging = false;
});

function handleSwipe() {
  const diff = currentX - startX;
  if (diff > 50) {
    prev();
  } else if (diff < -50) {
    next();
  }
}
