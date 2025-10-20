'use strict';

/* ＝＝＝＝＝ドロワー用＝＝＝＝＝ */
  document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.querySelector(".openBtn");
    const drawerPanel = document.getElementById("drawerID");
    const closeBtn = document.querySelector(".drawerCloseBtn");

    openBtn.addEventListener("click", () => {
      drawerPanel.classList.add("active");
    });

    closeBtn.addEventListener("click", () => {
      drawerPanel.classList.remove("active");
    });
  });

/* ＝＝＝＝＝クエリ削除＝＝＝＝＝ */
  if (window.location.search) {
    const url = new URL(window.location);
    url.search = '';
    window.history.replaceState({}, document.title, url);
  }





/* ＝＝＝＝＝会員登録の正誤判定用＝＝＝＝＝ */
  // document.addEventListener("DOMContentLoaded", function() {
  //   const form = document.querySelector(".cardFormCate");

  //   form.addEventListener("submit", function(e) {
  //     const email = document.getElementById("email").value;
  //     const emailConfirm = document.getElementById("emailConfirm").value;
  //     const password = document.getElementById("password").value;
  //     const passwordConfirm = document.getElementById("passwordConfirm").value;

  //     let errors = [];

  //     if (email !== emailConfirm) {
  //       errors.push("メールアドレスが一致しません。");
  //     }

  //     if (password !== passwordConfirm) {
  //       errors.push("パスワードが一致しません。");
  //     }

  //     if (errors.length > 0) {
  //       e.preventDefault(); // 送信中止
  //       alert(errors.join("\n"));
  //     }
  //   });
  // });
