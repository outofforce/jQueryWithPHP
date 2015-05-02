
<footer>
	<div class="main-footer">
		<ul>
			<li id="footer-menu-index"><a href="index.php"><img src="images/index.png"><span>晓菜</span></a></li>
			<li id="footer-menu-recipes"><a href="recipes.php"><img src="images/recipes.png"><span>一手好菜</span></a></li>
			<li id="footer-menu-skills"><a href="skills.php"><img src="images/skills.png"><span>玩转厨房</span></a></li>
			<!--<li id="footer-menu-review"><img src="images/review.png">测评</li>-->		
		</ul>
	</div>
</footer>

</body>
<script type="text/javascript">

	$(document).ready(function(){

		//添加动画效果
		$('ul li,a,h1,h2,h3,h4,h5,h6,p,span,.fast-register,.button-add').hover(
			function(){
				$(this).stop().animate({opacity:0.9},'fast');
			},
			function(){
				$(this).stop().animate({opacity:1},'fast');
			}
		);

		//处理底部菜单滑动事件,若用户滑动到底部则自动隐藏
		function handleFooterEvent(){
			if(isUserAtBottom()){
				if(footerIsDisplayed){
					
				}else{
					$('footer').slideUp();
					footerIsDisplayed=true;
				}
			}else{
				if($(window).scrollTop()==0){
					$('footer').slideDown();
					footerIsDisplayed=false;
				}
			}
		}

		/*幻灯片开始*/

		if(window.chrome) {$('.banner li').css('background-size', '100% 100%');}

		$(function() {$('.banner').unslider();});

		$('.banner').unslider({
			arrows: true,	
			fluid: true,
			dots: true,
			keys:true,
			delay:4000
		});

		/*幻灯片结束*/

		//用户滑动页面时处理
		$(window).scroll(handleFooterEvent);

		/*菜单按钮被点击*/
		function toggleLeftMenu(){
			var rate=0.2545;
			if($(document).width()>400){
				rate=0.2565;
			}else{
				rate=0.2545;
			}
			var docWidth=$(document).width()-($(document).width()*rate);
			var mainPageWidth=$(document).width()*rate;
			if(!isSlided){
				$('.main-page').animate({left:docWidth+'px'},300,function(){
					$('.login-page').css('display','block');
				});
				$('footer').slideUp();
				setNoTouchMove();
				isSlided=true;
			}else{
				$('.main-page').animate({left:'0px'});
				$('.login-page').css('display','none');
				$('footer').slideDown();
				setTouchMove();
				isSlided=false;
			}	
		}

		$('.nav-menu').click(function(){
			toggleLeftMenu();
		});

		function loadPagesInMenu(pageName){
			toggleLeftMenu();
			loadPagesA(pageName,'body');
		}

		$('.column-menu ul li').click(function(){
			var titleClicked=$(this).attr('class').split('-')[2];
			if(titleClicked!='foodlist'){
				loadPagesInMenu(titleClicked+'.php');
			}else{
				window.location.href=titleClicked+'.php';
			}
		});

		//加载登录页面
		$('.lo-re-area .button').click(function(){
			loadPagesInMenu('login.php');
		});

		//加载快速注册页面
		$('.lo-re-area .fast-register').click(function(){
			loadPagesInMenu('register.php');
		});

		//设置活跃菜单
		function setActiveA(){
			var currentHref=document.location.href;
			if(currentHref.charAt(currentHref.length-1)!='/'){
				currentHref=currentHref.split('.');
				currentHref=currentHref[currentHref.length-2].split('/');
				currentHref=currentHref[currentHref.length-1];
			}else{
				currentHref='index';
			}
			var activeElem='.main-footer ul #footer-menu-'+currentHref;
			$(activeElem+' a span').addClass('main-footer-menu-active');
			$(activeElem+' a img').attr('src','images/'+currentHref+'_active.png');		
		}
		
		setActiveA();

		$('.main-footer ul li').mousedown(function(){
			var imgsrc=$(this).find('a').find('img').attr('src');
			var imgsrcArray=imgsrc.split('.');
			var imgsrcNoExtension=imgsrcArray[0];
			var imgsrcExtension=imgsrcArray[1];
			$(this).find('a').find('img').attr('src',imgsrcNoExtension+'_active.'+imgsrcExtension);
		});

		if(localStorage.isLogin=='true'){
			$('.lo-re-area').css('display','none');
			$('.logo-area').css('marginTop','30.273972%');
			$('.logo-area').css('marginBottom','30.273972%');
			$('.column-menu').show();
		}else{
			$('.lo-re-area').css('display','block');
			$('.logo-area').css('marginTop','20.920502%');
			$('.logo-area').css('marginBottom','0');
			$('.column-menu').hide();
		}

		$(window).scroll(floatMenuCase);

		function floatMenuCase(){
			if($(document).scrollTop()>$('header').height()){
				$('header').css('position','fixed')
								 .css('opacity','0.9')
								 .css('top','0px')
								 .css('width','100%')
								 .css('z-index','1000');
			}else{
				$('header').css('position','fixed')
								 .css('opacity','1')
								 .css('top','0px')
								 .css('width','100%');
			}
		}

		$('section').css('marginTop',$('header').height()+6);

	    $('.header-back').click(function() {
     		history.go(-1);
    	});
		
	});
	
	document.addEventListener("touchmove",function(e){
		if(docIsMoved==0){
			e.preventDefault();
			e.stopPropagation();
		}
	},false);

	function addToReadingList(obj){
		displayALertForm('正在添加到收藏列表...');
		var articleID=$(obj).attr('articleid');
		var articleType=$(obj).attr('type');
		addReadingList(articleType,localStorage.tokenID,articleID,function(data){
			var jsonData=JSON.parse(data);
			displayALertForm(jsonData['msg']);
		});
	}

	function locateToIntroduction(obj){
		displayALertForm('正在为您跳转...');
		var ref=$(obj).attr('ref');
		window.location.href=ref;
	}

	$('.search-form input').focus(function(){$('.nav-content ul li .search-input-icon').hide();});
	$('.search-form input').blur(function(){$('.nav-content ul li .search-input-icon').show();});
	//$('html:not(div)').click(function(){$('footer').slideToggle();});

</script>
</html>
