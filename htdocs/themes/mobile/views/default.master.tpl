<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-ca">
<head>
    {asset name='Head'}
</head>
<body id="{$BodyID}" class="{$BodyClass}">
<div id="Frame">
    <div class="Banner">
	{asset name="Menu"}
        <ul>
            {home_link}
            {profile_link}
            {inbox_link}
						{discussions_link}
						<li><a href="/search?Search=" title="Search">Search</a></li>
						{custom_menu}
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
            {literal}
                <!-- Pre-content mobile -->
                <ins class="adsbygoogle pre-content"
                    style="display:inline-block;width:100%;min-width:100%;min-height:50px;max-height:120px !important;"
                    data-ad-client="ca-pub-9953112108229165"
                    data-ad-slot="8589543752"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            {/literal}
            {asset name="Content"}
            {literal}
                <!-- Pre-content mobile -->
                <ins class="adsbygoogle post-content"
                    style="display:inline-block;width:100%;min-width:100%;min-height:50px;max-height:120px !important;"
                    data-ad-client="ca-pub-9953112108229165"
                    data-ad-slot="3935982878"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            {/literal}
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
</body>
</html>
