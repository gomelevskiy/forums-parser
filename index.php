<?php

include_once 'simple_html_dom.php';


class PostParser {

    private $link;
    private $typeLink;

    /* CONSTRUCTOR */
    public function __construct($link) {

        $this->link = $link;
        $this->typeLink = 'undefined';

        $links = array();
        $links = $this->links();

        foreach($links as $linkPattern => $typeLink) {

            if(preg_match("~$linkPattern~", $link)) {
                $this->typeLink = $typeLink;
                break;
            }

        }

    }

    /* ROUTE FUNCTION */
    public function parse() {

        if($this->typeLink == 'undefined') {
            return false;
        }

        $method = 'parse' . ucfirst($this->typeLink);

        return $this->$method();

    }

    /* SUB FUNCTIONS */
    private function getWebPage($url) {

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

    /* MAIN PARSE FUNCTIONS */
    //IPolk
    private function parseIpolk() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        // POST
        if(count($html->find('.topic-title')) > 0){
            $post = $html->find('.topic-title',0)->plaintext;
            $post = trim($post);
        }

        // AUTHOR
        if(count($html->find('.topic-info-author')) > 0) {
            $author = $html->find('.topic-info-author',0)->plaintext;
            $author = trim($author);
        }

        // VIEWS
        if(count($html->find('span.viewcount-info')) > 0) {
            $views = $html->find('span.viewcount-info',0)->plaintext;
            $views = trim($views);
        }

        // COMMENTS
        if($html->plaintext!='' and count($html->find('#comments'))>0){
            $comments = $html->find('#count-comments',0)->plaintext;
            $comments = trim($comments);
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Dirty
    private function parseDirty() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('.post_comments_page'))){

            // POST
            if(count($html->find('h3')) > 0) {
                $post = $html->find('h3',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('a.c_user')) > 0) {
                $author = $html->find('a.c_user',0)->plaintext;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('span.b-post_views')) > 0) {
                $views = $html->find('span.b-post_views',0)->plaintext;
                $views = trim($views);
            }
            // COMMENTS
            if(count($html->find('span.b-comments_count')) > 0) {
                $item = $html->find('span.b-comments_count',0)->plaintext;
                $comments = trim($item, "( )");
                $comments = trim($comments);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //New.Maxpark
    private function parseMaxpark() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('div[class=cont-block blue-block bord]'))){

            // POST
            if(count($html->find('.post-top h1')) > 0) {
                $post = $html->find('.post-top h1',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('.user-name')) > 0) {
                $author = $html->find('.user-name',0)->plaintext;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('.post-numbs .link-views')) > 0) {
                $views = $html->find('.post-numbs .link-views',0)->plaintext;
                $views = trim($views);
            }
            // COMMENTS
            if(count($html->find('.post-numbs .link-comms')) > 0) {
                $comments = $html->find('.post-numbs .link-comms',0)->plaintext;
                $comments = trim($comments);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //OkoPlanet
    private function parseOkoPlanet() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            // POST
            if(count($html->find('.ntitle strong')) > 0) {
                $post = $html->find('.ntitle strong',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('.category strong')) > 0) {
                $author = $html->find('.category strong',1)->plaintext;
                $author = trim($author);
            }
            // COMMENTS,VIEWS
            if(count($html->find('.category')) > 0) {
                $item = $html->find('.category',0)->plaintext;
                $pattern = '/^.+комментариев:\s\(([0-9]+)\).+$/';
                $replacement = '$1';
                $comments = preg_replace($pattern, $replacement, $item);
                $comments = trim($comments);

                $pattern = '/^.+просмотров:\s\s\(([0-9]+)\).*$/';
                $replacement = '$1';
                $views = preg_replace($pattern, $replacement, $item);
                $views = trim($views);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // ForUa
    private function parseForUa() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        $ch = curl_init();

        # SUB FORUM

        // Get sub forum link
        $pattern = '/^.+f=([0-9]+).+$/';
        $replacement = 'http://for-ua.info/viewforum.php?f=$1';
        $subForumLink = preg_replace($pattern, $replacement, $this->link);

        // Topic Id
        $pattern = '/^.+t=([0-9]+).*$/';
        $replacement = '$1';
        $topicId = preg_replace($pattern, $replacement, $this->link);

        // Loop pag
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = $this->getPageForUa($ch, $subForumLink, $indexPage);

            $postFromPage = $page->find('a.topictitle');

            foreach($postFromPage as $p) {

                if (preg_match("~$topicId~", $p->href)) {

                    // POST
                    $post = $p->plaintext;

                    // AUTHOR
                    $author = $p->parent()->next_sibling()->plaintext;

                    // VIEWS
                    $item = $p->parent()->next_sibling()->next_sibling()->find('span', 1)->plaintext;
                    $pattern = '/[^0-9]+/';
                    $views = preg_replace($pattern, '', $item);

                    // COMMENTS
                    $comments = $p->parent()->next_sibling()->next_sibling()->find('span', 0)->plaintext;

                    curl_close($ch);

                    return array(
                        'views' => $views,
                        'comments' => $comments,
                        'post' => $post,
                        'author' => $author,
                        'link' => $this->link
                    );
                }

            }
        }

        curl_close($ch);

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function loadHtmlForUa($ch, $url) {

        $cookie = dirname(__FILE__).'/PostParser/cookiesForUa.txt';

        curl_setopt($ch, CURLOPT_URL,$url);
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

        $response = curl_exec($ch);

        return str_get_html($response);

    }
    private function getPageForUa($ch, $url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '&start=' . ($page - 1) * 50;

        return $this->loadHtmlForUa($ch, $url);
    }

    // Politforums
    private function parsePolitforums() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # SUB FORUM

        // Get sub forum link
        $subForumLink = '';

        $explodeLink = explode('/', $this->link);
        for($i = 0; $i < count($explodeLink) - 1; $i++) {
            $subForumLink .= $explodeLink[$i] . '/';
        }

        // Post href
        $pattern = '/^.+politforums\.net(.+)$/';
        $replacement = '$1';
        $hrefPost = preg_replace($pattern, $replacement, $this->link);

        // Loop page
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = $this->getPagePolitforums($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $hrefPost . ']');

            if(count($postFromPage) == 2) {

                // POST
                $post = trim($page->find('a[href=' . $hrefPost . ']', 0)->parent()->plaintext);

                // COMMENTS
                $comments = trim($page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->find('td', 3)->plaintext);

                // AUTHOR
                $author = trim($page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->find('td', 2)->plaintext);

                // VIEWS
                $item = $page->find('a[href=' . $hrefPost . ']', 0)->onmouseover;
                $pattern = '/^.+<\/b>([0-9]+)<br>.*$/';
                $replacement = '$1';
                $views = trim(preg_replace($pattern, $replacement, $item));

                break;
            }
        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPagePolitforums($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= ($page - 1) . '/';

        return str_get_html($this->getWebPage($url));
    }

    // ForumRcmir
    private function parseForumRcmir() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # AUTH
        $ch = curl_init();
        if(!$this->authForumRcmir($ch)) {
            return array(
                'views' => $views,
                'comments' => $comments,
                'post' => $post,
                'author' => $author,
                'link' => $this->link
            );
        }

        # SUB FORUM

        // Get sub forum link
        $html = $this->loadHtmlForumRcmir($ch, $this->link);
        $p = $html->find('span.nav', 0)->find('a');
        $subForumLink = 'http://forum.rcmir.com/' . $p[count($p) - 2]->href;

        // Get post href
        $item = explode('/', $this->link);
        $hrefPost = $item[count($item) - 1];

        // Loop page
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = $this->getPageForumRcmir($ch, $subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $hrefPost . ']');

            if(count($postFromPage) > 0) {

                // POST
                $post = $postFromPage[0]->plaintext;

                // AUTHOR
                $author = $postFromPage[0]->parent()->parent()->next_sibling()->find('a', 1)->plaintext;

                // COMMENTS
                $item = $postFromPage[0]->parent()->parent()->next_sibling()->next_sibling()->plaintext;
                $pattern = '/[^0-9]+/';
                $comments = preg_replace($pattern, '', $item);

                // VIEWS
                $item = $postFromPage[0]->parent()->parent()->next_sibling()->next_sibling()->next_sibling()->plaintext;
                $views = preg_replace($pattern, '', $item);

                break;
            }
        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function authForumRcmir($ch) {

        $cookie = dirname(__FILE__) . '/PostParser/cookiesRcmir.txt';
        $url = "http://www.rcmir.com/login.php";
        $post = "username=serejahuker&password=serejahuker&login=   Вход   ";

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36");
        curl_setopt($ch, CURLOPT_REFERER, "http://www.rcmir.com/index.php");
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);//Подставляем куки раз
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); //Подставляем куки два
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        $response = mb_convert_encoding($response, 'utf8', 'cp1251');
        $response = str_get_html($response);

        if($response->find('a[href=http://www.rcmir.com/index.php]', 0)->plaintext == 'Привет, serejahuker') {
            return true;
        }

        return false;
    }
    private function loadHtmlForumRcmir($ch, $url) {

        $cookie = dirname(__FILE__).'/PostParser/cookiesRcmir.txt';

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.116 Safari/537.36");
        curl_setopt($ch, CURLOPT_REFERER, "http://www.rcmir.com/index.php");
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);//Подставляем куки раз
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); //Подставляем куки два
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $response = curl_exec($ch);
        $response = mb_convert_encoding($response, 'utf8', 'cp1251');

        return str_get_html($response);

    }
    private function getPageForumRcmir($ch, $url, $page) {

        if($url == '') {
            return false;
        }

        $pattern = '/.html/';
        $url = preg_replace($pattern, '', $url);
        $url .= '_' . ($page - 1) * 50 . '.html';

        return $this->loadHtmlForumRcmir($ch, $url);
    }

    // Tehnowar
    private function parseTehnowar() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            // POST
            if(count($html->find('.story-full h1')) > 0) {
                $post = $html->find('.story-full h1',0)->plaintext;
                $post = trim($post);
            }
            // VIEWS
            if(count($html->find('.nav-story li')) > 0) {
                $item = $html->find('.nav-story li', 2)->plaintext;
                $pattern = '/[^0-9]+/';
                $views = preg_replace($pattern, '', $item);
            }

            // COMMENTS
            if(count($html->find('#dle-comm-link .comnum')) > 0) {
                $comments = $html->find('#dle-comm-link .comnum',0)->plaintext;
                $comments = trim($comments);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Sc2tv
    private function parseForumSc2tv() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # SUB FORUM
        // Get sub forum link
        $subForumLink = '';

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
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
        $idPost = preg_replace($pattern, $replacement, $this->link);

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = $this->getPageSc2tv($subForumLink, $indexPage);

            $postFromPage = $page->find('a[id=thread_title_' . $idPost . ']');

            if(count($postFromPage) > 0) {

                // POST
                $post = $page->find('a[id=thread_title_' . $idPost . ']', 0)->plaintext;

                // AUTHOR
                $author = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->find('.author a', 0)->plaintext;

                // VIEWS
                $item = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->parent()->parent()->find('ul li', 1)->plaintext;
                $pattern = '/[^0-9]+/';
                $views = preg_replace($pattern, '', $item);

                // COMMENTS
                $item = $page->find('a[id=thread_title_' . $idPost . ']', 0)->parent()->parent()->parent()->parent()->find('ul li', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $comments = preg_replace($pattern, '', $item);

                break;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPageSc2tv($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '/page' . $page;

        return str_get_html($this->getWebPage($url));
    }

    private function parse3mv() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!=''){

            // POST
            if(count($html->find('.niImg h1')) > 0) {
                $post = $html->find('.niImg h1',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('.userTitle a')) > 0) {
                $author = $html->find('.userTitle a',0)->plaintext;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('div.niViews')) > 0) {
                $views = $html->find('div.niViews', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $views = preg_replace($pattern, '', $views);
            }
            // COMMENTS
            if(count($html->find('div.niComments')) > 0) {
                $comments = $html->find('div.niComments', 0)->plaintext;
                $comments = preg_replace($pattern, '', $comments);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Trueinform
    private function parseTrueinform() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('body'))){

            // POST
            if(count($html->find('title')) > 0) {
                $post = $html->find('title',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('.author')) > 0) {
                $item = $html->find('.author');
                if (count($item) > 0) {
                    $author = $item[0]->plaintext;
                }
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('span.tiny')) > 0) {
                $item = $html->find('span.tiny',0)->title;
                $pattern = '/Прочтено:\s([0-9]+)/';
                $replacement = '$1';
                $views = preg_replace($pattern, $replacement, $item);
                $views = trim($views);
            }
            // COMMENTS
            if(count($html->find('a[title=\'комментарии участника\']')) > 0) {
                $comments = count($html->find("a[title='комментарии участника']"));
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Vtomske
    private function parseForumVtomske() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        # SUB FORUM

        // Get sub forum link
        $item = $html->find('.navi-cat-title', 2)->find('span', 0)->find('a');
        $subForumLink = 'http://forum.vtomske.ru' . $item[count($item) - 1]->href;

        // Get post href
        $pattern = '/http:\/\/forum.vtomske.ru/';
        $hrefPost = preg_replace($pattern, '', $this->link);

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = $this->getPageVtomske($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $hrefPost . ']');

            if(count($postFromPage) > 0) {

                // POST
                if(count($html->find('a[href=')) > 0) {
                    $post = $page->find('a[href=' . $hrefPost . ']', 0)->plaintext;
                }
                // AUTHOR
                if(count($html->find('a[href=' . $hrefPost . ']')) > 0) {
                    $author = $page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->find('div.topic-bottom', 0)->
                    find('b', 0)->plaintext;
                }
                // VIEWS
                $item = $page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->find('div.topic-bottom', 0)->plaintext;
                $item = explode('|', $item);
                $pattern = '/[^0-9]+/';
                $views = preg_replace($pattern, '', $item[count($item) - 1]);

                // COMMENTS
                $item = $page->find('a[href=' . $hrefPost . ']', 0)->parent()->parent()->prev_sibling()->find('span', 0)->plaintext;
                $comments = preg_replace($pattern, '', $item);

                break;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPageVtomske($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '&page=' . $page;

        return str_get_html($this->getWebPage($url));
    }

    // Pandoraopen
    private function parsePandoraopen() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('.post'))){

            // POST
            if(count($html->find('.title')) > 0) {
                $post = $html->find('.title',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('#stats span a')) > 0) {
                $author = $html->find('#stats span a',1)->plaintext;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('#stats span')) > 0) {
                $item = $html->find('#stats span',1)->plaintext;
                $pattern = '/Просмотров\s\-\s([0-9]+)/';
                $replacement = '$1';
                $views = preg_replace($pattern, $replacement, $item);
                $views = trim($views);
            }
            // COMMENTS
            if(count($html->find('span.viewcount-info')) > 0) {
                $item = $html->find('a[href=#comments]', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $comments += (int)preg_replace($pattern, '', $item);
            }
            if(preg_match('/[Оо]дин/', $item)) {
                $comments++;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Politobzor
    private function parsePolitobzor() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            // POST
            if(count($html->find('.cont .cont_inner h1')) > 0) {
                $post = $html->find('.cont .cont_inner h1',0)->plaintext;
                $post = trim($post);
            }
            // COMMENTS
            if(count($html->find('.data a b')) > 0) {
                $comments = $html->find('.data a b',0)->plaintext;
                $comments = trim($comments);
            }
            // AUTHOR
            if(count($html->find('.data div.linline')) > 0) {
                $item = $html->find('.data div.linline');
                $item = $item[1]->find('a');
                $author = $item[0]->title;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('.data div.linline')) > 0) {
                $item = $html->find('.data div.linline');
                $item = $item[2]->find('div');
                $views = $item[0]->plaintext;
                $views = trim($views);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Yaplakal
    private function parseYaplakal() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#content-inner'))){

            // POST
            if(count($html->find('h1.subpage')) > 0) {
                $post = $html->find('h1.subpage',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('span.normalname')) > 0) {
                $author = $html->find('span.normalname',0)->plaintext;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('.activeuserstrip td')) > 0) {
                $item = $html->find('.activeuserstrip td',1)->plaintext;
                $pattern = '/^.+темы:\s([0-9]+).*/';
                $replacement = '$1';
                $views = preg_replace($pattern, $replacement, $item);
            }
            // COMMENTS

            $item = $html->find("a[title='Переход на страницу...']");
            if(count($item) > 0) {
                $item = $item[0]->onclick;
                $pattern = "/^.+',0,([0-9]+),.+$/";
                $replacement = '$1';
                $comments = trim(preg_replace($pattern, $replacement, $item));
            } else {
                $comments = count($html->find('.postdetails')) - 1;
            }

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Smolensk
    private function parseForumSmolensk() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#page-body'))){

            // POST
            if(count($html->find('h2 a')) > 0) {
                $post = $html->find('h2 a',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('p.author')) > 0) {
                $author = $html->find('p.author', 0)->find('a', 1)->plaintext;
            }
            // VIEWS
            $html = str_get_html($this->getWebPage('http://forum.smolensk.ws/search.php?keywords=' . urlencode($post)));

            $pattern = '/^.+forum\.smolensk\.ws\/viewtopic\.php\?f=([0-9]+)&t=([0-9]+)$/';
            $replacement = '/$2/';
            $maket = preg_replace($pattern, $replacement, $this->link);


            foreach ($html->find('.postbody a') as $item){


                if (preg_match($maket,$item->href)){
                    if(count($html->find('dl.postprofile')) > 0) {
                        $item = $html->find('dl.postprofile', 0)->find('dd', 5)->plaintext;
                        $pattern = '/[^0-9]+/';
                        $views = preg_replace($pattern, '', $item);
                    }
                    if(count($html->find('dl.postprofile')) > 0) {
                        $item = $html->find('dl.postprofile', 0)->find('dd', 4)->plaintext;
                        $pattern = '/[^0-9]+/';
                        $comments = preg_replace($pattern, '', $item);
                    }
                    break;
                }

            }

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Warfiles
    private function parseWarfiles() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            // POST
            if(count($html->find('.cont .cont_inner h1')) > 0) {
                $post = $html->find('.cont .cont_inner h1',0)->plaintext;
                $post = trim($post);
            }
            // COMMENTS
            if(count($html->find('.data a b')) > 0) {
                $comments = $html->find('.data a b',0)->plaintext;
                $comments = trim($comments);
            }
            // AUTHOR
            if(count($html->find('.data div.linline')) > 0) {
                $item = $html->find('.data div.linline');
                $item = $item[1]->find('a');
                $author = $item[0]->title;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('.data div.linline')) > 0) {
                $item = $html->find('.data div.linline');
                $item = $item[2]->find('div');
                $views = $item[0]->plaintext;
                $views = trim($views);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Fishki
    private function parseFishki() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('body'))){

            // POST
            if(count($html->find('title')) > 0) {
                $post = $html->find('title',0)->plaintext;
                $post = trim($post);
            }
            // AUTHOR
            if(count($html->find('.post_content .author a')) > 0) {
                $author = $html->find('.post_content .author a',0)->plaintext;
                $author = trim($author);
            }
            // VIEWS
            if(count($html->find('.post-stats-wrap span')) > 0) {
                $views = $html->find('.post-stats-wrap span',1)->plaintext;
                $views = trim($views);
            }
            // COMMENTS
            if(count($html->find('.stats-likes-wrap .post-stats-wrap a')) > 0) {
                $comments = $html->find('.stats-likes-wrap .post-stats-wrap a',0)->plaintext;
                $comments = trim($comments);
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Novorus
    private function parseNovorus() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            // POST
            if(count($html->find('.post h1')) > 0) {
                $post = $html->find('.post h1',0)->plaintext;
                $post = trim($post);
            }
            // VIEWS
            if(count($html->find('.rate div[style="text-align: center;"] b')) > 0) {
                $views = $html->find('.rate div[style="text-align: center;"] b',0)->plaintext;
                $views = trim($views);
            }

            // COMMENTS
            if(count($html->find('span.viewcount-info')) > 0) {
                $comments = count($html->find('span.viewcount-info'));
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Politrussia
    private function parsePolitrussia() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        if($html->plaintext!='' and count($html->find('#center'))){

            // POST
            $post = $html->find('.h1[itemprop="name"]',0)->plaintext;
            $post = trim($post);

            // AUTHOR
            $author = $html->find('meta[itemprop="author"]',0)->content;
            $author = trim($author);

            // GET ARID FOR VIEWS AND COMMENTS
            $pattern = '/^.+ARID:\s+\"([0-9]+)\".+$/';
            $replacement = '$1';
            $ARID = trim(preg_replace($pattern, $replacement, $html));

            // REQUEST FOR VIEWS AND COMMENTS
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://politrussia.com/views/c/getViewAndComment.php?ARID%5B%5D=' . $ARID);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);

            $result = curl_exec($curl);
            $mas = json_decode($result, true);

            curl_close($curl);

            // VIEWS
            $views = $mas[$ARID]['VIEW'];

            //COMMENTS
            $comments = $mas[$ARID]['COMMENT'];
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Nashaplaneta News
    private function parseNashaplanetaNews() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE

        // POST
        $item = $html->find('.eTitle',0)->plaintext;
        $pattern = '/^[0-9]{2}:[0-9]{2}\s+(.+)$/';
        $replacement = '$1';
        $post = trim(preg_replace($pattern, $replacement, $item));

        // VIEWS
        $item = $html->find('.eDetails',0);
        $pattern = '/^.+Просмотров.*:\s+([0-9]+)\s+.+$/';
        $replacement = '$1';
        $views = trim(preg_replace($pattern, $replacement, $item));

        // AUTHOR
        $author = trim($item->find('a',7)->plaintext);

        // COMMENTS
        $pattern = "/^.+Всего комментариев<\!--<\/s>-->:\s+<b>([0-9]+)<\/b>.+$/";
        $replacement = '$1';
        $comments = trim(preg_replace($pattern, $replacement, $html));


        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Nashaplaneta Forum
    private function parseNashaplanetaForum() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        # SUB FORUM LINK

        // Get sub forum link
        $item = $html->find('.forumNamesBar a', 2);
        $subForumLink = $item->href;

        // Loop page
        for($indexPage = 1; $indexPage < 20; $indexPage++) {

            $page = $this->getNashaplanetaForum($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $this->link . ']');

            if(count($postFromPage) > 0) {

                // POST
                $post = $postFromPage[0]->plaintext;

                // AUTHOR
                $author = $postFromPage[0]->parent()->parent()->find('.threadAuthTd', 0)->plaintext;

                // COMMENTS
                $comments = $postFromPage[0]->parent()->parent()->find('.threadPostTd', 0)->plaintext;

                // VIEWS
                $views = $postFromPage[0]->parent()->parent()->find('.threadViewTd', 0)->plaintext;

                break;
            }
        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getNashaplanetaForum($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '-0-' . ($page);

        $html = str_get_html($this->getWebPage($url));

        return str_get_html($html);
    }

    //Publikatsii
    private function parsePublikatsii() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE

        // POST
        $post = trim($html->find('.title',0)->plaintext);

        //AUTHOR
        $author = trim($html->find('.date a',1)->plaintext);

        //VIEWS
        $views = trim($html->find('.views-num',0)->plaintext);

        //COMMENTS
        $comments = trim($html->find('.comment-num',0)->plaintext);

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // KalmiusInfo
    private function parseKalmiusInfo() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE

        // POST
        $post = trim($html->find('#news-title h1',0)->plaintext);

        //VIEWS
        $item = $html->find('.views',0);
        $pattern = '/^.+Просмотров:\s([0-9]+).+$/';
        $replacement = '$1';
        $views = trim(preg_replace($pattern, $replacement, $item));

        //AUTHOR
        $author = trim($html->find('#authorbox h4 a',0)->plaintext);

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Newsland
    private function parseNewsland() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!=''){

            //POST
            $post = trim($html->find('.post-top h1',0)->plaintext);

            //AUTHOR
            $item = $html->find('a.link-author');
            if(count($item) > 0) {
                $author = $item[0]->plaintext;
            }
            $item = $html->find('span.user-name');
            if(count($item) > 0) {
                $author = $item[0]->plaintext;
            }

            //VIEWS
            $views = trim($html->find('a.link-views',0)->plaintext);

            //COMMENTS
            $comments = trim($html->find('a.link-comms',0)->plaintext);
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Pikabu
    private function parsePikabu() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#wrap'))){

            //POST
            $post = trim($html->find('.b-story__header-info h1',0)->plaintext);

            //COMMENTS
            $item = $html->find('.b-story__header-additional span a',0)->plaintext;
            $pattern = '/[^0-9]+/';
            $comments = trim(preg_replace($pattern, '', $item));

            //AUTHOR
            $author = trim($html->find('.b-story__header-additional span a',1)->plaintext);

            // VIEWS
            $item = $html->find('div.b-story__rating');
            if(count($item) > 0) {
                $views = $item[0]->getAttribute('data-pluses') + $item[0]->getAttribute('data-minuses');
            }

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Gratis
    private function parseGratis() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # SUB FORUM

        // Get sub forum link
        $pattern = '/^.+f=([0-9]+)&.+$/';
        $replacement = '$1';
        $subForumLink = 'http://www.gratis.pp.ru/index.php?s=&act=SF&f=' . preg_replace($pattern, $replacement, $this->link);

        // Loop page
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = $this->getPageGratis($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $this->link . ']');

            if(count($postFromPage) > 0) {

                // POST
                $post = $page->find('a[href=' . $this->link . ']', 0)->plaintext;

                // AUTHOR
                $author = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->parent()->
                parent()->parent()->parent()->find('td', 5)->plaintext;

                // COMMENTS
                $comments = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->parent()->
                parent()->parent()->parent()->find('td', 6)->plaintext;

                // VIEWS
                $views = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->parent()->
                parent()->parent()->parent()->find('td', 7)->plaintext;

                break;
            }
        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );


    }
    private function getPageGratis($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '&prune_day=100&sort_by=Z-A&sort_key=last_post&st=' . ($page - 1) * 50;

        $html = str_get_html($this->getWebPage($url));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');

        return str_get_html($html);
    }

    //XTrue
    private function parseXTrue() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            //POST
            $post = trim($html->find('h1.post_title',0)->plaintext);

            //AUTHOR
            $author = trim($html->find('div.full_post_meta_item',1)->plaintext);

            //VIEWS
            $views = trim($html->find('div.full_counters .stories_views',0)->plaintext);

            //COMMENTS
            $comments = trim($html->find('div.full_counters .stories_comments',0)->plaintext);
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    //Cont
    private function parseCont() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('.author-bar2-inside'))){

            //POST
            $post = trim($html->find('h1',0)->plaintext);

            //AUTHOR
            $author = trim($html->find('.m_author',0)->plaintext);

            //VIEWS
            $item = $html->find('.dark .author-bar2-inside',0);
            $pattern = '/^.+glyphicon-eye-open\"><\/span>\s+([0-9]+).+glyphicon-comment.+$/';
            $replacement = '$1';
            $views = trim(preg_replace($pattern, $replacement, $item));

            //COMMENTS
            $pattern = '/^.+glyphicon-comment\"><\/span>\s+([0-9]+).+glyphicon-signal.+$/';
            $replacement = '$1';
            $comments = trim(preg_replace($pattern, $replacement, $item));
        }


        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );


    }

    // Mpsh
    private function parseMpsh() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            //POST
            $post = trim($html->find('h1',0)->plaintext);

            //AUTHOR
            $author = trim($html->find('.full-info div a',0)->plaintext);

            //VIEWS
            $item = $html->find('.full-info div',1)->plaintext;
            $pattern = '/Прочитали\s\-\s+([0-9]+)+$/';
            $replacement = '$1';
            $views = trim(preg_replace($pattern, $replacement, $item));

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );


    }

    //Operline
    private function parseOperline() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

               if($html->plaintext!='' and count($html->find('#bottomlogo'))){

            //POST
            $post = trim($html->find('h1',0)->plaintext);

            //AUTHOR
            $author = trim($html->find('.dateit b',0)->plaintext);

            //VIEWS
            $views = trim($html->find('.looks',0)->plaintext);

            //COMMENTS
            $comments = trim($html->find('.comments',0)->plaintext);
        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );

    }

    // Perevodika
    private function parsePerevodika() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('.main_td'))){

            //POST
            $post = trim($html->find('h1',0)->plaintext);

            //VIEWS
            $item = $html->find('em',0);
            $pattern = '/^.+\s+([0-9]+)\s+.+$/';
            $replacement = '$1';
            $views = trim(preg_replace($pattern, $replacement, $item));

            //AUTHOR
            $item = $html->find('.logins',0)->plaintext;
            $mas_str = explode("скаут:", $item);
            $mas_str = explode(";", $mas_str[1]);
            $author = trim($mas_str[0]);

            // COMMENTS
            $item = $html->find('div.modern-page-navigation');
            if(count($item) > 0) {

                $item = $item[0]->find('a');
                $indexLastPage = count($item);
                $linkLastPage = 'http://perevodika.ru' . $item[count($item) - 2]->href;

                $comments += 10 * ($indexLastPage - 1);

                $html = str_get_html($this->getWebPage($linkLastPage));
            }

            $item = $html->find('table.forum-reviews-messages');
            if(count($item) > 0) {
                $comments += count($item[0]->find('.controls-reviews'));
            }

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );


    }

    //Politikus
    private function parsePolitikus() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('#dle-content'))){

            //POST
            $post = trim($html->find('h1',0)->plaintext);

            //AUTHOR
            $item = $html->find('.fullstory div',1);
            $author = trim($item->find('a',0)->plaintext);

            //COMMENTS
            $item = $item->find('#dle-comm-link',0)->plaintext;
            $pattern = '/^.+\s+([0-9]+)$/';
            $replacement = '$1';
            $comments = trim(preg_replace($pattern, $replacement, $item));

            //VIEWS
            $item = $html->find('.fullstory div',1);
            $pattern = '/^.+Просм.+\s+([0-9]+)\s+.+$/';
            $replacement = '$1';
            $views = trim(preg_replace($pattern, $replacement, $item));

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // ForumTopwar
    private function parseForumTopwar() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        # SUB FORUM

        // Get sub forum link
        $item = $html->find('ul[itemtype=http://schema.org/BreadcrumbList] li');
        $subForumLink = $item[count($item) - 2]->find('a', 0)->href;

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = $this->getPageForumTopwar($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $this->link . ']');

            if(count($postFromPage) == 1) {

                // POST
                $post = $page->find('a[href=' . $this->link . ']', 0)->plaintext;

                // AUTHOR
                $author = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->find('div.ipsDataItem_meta', 0)->find('a', 0)->plaintext;

                // VIEWS
                $views = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->next_sibling()->find('li', 1)->find('span', 0)->plaintext;

                // COMMENTS
                $comments = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->next_sibling()->find('li', 0)->find('span', 0)->plaintext;

                break;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPageForumTopwar($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '?page=' . $page;

        return str_get_html($this->getWebPage($url));
    }

    //ForumYkt
    private function parseForumYkt() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        # PARSE
        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('.f-view'))){

            //POST
            $post = trim($html->find('.f-view_title',0)->plaintext);

            //AUTHOR
            $author = trim($html->find('.f-view_creator_name',0)->plaintext);

            //VIEWS
            $views = trim($html->find('.post-views',0)->plaintext);

            //COMMENTS
            $comments = trim($html->find('.f-comments_count',0)->plaintext);

        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }

    // Yarportal
    private function parseYarportal() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # SUB FORUM

        // Get sub forum link
        $subForumLink = '';

        $html = str_get_html($this->getWebPage($this->link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='') {
            $subForumLink = $html->find('.activeuserstrip a', 0)->href;
        }

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = $this->getPageYarportal($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $this->link . ']');

            if(count($postFromPage) == 1) {

                $td = $page->find('a[href=' . $this->link . ']', 0)->parent()->parent()->find('td');

                $post = trim($td[2]->find('a', 0)->plaintext);
                $author = trim($td[3]->find('a', 0)->plaintext);
                $comments = trim($td[4]->find('a', 0)->plaintext);
                $views = trim($td[5]->plaintext);

                break;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPageYarportal($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '?prune_day=100&sort_by=Z-A&sort_key=last_post&st=' . ($page - 1) * 21;

        $html = str_get_html($this->getWebPage($url));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');

        return str_get_html($html);
    }

    // ENews
    private function parseENews() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        # SUB FORUM

        // Get sub forum link
        $item = $html->find('div.news-meta', 2)->find('a');
        $subForumLink = $item[count($item) - 1]->href;

        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = $this->getPageENews($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $this->link . ']');

            if(count($postFromPage) > 0) {

                // POST
                $post = $postFromPage[0]->plaintext;

                // VIEWS
                $item = $postFromPage[0]->parent()->parent()->prev_sibling()->find('div.news-info', 0)->find('div', 1)->plaintext;
                $pattern = '/[^0-9]+/';
                $views = preg_replace($pattern, '', $item);

                // COMMENTS
                $comments = $postFromPage[0]->parent()->parent()->prev_sibling()->find('div.news-info', 0)->find('div', 2)->plaintext;

                break;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );


    }
    private function getPageENews($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= 'page/' . $page . '/';

        return str_get_html($this->getWebPage($url));
    }

    // Jediru
    private function parseJediru() {;

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        # SUB FORUM LINK

        // Get sub forum link
        $item = $html->find('#brd-crumbs-top', 0)->find('a');
        $subForumLink = $item[count($item) - 1]->href;

        // Loop page
        for($indexPage = 1; $indexPage < 50; $indexPage++) {

            $page = $this->getPageJediru($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $this->link . ']');

            if(count($postFromPage) > 0) {

                // POST
                $post = $postFromPage[0]->plaintext;

                // AUTHOR
                $author = $postFromPage[0]->parent()->next_sibling()->find('cite', 0)->plaintext;

                // COMMENTS
                $item = $postFromPage[0]->parent()->parent()->next_sibling()->find('.info-replies strong', 0)->plaintext;
                $pattern = '/[^0-9]+/';
                $comments = preg_replace($pattern, '', $item);

                // VIEWS
                $item = $postFromPage[0]->parent()->parent()->next_sibling()->find('.info-views strong', 0)->plaintext;
                $views = preg_replace($pattern, '', $item);

                break;
            }
        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPageJediru($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= 'page/' . $page . '/';

        return str_get_html($this->getWebPage($url));
    }

    //Publizist
    private function parsePublizist() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # GET CONTENT
        $html = str_get_html($this->getWebPage($this->link));

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='' and count($html->find('.layout_middle'))){

            //POST
            $post = trim($html->find(' h2',0)->plaintext);

            //AUTHOR
            $author = trim($html->find('.blog_entrylist_entry_date a',0)->plaintext);

            //VIEWS
            $item = trim($html->find('.blog_entrylist_entry_date',0)->plaintext);
            $pattern = '/^.+-(.+)\s+(просмотр?(а)?(ов)?).+$/';
            $replacement = '$1';
            $views = trim(preg_replace($pattern, $replacement, $item));

            //COMMENTS
            $item = trim($html->find('.comments_options',0)->plaintext);

            if ($item == false){
                $comments = "0";
            }
            else{
                $pattern = '/^([0-9]+).+$/';
                $replacement = '$1';
                $comments = trim(preg_replace($pattern, $replacement, $item));
            }

        }

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );

    }

    // E1
    private function parseE1() {

        # MAIN
        $views = 0;
        $comments = 0;
        $post = 'none';
        $author = 'none';

        # SUB FORUM

        // Get sub forum link
        $subForumLink = '';

        $html = str_get_html($this->getWebPage($this->link));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');
        $html = str_get_html($html);

        foreach($html->find('script,link,comment') as $tmp) {
            $tmp->outertext = '';
        }

        if($html->plaintext!='') {
            $pattern = '/^.+read\.php\?f=([0-9]+)&.+$/';
            $replacement = 'www.e1.ru/talk/forum/list.php?f=$1';
            $subForumLink = trim(preg_replace($pattern, $replacement, $this->link));
        }

        $pattern = '/^.+www\.e1\.ru\/[A-z]+\/[A-z]+\/(read\.php.+)$/';
        $replacement = '$1';
        $linkNew = trim(preg_replace($pattern, $replacement, $this->link));


        // Loop page
        for($indexPage = 1; $indexPage < 30; $indexPage++) {

            $page = $this->getPageE1($subForumLink, $indexPage);

            $postFromPage = $page->find('a[href=' . $linkNew . ']');

            if(count($postFromPage) == 1) {

                // POST
                $post = $postFromPage[0]->plaintext;

                // AUTHOR
                $author = $postFromPage[0]->parent()->parent()->find('.registered_user', 0)->plaintext;

                // COMMENTS
                $comments = $postFromPage[0]->parent()->parent()->find('td', 2)->plaintext;

                // VIEWS
                $views = $postFromPage[0]->parent()->parent()->find('td', 3)->plaintext;

                break;
            }
        }

        $html->clear();

        # RETURN
        return array(
            'views' => $views,
            'comments' => $comments,
            'post' => $post,
            'author' => $author,
            'link' => $this->link
        );
    }
    private function getPageE1($url, $page) {

        if($url == '') {
            return false;
        }

        $url .= '&t=' . ($page - 1);

        $html = str_get_html($this->getWebPage($url));
        $html = mb_convert_encoding($html, 'utf8', 'cp1251');

        return str_get_html($html);
    }

    private function links() {

        return array(
            '^https?://ipolk\.ru.+$' => 'ipolk',
            '^https?://.+\.dirty\.ru.+$' => 'dirty',
            '^https?://new\.maxpark\.com.+$' => 'maxpark',
            '^https?://oko-planet\.su.+$' => 'okoPlanet',
            '^https?://for-ua\.info.+$' => 'forUa',
            '^https?://(www\.)?politforums\.net.+$' => 'politforums',
            '^https?://forum\.rcmir\.com.+$' => 'forumRcmir',
            '^https?://tehnowar\.ru.+$' => 'tehnowar',
            '^https?://forum\.sc2tv\.ru.+$' => 'forumSc2tv',
            '^https?://3mv\.ru.+$' => '3mv',
            '^https?://trueinform\.ru.+$' => 'trueinform',
            '^https?://forum\.vtomske\.ru.+$' => 'forumVtomske',
            '^https?://pandoraopen\.ru.+$' => 'pandoraopen',
            '^https?://politobzor\.net.+$' => 'politobzor',
            '^https?://(www\.)?yaplakal\.com.+$' => 'yaplakal',
            '^https?://forum\.smolensk\.ws.+$' => 'forumSmolensk',
            '^https?://warfiles\.ru.+$' => 'warfiles',
            '^https?://fishki\.net.+$' => 'fishki',
            '^https?://novorus\.info.+$' => 'novorus',
            '^https?://politrussia\.com.+$' => 'politrussia',
            '^https?://nashaplaneta\.su\/news\/.+$' => 'nashaplanetaNews',
            '^https?://nashaplaneta\.su\/forum\/.+$' => 'nashaplanetaForum',
            '^https?://publikatsii\.ru.+$' => 'publikatsii',
            '^https?://kalmius-info\.ru.+$' => 'kalmiusInfo',
            '^https?://newsland\.com.+$' => 'newsland',
            '^https?://pikabu\.ru.+$' => 'pikabu',
            '^https?://(www\.)?gratis\.pp\.ru.+$' => 'gratis',
            '^https?://x-true\.info.+$' => 'XTrue',
            '^https?://cont\.ws.+$' => 'cont',
            '^https?://mpsh\.ru.+$' => 'mpsh',
            '^https?://operline\.ru.+$' => 'operline',
            '^https?://perevodika\.ru.+$' => 'perevodika',
            '^https?://politikus\.ru.+$' => 'politikus',
            '^https?://forum\.topwar\.ru.+$' => 'forumTopwar',
            '^https?://forum\.ykt\.ru.+$' => 'forumYkt',
            '^https?://yarportal\.ru.+$' => 'yarportal',
            '^https?://(www\.)?e-news\.su.+$' => 'ENews',
            '^https?://jediru\.net.+$' => 'Jediru',
            '^https?://publizist\.ru.+$' => 'Publizist',
            '^https?://(www\.)?e1\.ru.+$' => 'e1'
        );

    }

}

$url = 'http://tehnowar.ru/43558-eto-uzhe-ne-nachalo-izbiratelnoy-kampanii-eto-uzhe-nachalo-grazhdanskoy-voyny.html';

$postParser = new PostParser($url);
$data = $postParser->parse();

echo 'Post: ' . $data['post'] . '<br>';
echo 'Author: ' . $data['author'] . '<br>';
echo 'Views: ' . $data['views'] . '<br>';
echo 'Comments: ' . $data['comments'] . '<br>';
echo 'Likes: ' . $data['likes'] . '<br>';