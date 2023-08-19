$(window).on('load', function () {
    $('#stat').fadeOut(3000);
    $('#preloader').delay(3000).fadeOut();
});
 const cursor = document.querySelector('.mou');

        document.addEventListener('mousedown', e => {
            cursor.setAttribute("style", "top: "+(e.pageY - 10)+"px; left: "+(e.pageX - 10)+"px;")
        })

        document.addEventListener('click', () => {
            cursor.classList.remove("done");
            cursor.classList.add("expand");

            setTimeout(() => {
                cursor.classList.remove("expand");
                cursor.classList.add("done");
            }, 500)
        })
	$(document).ready(function() {
			$('.minus').click(function () {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$('.plus').click(function () {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
		});
    $('.like-btn').on('click', function() {
    $(this).toggleClass('is-active');
    });

    $('.minus-btn').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());
    
        if (value > 1) {
            value = value - 1;
        } else {
            value = 1;
        }
    
    $input.val(value);
    
    });
    
    $('.plus-btn').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());
    
        if (value <= 100) {
            value = value + 1;
        } else {
            value =100;
        }
    
        $input.val(value);
    });




