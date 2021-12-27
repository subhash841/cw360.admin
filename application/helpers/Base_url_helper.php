<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * base_url
 *
 * Overwrites the base_url function to support
 * loading your asset from KeyCDN.
 */
function base_url($uri = '', $protocol = NULL) {
    if (!$uri) {
        return get_instance()->config->base_url($uri, $protocol);
    }
    if ($uri[0] != '/')
        $uri = '/' . $uri;
    $currentInstance = & get_instance();

    $cdnUrl = $currentInstance->config->item('cdn_url');

    $extensions = array('css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'pdf', 'woff', 'tff', 'otf', 'map');

    $pathParts = pathinfo($uri);
    if (!empty($pathParts['extension']))
        if (!empty($cdnUrl) && in_array($pathParts['extension'], $extensions)) {
            return $cdnUrl . $uri;
        }

    return $currentInstance->config->base_url($uri, $protocol);
}
