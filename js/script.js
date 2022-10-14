jQuery(function($) {
"usestrict";
  const $win = $(window),
    $header = $("#header");

     //ハンバーガーボタン
  //連打防止フラグ
  let $cancelFlag = 0;
  $("#hamburger").on("click", function () {
    if ($cancelFlag == 0) {
      $cancelFlag = 1;
      $(".hamburger__bar").toggleClass("bar-active");
      $("#g-nav").fadeToggle();
      $('#overlay').fadeToggle();
      setTimeout(function () {
        $cancelFlag = 0;
        //300ms後に解除
      }, 300);
    }
  });

    //スティッキーヘッダー
    $win.on('load scroll', function () {
      thisOffset = $('#fv').offset().top + $('#fv').outerHeight();
      //scrolltopがターゲット要素を超えたら
      if ($win.scrollTop() > thisOffset) {
        $header.addClass('sticky');
      } else {
        $header.removeClass('sticky');
      }
    });

    //スクロールアニメーションプラグインなし
    // $(window).scroll(function () {
    //   const windowHeight = $(window).height();
    //   const scroll = $(window).scrollTop();
     
  
    //   $('.element').each(function () {
    //     const targetPosition = $(this).offset().top;
    //     if (scroll > targetPosition - windowHeight + 100) {
    //       $(this).addClass("is-fadein");
    //     }
    //   });
    // });

    //タブ切り替え（上のボタン）
  $(".tab-area__btn").on("click", function () {
    let index = $(".tab-area__btn").index(this);
    $(".tab-area__btn, .tab-area__menu").removeClass("tab-active");
    $(this).addClass("tab-active");
    $(".tab-area__menu").eq(index).addClass("tab-active");
  });

    //ナビゲーションのカレント処理
  let set = 200;//ウインドウ上部からどれぐらいの位置で変化させるか
  let boxTop = new Array;
  let current = -1;
  //各要素の位置
  //position-nowは場所を取得したい対象の要素に付ける
  $('.position-now').each(function (i) {
    boxTop[i] = $(this).offset().top;
  });
  //最初の要素にclass="positiion-now"をつける
  changeBox(0);
  //スクロールした時の処理
  $(window).scroll(function () {
    scrollPosition = $(window).scrollTop();
    for (let i = boxTop.length - 1; i >= 0; i--) {
      if ($(window).scrollTop() > boxTop[i] - set) {
        changeBox(i);
        break;
      }
    };
  });
  //ナビの処理
  function changeBox(secNum) {
    if (secNum != current) {
      current = secNum;
      secNum2 = secNum + 1;//以下にクラス付与したい要素名と付与したいクラス名
      $('.header__nav-sp-item').removeClass('link-current');

      //位置によって個別に処理をしたい場合
      if (current == 0) {
        $('#top_link_js').addClass('link-current');
        // 現在地がsection1の場合の処理
      } else if (current == 1) {
        $('#services_link_js').addClass('link-current');
        // 現在地がsection2の場合の処理
      } else if (current == 2) {
        // 現在地がsection3の場合の処理
        $('#about_link_js').addClass('link-current');
      }
      else if (current == 3) {
        // 現在地がsection4の場合の処理
        $('#works_link_js').addClass('link-current');
      }
      else if (current == 4) {
        // 現在地がsection4の場合の処理
        $('#recruit_link_js').addClass('link-current');
      }
      else if (current == 5) {
        // 現在地がsection4の場合の処理
        $('#contact_link_js').addClass('link-current');
      }

    }
  };
});

    //ローダー
    //読み込みが完了したら実行
$(window).on('load',function () {
  endLoading();
});

//10秒経過した段階で、上記の処理を上書き、強制終了
setTimeout('endLoading()', 8000);

function endLoading(){
  // 1秒かけてロゴを非表示にし、その後0.8秒かけて背景を非表示にする
  $('.js-loading img').fadeOut(800, function(){
    $('.js-loading').fadeOut(600);
  });
}

  //スライダー
  // $("#fv__slider").slick({
  //   arrows: false,
  //   dots: false,
  //   autoplay: true,
  //   autoplaySpeed: 3000,
  //   speed: 2000,
  //   fade: true,
  //   pauseOnFocus: false,
  //   pauseOnHover: false,
  //   pauseOnDotsHover: false,
  // });

  //スライダー無限ループver
  // $("#slider").slick({
  //   arrows: false,
  //   dots: false,
  //   autoplay: true,
  //   autoplaySpeed: 0,
  //   speed: 55000,
  //   fade: false,
  //   loop: true,
  //   cssEase: "linear",
  //   pauseOnFocus: false,
  //   pauseOnHover: false,
  //   pauseOnDotsHover: false,
  // });


  //スクロールアニメーション htmlにデータ属性をつける hdata-aos="fade-up fade-left "などで指定
  AOS.init({
    duration: 600,
    easing: 'ease-in',
    once:true
  });

 



// //ハンバーガーボタン画像ver
// //連打防止フラグ
// let $cancelFlag = 0;
// $("#hamburger__btn").on("click", function () {
//   if ($cancelFlag == 0) {
//     $cancelFlag = 1;
//     let $src = $(".hamburger__img").attr("src");
//     if ($src == "image/hamburger.png") {
//       $(".hamburger__img").attr("src", "image/hamburger-close.png");
//       $("#g-nav").addClass("nav-active");
//     }
//     if ($src == "image/hamburger-close.png") {
//       $(".hamburger__img").attr("src", "image/burger-btn.png");
//       $("#g-nav").removeClass("nav-active");
//     }

//     setTimeout(function () {
//       $cancelFlag = 0;
//       //300ms後に解除
//     }, 300);
//   }
// });

//スムーススクロール
$(function () {
  $('a[href^="#"]').click(function () {
    let adjust = -100;
    let speed = 500;
    let href = $(this).attr("href");
    let target = $(href == "#" || href == "" ? "html" : href);
    let position = target.offset().top + adjust;
    $("html, body").animate({ scrollTop: position }, speed, "swing");
    return false;
  });
});

