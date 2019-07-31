<?php
    
# Twitterest, a website enables Pinterest feed-like Twitter scrolling experience, clean and sleekkkkk
    
# Get your own scraper key here: https://www.scraperapi.com/
$YOURSCRAPERKEY = "YOURSCRAPERKEYHERE";
    
# Set photo dimension
$IMAGEDIMENSION = "200x200";
    
$search = trim(htmlspecialchars($_REQUEST['search']));
if(!$search) $search = "hong kong";
$url = ("https://twitter.com/search?q=hong%20kong");
$proxiedUrl = "http://api.scraperapi.com?api_key=$YOURSCRAPERKEY&url=".($url);
$data = file_get_contents($proxiedUrl);

print <<<EOF
<form action=index.php><input name=search value="$search"><input type=submit></form>
EOF;

$tweets = explode('<small class="time">', $data);
foreach($tweets as $tweet){
    if(strpos($tweet, 'pbs.twimg') == -1) continue;
    if (preg_match_all('#<a href="(/.*?)".*?AdaptiveMedia.*?(https://pbs.twimg.*?\.(png|jpg))#s',
                       $tweet, $matches)) {
        $url = $matches[1][0];
        $pic = $matches[2][0];
        $map[$url] = $pic;
    }
}

foreach($map as $url=>$pic){
    $cloudimage = "https://anaixnggen.cloudimg.io/crop/$IMAGEDIMENSION/x/" . $pic;
    print "<a href=http://twitter.com/$url><img width=width src='$cloudimage'></a>";
}
