'use strict';


// // ナビリンクだけを対象にする
//   document.querySelectorAll('header .dropdown-menu li a').forEach(anchor => {
//     anchor.addEventListener('click', function(e) {
//       e.preventDefault();
//       const targetId = this.getAttribute('href');
//       const targetElement = document.querySelector(targetId);
//       const offset = 50;
//       const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
//       const scrollPosition = elementPosition - offset;

//       window.scrollTo({
//         top: scrollPosition,
//         behavior: 'smooth'
//       });
//     });
//   });

  // ===== PC版クリックで開閉 =====
    const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

    dropdownToggles.forEach(toggle => {
      toggle.addEventListener("click", (e) => {
        e.preventDefault();

        const parentLi = toggle.parentElement;

        // 他のドロップダウンを閉じる
        document.querySelectorAll(".dropdown.open").forEach(openDropdown => {
          if (openDropdown !== parentLi) {
            openDropdown.classList.remove("open");
          }
        });

        // 自分のドロップダウンを開閉
        parentLi.classList.toggle("open");
      });
    });

    // クリックで外側を押したら閉じる
    document.addEventListener("click", (e) => {
      if (!e.target.closest(".dropdown")) {
        document.querySelectorAll(".dropdown.open").forEach(openDropdown => {
          openDropdown.classList.remove("open");
        });
      }
    });



  // メニューリンククリックで閉じる
  document.querySelectorAll('#navMenu a').forEach(link => {
    link.addEventListener('click', () => {
      if (navMenu.classList.contains('active')) {
        navMenu.classList.remove('active');
        hamburger.classList.remove('active');
      }
    });
  });



// タイピングライター風アニメーション
  async function typing({ target, speed, word }) {
    for (const obj of word) {
      const text = Object.keys(obj)[0]; // 表示する最終文字列
      const sequences = Object.values(obj)[0]; // タイピング過程の配列
      
      const span = document.createElement('span');
      target.appendChild(span);

      for (const seq of sequences) {
        for (let i = 0; i < seq.length; i++) {
          span.textContent += seq[i] === "\n" ? "\n" : seq[i];
          await wait(speed);
        }
        span.textContent = seq.join("").replace("\n", "\n");
        await wait(speed);
      }
    }
    // 全文表示後にカーソルを削除
    target.style.borderRight = "none";
  }

  // 待機用の関数
  function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
  }

  // 表示文字列定義
  const obj1 = { "Welcome ": [["W","e","l","c","o","m","e"," "]] };
  const obj2 = { "To ": [["T","o"," "]] };
  const obj3 = { "\nMy ": [["\n","M","y"," "]] };
  const obj4 = { "Portfolio ": [["P","o","r","t","f","o","l","i","o"," "]] };
  const obj5 = { "\n ": [["\n"]] };
  const obj6 = { "Website": [["W","e","b","s","i","t","e"]] };

  const typingString = [obj1, obj2, obj3, obj4, obj5, obj6];

  // ページ読み込み時に自動スタート
  window.addEventListener("DOMContentLoaded", () => {
    const isMobile = window.innerWidth <= 768;
    const typingStringFiltered = isMobile
      ? typingString.filter(obj => obj !== obj2)
      : typingString.filter(obj => obj !== obj5);

    typing({
      target: document.getElementById("typing_text"),
      speed: 100,
      word: typingStringFiltered
    });
  });




// // Intersection Observer でセクション表示制御
//   const sections = document.querySelectorAll("section");
//   const observer = new IntersectionObserver((entries) => {
//     entries.forEach(entry => {
//       if (entry.isIntersecting) {
//         entry.target.classList.add("visible");
//       } else {
//         entry.target.classList.remove("visible");
//       }
//     });
//   }, { threshold: 0.02 });

//   sections.forEach(section => observer.observe(section));


// Intersection Observerでフェードイン制御
  document.addEventListener("DOMContentLoaded", () => {
    const options = {
      threshold: 0.2
    };

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          if (entry.target.classList.contains("schoolSec1")) {
            entry.target.classList.add("animate-left");
          } else if (entry.target.classList.contains("schoolSec2")) {
            entry.target.classList.add("animate-right");
          }
          obs.unobserve(entry.target); // 一度アニメーションしたら監視を解除
        }
      });
    }, options);

    document.querySelectorAll(".fade-element").forEach(el => {
      observer.observe(el);
    });
  });

  // Intersection Observerでフェードイン制御
  document.addEventListener("DOMContentLoaded", () => {
    const options = {
      threshold: 0.2
    };

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          if (entry.target.classList.contains("PersonalSec1")) {
            entry.target.classList.add("animate-left");
          } else if (entry.target.classList.contains("PersonalSec2")) {
            entry.target.classList.add("animate-right");
          }
          obs.unobserve(entry.target); // 一度アニメーションしたら監視を解除
        }
      });
    }, options);

    document.querySelectorAll(".fade-element").forEach(el => {
      observer.observe(el);
    });
  });



