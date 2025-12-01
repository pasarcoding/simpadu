$(document).ready(function () {
    $(".banner").slick({
        arrows: false,
    });

    $(".banner + .btn-nav-slick .btn-nav-slick-prev").click(function (e) {
        e.preventDefault();
        $(".banner").slick("slickPrev");
    });

    $(".banner + .btn-nav-slick .btn-nav-slick-next").click(function (e) {
        e.preventDefault();
        $(".banner").slick("slickNext");
    });

    //   const civilStatisticConfig = {
    //     type: "doughnut",
    //     data: {
    //       labels: ["Laki Laki", "Perempuan"],
    //       datasets: [
    //         {
    //           // label: "Nilai Data",
    //           data: [250, 300],
    //           backgroundColor: ["rgb(255, 99, 132)", "rgb(255, 205, 86)"],
    //           hoverOffset: 4,
    //         },
    //       ],
    //     },
    //     options: {
    //       responsive: true,
    //       maintainAspectRatio: false,
    //       plugins: {
    //         legend: {
    //           position: "bottom",
    //           labels: {
    //             usePointStyle: true,
    //             pointStyle: "rect",
    //           },
    //         },
    //         title: {
    //           display: false,
    //           text: "Data Penduduk",
    //         },
    //       },
    //       cutout: "15%",
    //     },
    //   };

    //   const civilStatistic = document.getElementById("civilStatistic");
    //   window.civilStatisticChart = new Chart(civilStatistic, civilStatisticConfig);

    function getFormattedDateNow() {
        const today = new Date();

        let day = today.getDate();
        let month = today.getMonth() + 1;
        let year = today.getFullYear();

        day = String(day).padStart(2, "0");
        month = String(month).padStart(2, "0");
        const formattedDate = `${day}-${month}-${year}`;

        return formattedDate;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                $.get(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}&zoom=10&addressdetails=1`
                )
                    .then((res) => {
                        $.get(
                            `https://api.aladhan.com/v1/timingsByAddress/${getFormattedDateNow()}?address=${res.display_name}&method=8`
                        )
                            .then((res) => {
                                const data = res.data.timings;
                                $("#pray-schedule-imsak").text(data.Imsak);
                                $("#pray-schedule-subuh").text(data.Fajr);
                                $("#pray-schedule-dzuhur").text(data.Dhuhr);
                                $("#pray-schedule-ashar").text(data.Asr);
                                $("#pray-schedule-maghrib").text(data.Maghrib);
                                $("#pray-schedule-isya").text(data.Isha);
                            })
                            .catch((err) => {
                                console.log(err);
                            });
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            },
            function () {
                alert("Sorry, no position available.");
            }
        );
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    $(".village-structure").slick({
        arrows: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
        ],
    });

    $(".village-structure + .btn-nav-slick .btn-nav-slick-prev").click(
        function (e) {
            e.preventDefault();
            $(".village-structure").slick("slickPrev");
        }
    );

    $(".village-structure + .btn-nav-slick .btn-nav-slick-next").click(
        function (e) {
            e.preventDefault();
            $(".village-structure").slick("slickNext");
        }
    );

    $(".news").slick({
        arrows: false,
        slidesToShow: 2,
        slidesToScroll: 1,
    });

    $(".news + .btn-nav-slick .btn-nav-slick-prev").click(function (e) {
        e.preventDefault();
        $(".news").slick("slickPrev");
    });

    $(".news + .btn-nav-slick .btn-nav-slick-next").click(function (e) {
        e.preventDefault();
        $(".news").slick("slickNext");
    });

    function getResponsiveRowHeight() {
        if (window.matchMedia("(min-width: 1024px)").matches) {
            return 200; // Desktop
        } else if (window.matchMedia("(min-width: 768px)").matches) {
            return 150; // Tablet
        } else {
            return 100; // Mobile
        }
    }

    function setupGallery() {
        const newRowHeight = getResponsiveRowHeight();
        const $gallery = $(".grider");

        if ($gallery.data("jg.initialized")) {
            $gallery.justifiedGallery("destroy");
        }

        $gallery.justifiedGallery({
            rowHeight: newRowHeight,
            randomize: true,
            captions: false,
            margins: 10,
        });

        $gallery.data("jg.initialized", true);
    }

    setupGallery();

    let galleryResizeTimer;
    //   let chartCivilCountResizeTimer;
    $(window).on("resize", function () {
        clearTimeout(galleryResizeTimer);
        galleryResizeTimer = setTimeout(setupGallery, 150);

        // clearTimeout(chartCivilCountResizeTimer);
        // chartCivilCountResizeTimer = setTimeout(function () {
        //   if (window.civilStatisticChart) {
        //     window.civilStatisticChart.destroy();
        //   }
        //   window.civilStatisticChart = new Chart(
        //     civilStatistic,
        //     civilStatisticConfig
        //   );
        // }, 150);
    });

    // const totalIn = parseInt(10000);
    // const totaOut = parseInt(7000);

    // let progressRatio = 0;
    // if (totalIn > 0) {
    //     progressRatio = totaOut / totalIn;
    // }
    // progressRatio = Math.min(progressRatio, 1);

    // let colorCode = "#15aa3d";
    // if (progressRatio >= 0.7) {
    //     colorCode = "#DC3545";
    // } else if (progressRatio >= 0.5) {
    //     colorCode = "#FFC107";
    // }

    //   var budgetProgress = new ProgressBar.Circle("#progress-container1", {
    //     color: colorCode,
    //     trailColor: "#e0e0e0",
    //     strokeWidth: 4,
    //     trailWidth: 4,
    //     easing: "easeInOut",
    //     duration: 1400,
    //     strokeLinecap: "round",
    //   });
    //   budgetProgress.set(progressRatio);

    $(".integration-goverment").slick({
        arrows: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        dots: true,
        autoplay: true,
        autoplaySpeed: 1500,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
        ],
    });
});
