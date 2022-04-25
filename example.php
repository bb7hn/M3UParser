<?php
require_once("m3uParser.php");
function getBaseUrl() 
{
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF']; 

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath); 

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST']; 

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

    // return: http://localhost/myproject/
    return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
}


$url =getBaseUrl();
$url.="test.m3u";
$data = parseM3U($url);;
$data = [  "categories"=>$data[1],
            "channels" => $data[0]    
];
foreach( $data['channels'] as $category=>$channels){

    ?>
        <h1><?php echo$category;?></h1>
    <?php
    foreach($channels as $channel){
        ?>
        <?php echo$channel['name']?>=><?php echo$channel['logo']?>=><?php echo$channel['url']?>
        <br>
        <?php
    }
    echo'<hr>';
}
?>


