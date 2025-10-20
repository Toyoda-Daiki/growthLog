'use strict';

document.addEventListener('DOMContentLoaded', () => {
  const modalOverlay = document.getElementById('modalTemplate');
  const modalImg = document.getElementById('modalImg');
  const closeBtn = modalOverlay.querySelector('.closeBtn');

  // 「画像を見る」ボタン全てにイベント登録
  document.querySelectorAll('.modalBtn').forEach(button => {
    button.addEventListener('click', () => {
      const imgPath = button.getAttribute('data-img');
      modalImg.src = imgPath;
      modalOverlay.style.display = 'flex'; // 表示
      document.body.classList.add('modalOpen');
    });
  });

  // 閉じるボタンで閉じる
  closeBtn.addEventListener('click', () => {
    modalOverlay.style.display = 'none';
    modalImg.src = ''; // 画像をリセット（省略可能）
    document.body.classList.remove('modalOpen');
  });

  // 背景クリックでも閉じる
  modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) {
      modalOverlay.style.display = 'none';
      modalImg.src = '';
      document.body.classList.remove('modalOpen');
    }
  });
});
