﻿<?php

include_once 'simple_html_dom.php';


class PostParser {

    public static function parse($link) {

        switch(self::forumName($link)) {
            case "perevodika.ru": return self::parsePerevodika($link);
            case "gratis.pp.ru": return self::parseGratis($link);
            case "politforums.net": return self::parsePolitforums($link);
            case "tehnowar.ru": return self::parseTechnowar($link);
            case "trueinform.ru": return self::parseTrueinform($link);
            case "fishki.net": return self::parseFishki($link);
            case "ridus.ru": return self::parseRidus($link);
            case "forum.vtomske.ru": return self::parseForumVtomske($link);
            case "publikatsii.ru": return self::parsePublikatsii($link);
            case "forum.rcmir.com": return self::parseRcmir($link);
            case "forum.topwar.ru": return self::parseTopwar($link);
            case "cont.ws": return self::parseCont($link);
            case "forum.sc2tv.ru": return self::parseForumSc2tv($link);
            case "ipolk.ru": return self::parseIpolk($link);
            case "jediru.net": return self::parseJediru($link);
            case "dialogforum.net": return self::parseDialogforum($link);
            case "e-news.su": return self::parseEnews($link);
            case "x-true.info": return self::parseXtrue($link);
            case "forum.cofe.ru": return self::parseForumCofe($link);
            case "maxpark.com": return self::parseMaxpark($link);
            case "mpsh.ru": return self::parseMpsh($link);
            case "forum.na-svyazi.ru": return self::parseForumNaSvyazi($link);
            case "newsland.com": return self::parseNewsland($link);
            case "pandoraopen.ru": return self::parsePandoraopen($link);
            case "forum-people.ru": return self::parseForumPeople($link);
            case "forum.polismi.ru": return self::parseForumPolismi($link);
            case "politnews.net": return self::parsePolitnews($link);
            case "politobzor.net": return self::parsePolitobzor($link);
            case "rupor.sampo.ru": return self::parseRuporSampo($link);
            case "rusforum.com": return self::parseRusforum($link);
            case "for-ua.info": return self::parseForUa($link);
            case "shaonline.ru": return self::parseShaonline($link);
            case "yarportal.ru": return self::parseYarportal($link);
            case "yaplakal.com": return self::parseYaplakal($link);
            case "forum-spb-piter.ru": return self::parseForumSpbPiter($link);
            case "alpenforum.forumsmotion.com": return self::parseAlpenForum($link);
            case "chupakabra.1bbs.info": return self::parseChupakabra($link);
            case "forum.qwas.ru": return self::parseForumQwas($link);
            case "forum.rostov-today.ru": return self::parseRostovToday($link);
            case "forum.schta.ru": return self::parseForumSchta($link);
            case "forumactiv.ru": return self::parseForumActiv($link);
            case "forumrostov.ru": return self::parseForumRostov($link);
            case "kolobok.forumbb.ru": return self::parseKolobok($link);
            case "metrs.org": return self::parseMetrs($link);
            case "politsrach.ru": return self::parsePolitsrach($link);
            case "puksinka.ru": return self::parsePuksinka($link);
            case "rusobtemforum.mybb.ru": return self::parseRusobtemForum($link);
            case "vse-zdes.forumbook.ru": return self::parseVseZdesForumbook($link);
            case "frnd.org": return self::parseFrnd($link);
            case "novaia-politika.ru": return self::parseNovaiaPolitika($link);
            case "noril.0pk.ru": return self::parseNorilOpk($link);
            case "newslab.ru": return self::parseNewslab($link);
            case "sevpolitforum.ru": return self::parseSevpolitForum($link);
            case "mirtesen.ru": return self::parseMirtesen($link);
            case "los-engels.ru": return self::parseLosEngels($link);
            case "livejournal.com": return self::parseLiveJournal($link);
            case "dirty.ru": return self::parseDirty($link);
            case "vk.com": return self::parseVk($link);
            case "debatepolitics.ru": return self::parseDebatepolitics($link);
            case "politikforum.ru": return self::parsePolitikforum($link);
            case "sovserv.ru": return self::parseSovserv($link);
            case "operline.ru": return self::parseOperline($link);
            case "forum.ee": return self::parseForumEE($link);
            case "tochek.net": return self::parseTochek($link);
            case "forumnov.com": return self::parseForumnov($link);
            case "forum-volgograd.ru": return self::parseForumVolgograd($link);
            case "forums.realax.ru": return self::parseForumRealax($link);
            case "inforeactor.ru": return self::parseInforeactor($link);
            case "slovodel.com": return self::parseSlovodel($link);
            case "newinform.com": return self::parseNewinform($link);
            case "politexpert.net": return self::parsePolitexpert($link);
            case "planeta.moy.su": return self::parsePlanetaMoy($link);
            case "forummoskva.ru": return self::parseForumMoskva($link);
            case "pikabu.ru": return self::parsePikabu($link);

            default: return false;
        }

    }

