<?php
if (!function_exists('embedSocial')) {
    function embedSocial($content)
    {
        //  Corriger les liens X vers Twitter
        $content = str_replace('https://x.com/', 'https://twitter.com/', $content);

        //  Instagram (post + reel)
        $content = preg_replace(
            '#(?<!href=")(https?://(www\.)?instagram\.com/(p|reel)/[A-Za-z0-9_-]+)#',
            '<blockquote class="instagram-media" data-instgrm-permalink="$1" data-instgrm-version="14" style="margin:auto;max-width:540px;"></blockquote>',
            $content
        );

        //  Facebook (post + share/v + videos)

       $content = preg_replace_callback(
            '#(?<!href=")(https?://(www\.)?facebook\.com/[^"\s<]+)#',
            function ($matches) {
                $url = $matches[1];

                // REELS
                if (preg_match('#facebook\.com/.*/reel/#', $url)) {
                    return '<div class="fb-video" data-href="' . $url . '" data-allowfullscreen="true" data-width="500"></div>';
                }

                // VIDEOS
                if (preg_match('#facebook\.com/.*/videos/#', $url)) {
                    return '<div class="fb-video" data-href="' . $url . '" data-allowfullscreen="true" data-width="500"></div>';
                }

                // POSTS classiques
                return '<div class="fb-post" data-href="' . $url . '" data-width="500"></div>';
            },
            $content
        );
        //  YouTube (normal + shorts)
        $content = preg_replace(
            '#(?<!href=")(https?://(www\.)?(youtube\.com/watch\?v=|youtu\.be/|youtube\.com/shorts/)([A-Za-z0-9_-]+))#',
            '<div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;max-width:100%;margin:auto;">
                <iframe src="https://www.youtube.com/embed/$4" frameborder="0" allowfullscreen
                        style="position:absolute;top:0;left:0;width:100%;height:100%;">
                </iframe>
            </div>',
            $content
        );

        //  Twitter / X
        $content = preg_replace(
            '#(?<!href=")(https?://(www\.)?twitter\.com/[^/]+/status/[0-9]+)#',
            '<blockquote class="twitter-tweet"><a href="$1"></a></blockquote>',
            $content
        );

        //  TikTok
        $content = preg_replace(
            '#(?<!href=")(https?://(www\.)?tiktok\.com/[^"\s<]+)#',
            '<blockquote class="tiktok-embed" cite="$1" data-video-id="" style="max-width:605px;min-width:325px;margin:auto;">
                <a href="$1"></a>
            </blockquote>',
            $content
        );

        return $content;
    }
}
