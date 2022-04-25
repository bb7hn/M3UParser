<?php
//header('Content-Type: application/json');
function parseM3U($url){
    $data = file_get_contents($url);
    $array = explode('#EXTINF:-1',$data);

    $pattern_id = '/tvg-id=\"(.*?)\"/';
    $pattern_name = '/tvg-name=\"(.*?)\"/';
    $pattern_name2 = '/(.*?): /';
    $pattern_logo = '/tvg-logo=\"(.*?)\"/';
    $pattern_group = '/group-title=\"(.*?)\"/';
    $pattern_group2 = '/(.*?)⟾ /';
    $pattern_m3u8 = '/(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,}).(m3u8|.m3u|.ts|.mp3|.ogg|.webm|.mkv|.flv|.vob|.ogv|.drc|.gif|.gifv|.mng|.avi|.mts|.m2ts|.ts|.mov|.qt|.wmv|.yuv|.rm|.rmvb|.viv|.asf|.amv|.mp4|.m4p|.m4v|.mpg|.mp2|.mpeg|.mpe|.mpv|.mpg|.m2v|.m4v|.svi|.3gp|.3g2|.mxf|.roq|.nsv|.flv|.f4v|.f4p|.f4a|.f4b)/';
    //$channels=[];
    $categories = [];
    foreach($array as $data){
            preg_match_all($pattern_id, $data,$match);
            $id=$match[0][0];
            $id=str_replace('"',"",$id);
            $id=str_replace('tvg-id=',"",$id);

            preg_match_all($pattern_name, $data,$match);
            $name=$match[0][0];
            $name=str_replace('"',"",$name);
            $name=str_replace('tvg-name=',"",$name);
            $name = preg_replace($pattern_name2,'',$name);
            $name = preg_replace($pattern_group2,'',$name);
            //echo$name.PHP_EOL;
            preg_match_all($pattern_logo, $data,$match);
            $logo=$match[0][0];
            $logo=str_replace('"',"",$logo);
            $logo=str_replace('tvg-logo=',"",$logo);
            //echo$logo.PHP_EOL;
            preg_match_all($pattern_group, $data,$match);
            $group=$match[0][0];
            $group=str_replace('"',"",$group);
            $group=str_replace('group-title=',"",$group);
            $group = preg_replace($pattern_group2,'',$group);
            $group = preg_replace($pattern_name2,'',$group);        
            //echo$group.PHP_EOL.PHP_EOL.PHP_EOL;
            preg_match_all($pattern_m3u8, $data,$match);
            $url=$match[0][0];
            if($group == null)
                continue;
            if($categories[$group] == null)
                $categories[$group] = [];
            if($url == null)
                continue;
            if($name == null)
            $name = $id;
            if($logo == null)
                $logo = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png";//"assets/default.png";
            
            $channel=[
                "name"=>$name,
                "logo"=>$logo,
                "url"=>$url,
                "category"=>$group
            ];
            //array_push($channels,$channel);
            array_push($categories[$group],$channel);
        
    }
    return [$categories,array_keys($categories)];
}

?>