    private static function parsePerevodika($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // VIEWS
        if(count($item = $html->find('.main_td .detail_article_page div p em',0)) > 0) {
            $pattern = '/^.+\s+([0-9]+)\s+.+$/';
            $replacement = '$1';
            $items['viewCount'] = trim(preg_replace($pattern, $replacement, $item));
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseGratis($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        $postFromPage = $html->find('a[href=' . $link . ']');

        // TITLE
        if(count($postFromPage) > 0) {
            $items['title'] = $html->find('a[href=' . $link . ']', 0)->parent()->parent()->parent()->
            parent()->parent()->parent()->next_sibling()->find('td',1)->find('span',0)->find('b',0)->plaintext;
        }

        // Get sub forum link
        $pattern = '/^.+f=([0-9]+)&.+$/';
        $replacement = '$1';
        $subForumLink = 'www.gratis.pp.ru/index.php?s=&act=SF&f=' . preg_replace($pattern, $replacement, $link);

        // New link for search (First page post)
        $pattern = '/^.+f=([0-9]+)&t=([0-9]+)&.+$/';
        $replacement ='f=$1&t=$2&s=';
        $newLink = 'http://www.gratis.pp.ru/index.php?act=ST&' . preg_replace($pattern, $replacement, $link);

        // Loop page
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = PostParser::getPageGratis($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $newLink . ']');

            if(count($postFromPage) > 0) {

                // COMMENTS
                $items['commentCount'] = $page->find('a[href=' . $newLink . ']', 0)->parent()->parent()->parent()->
                parent()->parent()->parent()->find('td', 6)->plaintext;

                // VIEWS
                $items['viewCount'] = $page->find('a[href=' . $newLink . ']', 0)->parent()->parent()->parent()->
                parent()->parent()->parent()->find('td', 7)->plaintext;

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageGratis($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '&prune_day=100&sort_by=Z-A&sort_key=last_post&st=' . ($page - 1) * 50;

        $html = str_get_html(self::getWebPage($url));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');

        return str_get_html($html);
    }

    private static function parsePolitforums($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('table tr td h1',1)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // Get sub forum link
        $subForumLink = '';

        $explodeLink = explode('/', $link);
        for($i = 0; $i < count($explodeLink) - 1; $i++) {
            $subForumLink .= $explodeLink[$i] . '/';
        }

        // Post href
        $pattern = '/^.+politforums\.net(.+)$/';
        $replacement = '$1';
        $hrefPost = preg_replace($pattern, $replacement, $link);
        echo $hrefPost;

        // Loop page
        for($indexPage = 1; $indexPage < 2; $indexPage++) {

            $page = PostParser::getPagePolitforums($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $hrefPost . ']');

            if(count($postFromPage) == 2) {

                // COMMENTS
                $items['commentCount'] = trim($page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->find('td', 3)->plaintext);

                // VIEWS
                $item = $page->find('a[href=' . $hrefPost . ']', 0)->onmouseover;
                $pattern = '/^.+<\/b>([0-9]+)<br>.*$/';
                $replacement = '$1';
                $items['viewCount'] = trim(preg_replace($pattern, $replacement, $item));

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPagePolitforums($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= ($page - 1) . '/';
        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parseTechnowar($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.story-full h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // VIEWS
        if(count($item = $html->find('.nav-story li',3)) > 0) {
            $pattern = '/[^0-9]+/';
            $items['viewCount'] = preg_replace($pattern, '', $item);
        }

        // COMMENTS
        if(count($item = $html->find('#dle-comm-link .comnum',0)) > 0) {
            $items['commentCount'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseTrueinform($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('table tr td h1 a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // VIEWS
        if(count($html->find('span.tiny')) > 0) {
            $item = $html->find('span.tiny',0)->title;
            $pattern = '/Прочтено:\s([0-9]+)/';
            $replacement = '$1';
            $views = preg_replace($pattern, $replacement, $item);
            $items['viewCount'] = trim($views);
        }

        // COMMENTS
        if(count($html->find('a[title=\'комментарии участника\']')) > 0) {
            $items['commentCount'] = count($html->find("a[title='комментарии участника']"));
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseFishki($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.post-page h1',0)) > 0) {
            $items['title'] = $item->plaintext;
            $pattern = '/^(.+)\(.+$/';
            $replacement = '$1';
            $items['title'] = trim(preg_replace($pattern, $replacement, $items['title']));
        }

        // VIEWS
        if(count($html->find('.post-stats-wrap span')) > 0) {
            $views = $html->find('.post-stats-wrap span',1)->plaintext;
            $items['viewCount'] = trim($views);
        }

        // COMMENTS
        if(count($html->find('.stats-likes-wrap .post-stats-wrap a')) > 0) {
            $comments = $html->find('.stats-likes-wrap .post-stats-wrap a',0)->plaintext;
            $items['commentCount'] = trim($comments);
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseRidus($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        //TITLE
        if(count($item = $html->find('.articleTitle h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        //VIEWS
        if(count($item = $html->find('.articleInfo .count2',0)) > 0) {
            $items['viewCount'] = $item->plaintext;
        }

        //COMMENTS
        if(count($item = $html->find('.articleInfo .count3',0)) > 0) {
            $items['commentCount'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumVtomske($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('h1.title-red',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // Get sub forum link
        $item = $html->find('.navi-cat-title', 2)->find('span', 0)->find('a');
        $subForumLink = 'http://forum.vtomske.ru' . $item[count($item) - 1]->href;

        // Get post href
        $pattern = '/http:\/\/forum.vtomske.ru/';
        $hrefPost = preg_replace($pattern, '', $link);

        // Loop page
        for($indexPage = 1; $indexPage < 2; $indexPage++) {

            $page = PostParser::getPageVtomske($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $hrefPost . ']');

            if(count($postFromPage) > 0) {

                // VIEWS
                $item = $page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->find('div.topic-bottom', 0)->plaintext;
                $item = explode('|', $item);
                $pattern = '/[^0-9]+/';
                $items['viewCount'] = preg_replace($pattern, '', $item[count($item) - 1]);

                // COMMENTS
                $item = $page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->prev_sibling()->find('span', 0)->plaintext;
                $items['commentCount'] = preg_replace($pattern, '', $item);

            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageVtomske($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '&page=' . $page;

        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parsePublikatsii($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // COMMENTS
        if(count($item = $html->find('.full .comment-num',0)) > 0) {
            $items['commentCount'] = $item->plaintext;
        }

        // VIEWS
        if(count($item = $html->find('.full .views-num',0)) > 0) {
            $items['viewCount'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    /* Авторизация и сохранение кукки */
    private static function parseRcmir($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('td.nav h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseTopwar($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('h1.ipsType_pageTitle',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // Get sub forum link
        $item = $html->find('ul[itemtype=http://schema.org/BreadcrumbList] li');
        $subForumLink = $item[count($item) - 2]->find('a', 0)->href;

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = PostParser::getPageForumTopwar($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $link . ']');

            if(count($postFromPage) == 1) {

                // VIEWS
                $items['viewCount'] = $page->find('a[href=' . $link . ']', 0)->parent()->parent()->next_sibling()->find('li', 1)->find('span', 0)->plaintext;

                // COMMENTS
                $items['commentCount'] = $page->find('a[href=' . $link . ']', 0)->parent()->parent()->next_sibling()->find('li', 0)->find('span', 0)->plaintext;

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageForumTopwar($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '?page=' . $page;

        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parseCont($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.author-bar2-inside',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        //VIEWS
        $item = $html->find('.dark .author-bar2-inside',0);
        $pattern = '/^.+glyphicon-eye-open\"><\/span>\s+([0-9]+).+glyphicon-comment.+$/';
        $replacement = '$1';
        $items['viewCount'] = trim(preg_replace($pattern, $replacement, $item));

        //COMMENTS
        $pattern = '/^.+glyphicon-comment\"><\/span>\s+([0-9]+).+glyphicon-signal.+$/';
        $replacement = '$1';
        $items['commentCount'] = trim(preg_replace($pattern, $replacement, $item));

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumSc2tv($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.threadtitle a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        if($html->plaintext!='') {
            $item = $html->find('#breadcrumb li a');
            $item = 'http://forum.sc2tv.ru/' . $item[count($item) - 1]->href;
            $item = explode('?', $item);
            $subForumLink = $item[0];
        }

        // Get post href
        $pattern = '/^.+\/([0-9]+).*$/';
        $replacement = '$1';
        $idPost = preg_replace($pattern, $replacement, $link);

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = PostParser::getPageSc2tv($subForumLink, $indexPage);

            $postFromPage = $page->find('a[id=thread_title_' . $idPost . ']');

            if(count($postFromPage) > 0) {

                // VIEWS
                $item = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->parent()->parent()->find('ul li', 1)->plaintext;
                $pattern = '/[^0-9]+/';
                $items['viewCount'] = preg_replace($pattern, '', $item);

                // COMMENTS
                $item = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->parent()->parent()->find('ul li', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $items['commentCount'] = preg_replace($pattern, '', $item);

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageSc2tv($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '/page' . $page;

        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parseIpolk($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('h1.topic-title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // COMMENTS
        if(count($item = $html->find('#count-comments',0)) > 0) {
            $items['commentCount'] = $item->plaintext;
        }

        // VIEWS
        if(count($item = $html->find('.viewcount .viewcount-info',0)) > 0) {
            $items['viewCount'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseJediru($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.crumblast',0)) > 0) {
            $items['title'] = $item;
            $pattern = '/^.+span>(.+)$/';
            $replacement = '$1';
            $items['title'] = preg_replace($pattern, $replacement, $items['title']);
        }

        // Get sub forum link
        $item = $html->find('#brd-crumbs-top', 0)->find('a');
        $subForumLink = $item[count($item) - 1]->href;

        // Loop page
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = PostParser::getPageJediru($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $link . ']');

            if(count($postFromPage) > 0) {

                // COMMENTS
                $item = $postFromPage[0]->parent()->parent()->next_sibling()->find('.info-replies strong', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $items['commentCount'] = preg_replace($pattern, '', $item);

                // VIEWS
                $item = $postFromPage[0]->parent()->parent()->next_sibling()->find('.info-views strong', 0)->plaintext;
                $items['viewCount'] = preg_replace($pattern, '', $item);

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageJediru($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= 'page/' . $page . '/';

        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parseDialogforum($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('.lastnavbit span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }


        // Get post ID
        $pattern = '/^.+t=([0-9]+).*$/';
        $replacement = '$1';
        $idPost = preg_replace($pattern, $replacement, $link);

        // Get link previus page
        $item = $html->find('.floatcontainer .lastnavbit',0)->prev_sibling()->find('a',0)->href;
        $pattern = '/^.+f=([0-9]+)&.+$/';
        $replacement = '$1';
        $subForumLink = 'http://dialogforum.net/forumdisplay.php?f=' . (preg_replace($pattern, $replacement, $item));

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = PostParser::getPageDialogforum($subForumLink, $indexPage);


            $postFromPage = $page->find('a[id=thread_title_' . $idPost . ']');

            if(count($postFromPage) > 0) {

                // VIEWS
                $item = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->parent()->parent()->find('ul li', 1)->plaintext;
                $pattern = '/[^0-9]+/';
                $items['viewCount'] = preg_replace($pattern, '', $item);

                // COMMENTS
                $item = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->parent()->parent()->find('ul li', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $items['commentCount'] = preg_replace($pattern, '', $item);

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageDialogforum($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '/page' . $page;

        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parseEnews($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        // TITLE
        if(count($item = $html->find('#dle-content article h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        // Get sub forum link
        $item = $html->find('div.news-meta', 2)->find('a');
        $subForumLink = 'www.e-news.su' . ($item[count($item) - 1]->href);

        // Loop page
        for($indexPage = 1; $indexPage < 2; $indexPage++) {

            $page = PostParser::getPageENews($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $link . ']');

            if(count($postFromPage) > 0) {

                // VIEWS
                $item = $postFromPage[0]->parent()->parent()->prev_sibling()->find('div.news-info', 0)->find('div', 1)->plaintext;
                $pattern = '/[^0-9]+/';
                $items['viewCount'] = preg_replace($pattern, '', $item);

                // COMMENTS
                $items['commentCount'] = $postFromPage[0]->parent()->parent()->prev_sibling()->find('div.news-info', 0)->find('div', 2)->plaintext;

                break;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private function getPageENews($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= 'page/' . $page . '/';

        $html = str_get_html(self::getWebPage($url));

        return str_get_html($html);
    }

    private static function parseXtrue($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.post_title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumCofe($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.threadtitle a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseMaxpark($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('head title',0)) > 0) {
            $items['title'] = $item->plaintext;
            $pattern = '/^(.+)\|.+$/';
            $replacement = '$1';
            $items['title'] = preg_replace($pattern, $replacement, $items['title']);
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseMpsh($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.full-title h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumNaSvyazi($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        if(count($item = $html->find('.maintitle p b',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseNewsland($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.post-top h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePandoraopen($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumPeople($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#pun-main h1 span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumPolismi($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.ipsType_pagetitle',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePolitnews($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.entry-title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePolitobzor($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.uk-article-title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseRuporSampo($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseRusforum($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('td.navbar strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForUa($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        $ch = curl_init();

        # Get data
        PostParser::loadHtmlForUa($ch, $link);

        $response = curl_exec($ch);

        $html = str_get_html($response);

        if(count($item = $html->find('.titles h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }
    private static function loadHtmlForUa($ch, $link) {

        $cookie = dirname(__FILE__).'/PostParser/cookiesForUa.txt';

        curl_setopt($ch, CURLOPT_URL,$link);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36");
        curl_setopt($ch, CURLOPT_REFERER, "http://for-ua.info/");
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);//Подставляем куки раз
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); //Подставляем куки два
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);

    }

    private static function parseShaonline($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('a.titles2',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseYarportal($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        if(count($item = $html->find('.maintitle h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseYaplakal($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.subpage a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumSpbPiter($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('td.navbar strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseAlpenForum($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.paged-head h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseChupakabra($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('table tr td a.maintitle index',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumQwas($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h2.header a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseRostovToday($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.post-title strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumSchta($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('li.last a span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumActiv($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('li.last a span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumRostov($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.ipsType_pagetitle',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseKolobok($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#pun-main h1 span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseMetrs($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.titleBar h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        if(!empty($items['title'])){

            if(count($item = $html->find('.errorOverlay .baseHtml label.OverlayCloser',0)) > 0) {
                $items['title'] = null;
            }else{
                $item = $html->find('#content .pageContent .titleBar h1',0);
                $items['title'] = $item->plaintext;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePolitsrach($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h3.first',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePuksinka($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1#thread_title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseRusobtemForum($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#pun-main h1 span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseVseZdesForumbook($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.maintitle h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseFrnd($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('td.thead div strong',1)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseNovaiaPolitika($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#page-body h2 a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseNorilOpk($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#pun-main h1 span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseNewslab($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.di2-body__title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseSevpolitForum($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#pageheader h2 a.titles',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseMirtesen($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('h1.title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        if(count($item = $html->find('h1.post',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseLosEngels($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#mtx h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseLiveJournal($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get new link in custom style
        $linkStyle = $link . '?format=light';

        # Get data
        $html = str_get_html(self::getWebPage($linkStyle));

        if(count($item = $html->find('h1.b-singlepost-title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }
        return $items;
    }

    private static function parseDirty($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));


        if(count($item = $html->find('h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        if(!empty($items['title'])){
            $pattern = '/^.+404.+$/';
            if(preg_match($pattern, $items['title'])){
                $items['title'] = null;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseVk($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );
        $postId = $link;
        $pattern = '/^.+wall([0-9]+_[0-9]+)(%2Fall)?$/';
        $replacement = '$1';
        $postId = preg_replace($pattern, $replacement, $postId);

        $parsePost = 'https://api.vk.com/method/wall.getById?posts='. $postId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $parsePost);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($output, true);

        $parserTxt = $data['response'][0]['text'];
        $pattern = '/^(.+?)<.+$/';
        $replacement = '$1';
        $items['title'] = preg_replace($pattern, $replacement, $parserTxt);

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        return $items;
    }

    private static function parseDebatepolitics($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));


        if(count($item = $html->find('li.lastnavbit span',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePolitikforum($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));


        if(count($item = $html->find('td.navbar strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseSovserv($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));


        if(count($item = $html->find('td.navbar strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseOperline($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );


        # Get data
//        $ch = curl_init($link);
//        curl_setopt($ch, CURLOPT_USERAGENT, 'IE20');
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');
//        $text = curl_exec($ch);
//        curl_close($ch);
//
//        echo $text;

        $html = str_get_html(self::getWebPage($link));


        if(count($item = $html->find('#bottomlogo h1',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }


//        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumEE($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        $title = $item = $html->find('title',0)->plaintext;

        if(count($item = $html->find('h1.ipsType_pagetitle',0)) > 0) {

            if (preg_match("/\berror\b/i", $title)) {
                $items['title'] = null;
            } else {
                $items['title'] = $item->plaintext;
            }
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseTochek($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        if(count($item = $html->find('.maintitle table tr td div b',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumnov($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        if(count($item = $html->find('.maintitle table tr td div b',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumVolgograd($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#posts .page table td.alt1 .smallfont strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumRealax($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#posts .alt1 .smallfont strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseInforeactor($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseSlovodel($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseNewinform($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#news-title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePolitexpert($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('#news-title',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePlanetaMoy($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.gDivLeft .gDivRight .gTable tbody tr td.gTableTop',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        if(empty($items['title'])){
            $item = $html->find('table table.eBlock tbody tr td .eTitle div',1);
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parseForumMoskva($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('table tbody tr td.navbar strong',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }

    private static function parsePikabu($link) {

        # Structure for return
        $item = null;

        $items = array(
            "isRemoved" => false,
            "title" => null,
            "viewCount" => null,
            "commentCount" => null
        );

        # Get data
        $html = str_get_html(self::getWebPage($link));

        if(count($item = $html->find('.story .story__main .story__header .story__header-title a',0)) > 0) {
            $items['title'] = $item->plaintext;
        }

        # Check exist
        if(empty($items['title']) and empty($items['viewCount'])
            and empty($items['commentCount'])) {
            $items['isRemoved'] = true;
        }

        $html->clear();
        $item = null;

        return $items;
    }


    private static function getWebPage($url) {

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec( $ch );
        curl_close($ch);

        return $content;
    }

    private static function forumName($link) {

        # Multi domain
        if(preg_match("/livejournal/", $link)) {
            return "livejournal.com";
        }

        if(preg_match("/dirty/", $link)) {
            return "dirty.ru";
        }

        if(preg_match("/mirtesen/", $link)) {
            return "mirtesen.ru";
        }

        $pattern = '/(https?)?:\/\/(www\.)?(.+)\.(ru|com|net|ws|info|su|ua|org|ee)(\/.+)?/';
        $replacement  = '$3.$4';
        $forumName = preg_replace($pattern, $replacement, trim($link));

        return $forumName;
    }

}

        $items = PostParser::parse('http://www.e-news.su/video/117756-otkrovennyy-razgovor-s-glavoy-respubliki-aleksandrom-zaharchenko-04062016.html');

        echo "isRemoved: " . $items['isRemoved'] . "<br/>";
        echo "title: " . $items['title'] . "<br/>";
        echo "viewCount: " . $items['viewCount'] . "<br/>";
        echo "commentCount: " . $items['commentCount'] . "<br/>";




