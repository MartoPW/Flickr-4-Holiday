<?php

require '../../autoloader.php';


$Flickr = new Flickr();


$opts = array(
    'per_page' => 20,
    'page' => intval($_GET['page']) < 1 ? 1 : intval($_GET['page']),
    'tag_mode' => $_GET['tag_mode'] ? 'all' : 'any',
    'extras'=>'description, owner_name, tags, url_q',
    'tags' => str_replace(' ',',',$_GET['tags']),
);

$imgs = $Flickr->getImages($opts);
if (count($imgs['photos']['photo']) < 1) {
    $result = array(
        'success' => false,
        'message' => $imgs['message'] ? $imgs['message'] : 'Nothing to show, please search for another keywords.'
    );
} else {
    $result = array(
        'success' => true,
        'page' => $imgs['photos']['page'],
        'pages' => $imgs['photos']['pages'],
        'perpage' => $imgs['photos']['perpage'],
    );


    foreach ($imgs['photos']['photo'] as $k => $v) {
        $photoId = $v['id'];

        $result['images'][] = array(
            'id' => $Flickr->getImageId($photoId),
            'title' => $Flickr->getImageTitle($photoId),
            'url' => $Flickr->getImageUrl($photoId),
            'thumb_url' => $Flickr->getImageThumbnail($photoId),
            'author_name' => $Flickr->getImageAuthorName($photoId),
            'author_url' => $Flickr->getImageAuthorUrl($photoId),
            'description' => $Flickr->getImageDescription($photoId),
            'tags' => $Flickr->getImageTags($photoId)
        );
    }
}
echo json_encode($result);

