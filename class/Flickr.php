<?php

class Flickr
{

    protected $_url = 'https://api.flickr.com/services/rest/?';
    protected $_api_key = '968dad9b78ff6cfda046dcb8f4abeacc';
    protected $_imgs_per_page = 20;
    protected $_resp_format = 'php_serial';

    protected $_images = array();

    protected function getData($method, $extraParams = array())
    {
        $params = array(
            'api_key' => $this->_api_key,
            'method' => $method,
            'format' => $this->_resp_format,
        );
        $params = array_merge($params, $extraParams);
        $encoded_params = array();
        foreach ($params as $k => $v) $encoded_params[] = urlencode($k) . '=' . urlencode($v);
        $url = $this->_url . implode('&', $encoded_params);
        $result = unserialize(file_get_contents($url));
        return $result;
    }

    public function getImages($params = array())
    {
        $method = 'flickr.photos.search';
        if (!isset($params['tags']) || !array_key_exists('tags', $params) || strlen($params['tags']) < 1) $method = 'flickr.photos.getRecent';
        if (!isset($params['tag_mode']) || !array_key_exists('tag_mode', $params)) $params['tag_mode'] = 'any';
        $result = $this->getData($method, $params);
        if($result['stat'] == 'fail'){
            return $result;
        }
        foreach ($result['photos']['photo'] as $photo) {
            $this->_images[$photo['id']] = $photo;
        }
        return $result;
    }


    public function getImageDescription($photoId)
    {
        return $this->_images[$photoId]['description']['_content'];
    }

    public function getImageTags($photoId)
    {
        return str_replace(' ', ',', $this->_images[$photoId]['tags']);
    }

    public function getImageId($photoId)
    {
        return $photoId;
    }

    public function getImageUrl($photoId)
    {
        return 'https://www.flickr.com/photos/'.$this->_images[$photoId]['owner'].'/'.$photoId;
    }

    public function getImageAuthorName($photoId)
    {
        $result = strlen($this->_images[$photoId]['ownername']) > 1 ? $this->_images[$photoId]['ownername'] : $this->_images[$photoId]['owner'];
        return $result;
    }

    public function getImageAuthorUrl($photoId)
    {
        return 'https://www.flickr.com/photos/' . $this->_images[$photoId]['owner'] . '/';
    }

    public function getImageTitle($photoId)
    {
        return $this->_images[$photoId]['title'];
    }

    public function getImageThumbnail($photoId)
    {
        return $this->_images[$photoId]['url_q'];
    }
}