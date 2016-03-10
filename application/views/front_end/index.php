<?php include('header.php');?>
	<div class="page-top clb"></div>
    <div class="page-content clb">
    	<div id="mainpage">
    		<?php
    			if(isset($this->session->userdata['store'])) {
    				$menu = Modules::run('common/showMenu');
    				echo $menu;	
    			}
    		?>
    		<?php $this->load->view($content);?>
        </div>
        <!--END main page-->
    </div>
    <div class="page-bottom clb"></div>
    <?php include('footer.php');?>
    <?php 
    	$popup = Modules::run('common/showPopup');
    	echo $popup;
    ?>
</body>
<script>
	$(document).ready(function(){
		var mainLeft = $('.main-left').height();
		var mainRight = $('.main-right').height();
		if(mainLeft < mainRight){
			//$('.main-left').height(mainRight);
			$('.main-left').attr("style","min-height:"+mainRight+"px");
		}
		
		$('ul#badgeStyle li a').click(function(){
			$(this).parent().addClass('badgeStyleActive'). // <li>
			  siblings().removeClass('badgeStyleActive');
		});
		$('.popup').center();
		$(window).bind('resize', function() {
			$('.popup').center({transition:300});
		});
	});

	jQuery.fn.center = function () {
		this.css("position","absolute");
		this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() - 50 + "px");
		this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
		return this;
	}

</script>
</html>
