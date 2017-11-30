<?

include 'simple_html_dom.php';

function actionTest() {

    $data = file_get_html('http://ria.ru/culture/20160125/1364770177.html');
    foreach($data->find('script,link,comment') as $tmp)$tmp->outertext = '';
    if($data->plaintext!='' and count($data->find('.article_header_title'))){
        foreach($data->find('.article_header_title') as $h1){
            echo '<h2>'.$h1->plaintext.'</h2></br>';
        }
    }




    $data->clear();
    unset($data);
}

actionTest();
