<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
{asset name="Head"}
{literal}
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{/literal}
{literal}
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PX2NYTT2HZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PX2NYTT2HZ');
</script>
{/literal}
</head>
<body id="{$BodyID}" class="{$BodyClass}">
<div id="Frame">
	<div id="Body">
		<div class="Row relative">
		  <div id="topBanner">
  			<a href="/" title="The Fretboard">
  			  <img src="/themes/FlatVI/img/thefb_header_2017_2.png">
			  </a>
		  </div>
			<div id="promo-banner">
		      <a href="https://www.thefretboard.co.uk/discussion/210757/" title="Trent Guitars" target="_blank">
			    <img src="/themes/FlatVI/img/trent_banner_2.png" />
			  </a>
			</div>
			<div class="BreadcrumbsWrapper">
			  {breadcrumbs}
			  <div class="nav" id="nav">
				  <div class="SiteSearch">{searchbox}</div>
			    <ul class="SiteMenu">
				    {discussions_link}
				    {activity_link}
				    {custom_menu}
			    </ul>
			  </div>
		  </div>
			<div class="Column PanelColumn" id="Panel">
				{module name="MeModule"}
				{asset name="Panel"}
				{literal}
					<!-- Vertical Sidebar -->
					<ins class="adsbygoogle"
							style="display:block"
							data-ad-client="ca-pub-9953112108229165"
							data-ad-slot="5913486945"
							data-ad-format="auto"
							data-full-width-responsive="true"></ins>
				{/literal}
					<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
			</div>
			<div class="Column ContentColumn" id="Content">
				{literal}
					<!-- Pre-content Horizontal -->
					<ins class="adsbygoogle"
							style="display:inline-block;width:876px;height:120px"
							data-ad-client="ca-pub-9953112108229165"
							data-ad-slot="3089202424"></ins>
					<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
				{/literal}
				{asset name="Content"}
			</div>
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
/*
function scrollTo(elementID){
	$('html, body').animate({
		scrollTop: $('#' + elementID).offset().top;
	}, 300);
}
*/
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
