$(document).ready(function () {
    // Mobile Menu
    // $('.logo a i').click(function(){
    // 	$('.menu ul').slideToggle(1000);

    // 	return false
    // });

    // Our-Products Carousel
    $('.our-product-contents').owlCarousel({
        items: 4,
        loop: true,
        nav: true,
        dots: false,
        autoplay: false,
        margin: 20,
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });
    $(".owl-prev").html('<i class="fa fa-chevron-left"></i>');
    $(".owl-next").html('<i class="fa fa-chevron-right"></i>');
});



// SingleResources Page Password Hide/Show
$(function () {

    $('#eye').click(function () {

        if ($(this).hasClass('fa-eye-slash')) {

            $(this).removeClass('fa-eye-slash');

            $(this).addClass('fa-eye');

            $('#password').attr('type', 'text');

        } else {

            $(this).removeClass('fa-eye');

            $(this).addClass('fa-eye-slash');

            $('#password').attr('type', 'password');
        }
    });
});






