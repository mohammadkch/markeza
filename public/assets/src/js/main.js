var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    on: {
        slideChange: function () {
            var caption = this.slides[this.activeIndex].getAttribute('data-caption');
            document.getElementById('slider-caption').innerText = caption;
        },
        init: function () {
            var caption = this.slides[this.activeIndex].getAttribute('data-caption');
            document.getElementById('slider-caption').innerText = caption;
        },
    },
});

  var swiper = new Swiper(".customer", {
    effect: "cube",
    grabCursor: true,
    cubeEffect: {
      shadow: true,
      slideShadows: true,
      shadowOffset: 4,
      shadowScale: 0.80,
    },
    pagination: {
      el: ".swiper-pagination",
    },
  });

  var swiper = new Swiper(".partners", {
    slidesPerView: 2,
    spaceBetween: 10,
    loop: true,
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 50,
      },
    },
    
  });

  var swiper = new Swiper(".gall-project", {
    spaceBetween: 10,
    slidesPerView: 3,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      640: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
    },
  });

var swiper2 = new Swiper(".project-main", {
    spaceBetween: 10,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper,
    },
});

  var swiper = new Swiper(".sin-project", {
    slidesPerView: 1,
    spaceBetween: 20,
    autoplay: {
        delay: 5000,
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 15,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 15,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 15,
        },
      },
  });

  function showTab(tabId) {
    // Hide all tab content
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach((content) => {
      content.classList.add('hidden');
    });

    // Show the selected tab content
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
      selectedTab.classList.remove('hidden');
    }

    // Remove the 'active' class from all tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach((button) => {
      button.classList.remove('active');
    });

    // Add the 'active' class to the clicked tab button
    const clickedButton = document.querySelector(`[onclick="showTab('${tabId}')"]`);
    if (clickedButton) {
      clickedButton.classList.add('active');
    }
  }

  // Initialize the first tab
  showTab('tab1');


   // Get the 'to top' button element by ID
   var toTopButton = document.getElementById("to-top-button");

   // Check if the button exists
   if (toTopButton) {

       // On scroll event, toggle button visibility based on scroll position
       window.onscroll = function() {
           if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
               toTopButton.classList.remove("hidden");
           } else {
               toTopButton.classList.add("hidden");
           }
       };

       // Function to scroll to the top of the page smoothly
       window.goToTop = function() {
           window.scrollTo({
               top: 0,
               behavior: 'smooth'
           });
       };
   }

// Product gallery swiper
if (document.querySelector('.product-main')) {
    var productThumb = new Swiper('.gall-product', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });

    var productMain = new Swiper('.product-main', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: productThumb,
        },
    });
}

// Related products swiper (without autoplay)
if (document.querySelector('.related-products')) {
    var relatedProducts = new Swiper('.related-products', {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });
}

// About gallery swiper (like collection page)
if (document.querySelector('.about-main')) {
    var aboutThumb = new Swiper('.about-thumb', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });

    var aboutMain = new Swiper('.about-main', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: aboutThumb,
        },
    });
}