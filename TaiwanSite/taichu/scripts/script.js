'use strict';

// モーダル開く
document.querySelectorAll('.modalbtn').forEach(button => {
  button.addEventListener('click', () => {
    const modalId = button.dataset.modal;
    document.getElementById(modalId).classList.add('active');
    document.body.classList.add('modalOpen');
  });
});
/*
document.querySelectorAll('.modalbtn2').forEach(button => {
  button.addEventListener('click', () => {
    const modalId = button.dataset.modal;
    document.getElementById(modalId).classList.add('active');
    document.body.classList.add('modalOpen');
  });
});
document.querySelectorAll('.modalbtn3').forEach(button => {
  button.addEventListener('click', () => {
    const modalId = button.dataset.modal;
    document.getElementById(modalId).classList.add('active');
    document.body.classList.add('modalOpen');
  });
});
document.querySelectorAll('.modalbtn4').forEach(button => {
  button.addEventListener('click', () => {
    const modalId = button.dataset.modal;
    document.getElementById(modalId).classList.add('active');
    document.body.classList.add('modalOpen');
  });
});
*/

// モーダル閉じる
document.querySelectorAll('.closeBtn').forEach(close => {
  close.addEventListener('click', () => {
    close.closest('.modalOverlay').classList.remove('active');
    document.body.classList.remove('modalOpen');
  });
});

// オーバーレイ（背景）クリックで閉じる
document.querySelectorAll('.modalOverlay').forEach(overlay => {
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      overlay.classList.remove('active');
      document.body.classList.remove('modalOpen');
    }
  });
});
