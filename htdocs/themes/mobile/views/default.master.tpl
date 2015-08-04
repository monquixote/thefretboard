<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<head>
  {asset name='Head'}
  {literal}
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-46473930-1', 'thefretboard.co.uk');
    ga('send', 'pageview');

  </script>
  {/literal}
</head>
<body id="{$BodyID}" class="{$BodyClass}">
  <div id="Frame">
	 <div class="Banner">
		<ul>
		  {home_link}
		  {profile_link}
		  {inbox_link}
		  {discussions_link}
		  {event name="BeforeSignInLink"}
		  {if !$User.SignedIn}
			 <li class="SignInItem">{link path="signin" class="SignIn"}</li>
		  {/if}
		</ul>
	 </div>
	 <div id="Body">
       <div class="BreadcrumbsWrapper">
         {breadcrumbs homelink="0"}
       </div>
		<div id="Content">
		  {asset name="Content"}
		</div>
	 </div>
	 <div id="Foot">
		<div class="FootMenu">
        {nomobile_link wrap="span"}
		  {dashboard_link wrap="span"}
		  {signinout_link wrap="span"}
		</div>
      <a class="PoweredByVanilla" href="{vanillaurl}"><span>Powered by Vanilla</span></a>
		{asset name="Foot"}
	 </div>
  </div>
{event name="AfterBody"}
{literal}
<script>
// SCROLL TO ELEMENT //
function scrollTo(elementID){
	$('html, body').animate({
		scrollTop: $('#' + elementID).offset().top;
	}, 300);
}
/*
// Scrollbar Fix, assembled from StackOverflow
$(window).scroll(function(){
if(isPageScrolling()){
$('head').append('<link rel="stylesheet" href="//cdn.tama63.co.uk/van/scrollbar.css" type="text/css" />');
}
});

function isPageScrolling() {
var docHeight = $(document).height();
var scroll    = $(window).height() + $(window).scrollTop();
return (docHeight == scroll);
}
*/
</script>
{/literal}
</body>
</html>