// About タイムラインの表示アニメーション
  const timelineItems = document.querySelectorAll('.timeline-item');
  const timelineObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      } else {
        entry.target.classList.remove("visible");
      }
    });
  }, { threshold: 0.2 });

  timelineItems.forEach(item => timelineObserver.observe(item));

// Contact 住所欄自動入力
  async function searchAddress() {
    const rawZip = document.getElementById("zipcode").value;
    const zipcode = rawZip.replace(/[^0-9]/g, ""); // 数字以外削除

    if (!/^\d{7}$/.test(zipcode)) {
      showError("郵便番号は7桁の数字で入力してください。");
      return;
    }
    clearError();

    try {
      const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zipcode}`);
      const data = await response.json();

      if (data.status === 200 && data.results) {
        const result = data.results[0];
        document.getElementById("prefecture").value = result.address1;
        document.getElementById("city").value = result.address2;
        document.getElementById("town").value = result.address3;
      } else {
        showError(data.message || "住所が見つかりませんでした。");
      }
    } catch (error) {
      showError("通信エラーが発生しました。");
      console.error(error);
    }
  }

  // エラーメッセージ表示用（最低限の実装）
  function showError(message) {
    alert(message);
  }
  function clearError() {
    // ここでエラーメッセージを消す処理を書く
  }

  // const prefectures = [
  //   "北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県",
  //   "茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県",
  //   "新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県",
  //   "静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県",
  //   "奈良県","和歌山県","鳥取県","島根県","岡山県","広島県","山口県",
  //   "徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県",
  //   "熊本県","大分県","宮崎県","鹿児島県","沖縄県"
  // ];

  // // セレクトに都道府県を追加
  // const select = document.getElementById("prefecture");
  // prefectures.forEach(pref => {
  //   const option = document.createElement("option");
  //   option.value = pref;
  //   option.textContent = pref;
  //   select.appendChild(option);
  // });

  // // 郵便番号検索
  // async function searchAddress() {
  //   const rawZip = document.getElementById("zipcode").value;
  //   const zipcode = rawZip.replace(/-/g, "").trim(); // ハイフン削除

  //   if (!/^\d{7}$/.test(zipcode)) {
  //     showError("郵便番号は7桁の数字で入力してください。");
  //     return;
  //   }
  //   clearError();

  //   try {
  //     const response = await fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zipcode}`);
  //     const data = await response.json();

  //     if (data.results) {
  //       const result = data.results[0];
  //       document.getElementById("prefecture").value = result.address1;
  //       document.getElementById("city").value = result.address2;
  //       document.getElementById("town").value = result.address3;
  //     } else {
  //       showError("住所が見つかりませんでした。");
  //     }
  //   } catch (error) {
  //     showError("通信エラーが発生しました。");
  //     console.error(error);
  //   }
  // }




//ドロワー
  function drawer(){
    const drawerOpenBtn = document.querySelector('.drawerOpenBtn');
    const drawerClose = document.querySelector('.drawerCloseBtn');
    const drawerID = document.getElementById('drawerID');
    const menuText = document.querySelector('.openText');
    const drawerOpens = [drawerOpenBtn, menuText];

    // 開く処理
    // drawerOpens.addEventListener('click', function(){
    drawerOpens.forEach(target => {
      target.addEventListener('click', function(){
        drawerOpenBtn.classList.remove('rotate-in');
        drawerOpenBtn.classList.add('rotate-out');

        // テキストもアニメーション
        menuText.classList.remove('closeAnimate');
        menuText.classList.add('openAnimate');

        setTimeout(() => {
          drawerID.classList.add('drawerShow');
          drawerOpenBtn.style.display = 'none';
        }, 300); 
      });
    });

    // 閉じる処理
    drawerClose.addEventListener('click', function(){
      // drawerID.classList.remove('drawerShow');
      // drawerOpen.style.display = 'block';
      drawerOpenBtn.classList.remove('rotate-out');
      drawerOpenBtn.classList.add('rotate-in');

      setTimeout(() => {
        // テキストもアニメーション
        menuText.classList.remove('openAnimate');
        menuText.classList.add('closeAnimate');
        drawerID.classList.remove('drawerShow');
        drawerOpenBtn.style.display = 'block';
      }, 300); // アニメーション完了後に非表示
    });
  };
  drawer();




// トップへ戻るボタン制御
  const backToTop = document.getElementById("backToTop");
  const footer = document.querySelector("footer");

  window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      backToTop.classList.add("show");
    } else {
      backToTop.classList.remove("show");
    }

    const footerRect = footer.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    if (footerRect.top < windowHeight) {
      const overlap = windowHeight - footerRect.top;
      backToTop.style.bottom = `${30 + overlap}px`;
    } else {
      backToTop.style.bottom = "30px";
    }
  });

  backToTop.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth"
    });
  });

