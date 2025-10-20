'use strict';
//ローディング
  const loadingWindow = document.getElementById('loading');
  const contentsWindow = document.getElementById('content');
    //アニメーションが終わったら
    loadingWindow.addEventListener('animationend', function() {
      loadingWindow.style.display = 'none';
      contentsWindow.style.display = 'block';
    });
    //画面をクリックしたら
    loadingWindow.addEventListener('click', function() {
      loadingWindow.style.display = 'none';
      contentsWindow.style.display = 'block';
    });

//ドロワー
  document.querySelector('.openBtn').addEventListener('click', function(){
    document.getElementById('drawerID').classList.toggle('show');
  });
  document.querySelector('.drawerCloseBtn').addEventListener('click', function(){
    document.getElementById('drawerID').classList.toggle('show');
  });


// トップへ戻るボタン
  document.addEventListener('DOMContentLoaded', () => {
    const backToTop = document.querySelector('.backToTop');
    const footer = document.querySelector('footer');

    function handleBackToTopPosition() {
      const windowHeight = window.innerHeight;
      const scrollY = window.scrollY || window.pageYOffset;
      const footerTop = footer.getBoundingClientRect().top + scrollY;
      const backToTopHeight = backToTop.offsetHeight;

      //フッターの上位置
      if (scrollY + windowHeight >= footerTop) {
        backToTop.classList.remove('fixed');
        backToTop.classList.add('stop');
      } else {
        backToTop.classList.remove('stop');
        backToTop.classList.add('fixed');
      }
    }

    window.addEventListener('scroll', handleBackToTopPosition);
    window.addEventListener('resize', handleBackToTopPosition);
    handleBackToTopPosition();
  });

