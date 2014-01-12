<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
{asset name="Head"}
{literal}
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{/literal}
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
	<div id="Body">
		<div class="Row">
			<div id="topBanner"></div>
			<div class="Head" id="Head">
				<div class="Row TopRow">
					<strong class="SiteTitle"><a href="{link path="/"}">{logo}</a></strong>
					<div class="SiteSearch">{searchbox}</div>
					<ul class="SiteMenu">
						{discussions_link}
						{activity_link}
						{custom_menu}
					</ul>
				</div>
			</div>
			<div class="BreadcrumbsWrapper">{breadcrumbs}</div>
			<div class="Column PanelColumn" id="Panel">
				{module name="MeModule"}
				{asset name="Panel"}
			</div>
			<div class="Column ContentColumn" id="Content">{asset name="Content"}</div>
			<div class="clear" style="height: 0.7em;"></div>
		</div>
	</div>
	<div id="Foot">
		<div class="BottomRow">
			Base theme by <a href="http://designmodo.com/">DesignModo</a> &amp; ported to <a href="{vanillaurl}" class="PoweredByVanilla" title="Community Software by Vanilla Forums">Powered by Vanilla</a> by Chris Ireland, modified by the "theFB" team.
		</div>
		{asset name="Foot"}
	</div>
</div>
{event name="AfterBody"}
{literal}
<script>
// SCROLL TO ELEMENT //
function scrollTo(elementID){
	$('html, body').animate({
		scrollTop: $('#' + elementID).offset().top
	}, 1500);
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
