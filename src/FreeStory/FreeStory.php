<?php
namespace FreeStory;

use FreeStory\Story\StoryAbstract;
use FreeStory\Story\StoryDetail;
use FreeStory\Story\StoryDirectory;
use FreeStory\Story\StoryItem;


/**
 * 免费小说 网络抓取实现类
 * Class FreeStory
 *
 * @package FreeStory
 */
class FreeStory extends StoryAbstract
{


    /**
     * 取得贡献此算法的 贡献者 可以使名称 或者 url
     *
     * @return string
     */
    public function getContributor()
    {

        return "http://www.phpzc.net";
    }

    /**
     * 搜索小说返回搜索结果
     *
     * @param string $name
     *
     * @return StoryDetail 搜索的小说结果对象
     */
    public function search( $name)
    {

        return $this->search_20161026($name);

    }

    /**
     * 取目录结果
     *
     * @param string $id 小说目录地址
     *
     * @return StoryDirectory
     */
    public function getStoryDirectory( $id)
    {

        return $this->getStoryDirectory_20161026($id);

    }

    /**
     * 取得章节内容
     *
     * @param StoryItem $item 小说章节项
     *
     * @return string 单章内容
     */
    public function getContent(StoryItem $item)
    {
        return $this->getContent_20161026($item);
    }


    protected function request($url)
    {
        $curl = curl_init();
        $connectTimeout = 5;
        $timeout = 5;
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($curl);
        curl_close($curl);


        return $data;
    }

    protected function getMenu($match)
    {
        $menu = [];
        $i = 1 ;
        foreach ($match[2] as $k=>$v)
        {
            $menu[] = [
                'title'=>$v,
                'chap_id'=>(explode('/',rtrim($match[1][$k],'.html')))[3],
                'menu_num'=> $i,
            ];
            $i++;
        }

        return $menu;
    }

    protected function debug($data)
    {
        echo var_export($data,true).PHP_EOL;
    }




    protected function search_20161026($name)
    {
        $url = 'http://zhannei.baidu.com/cse/search?s=920895234054625192&q=' . $name;

        $data = $this->request($url);
        if (empty($data)) {
            return null;
        }

        $searchword = urldecode($name);

        //搜索记录是否存在
        $preg = "/<a cpos=\"title\" href=\"http:\/\/www.qu.la\/book\/(\d+)\/\" title=\"{$searchword}\" class=\"result-game-item-title-link\" target=\"_blank\">/s";

        $matchResult = preg_match($preg, $data, $match);

        if (empty($matchResult)) {
            return null;
        }else {
            //匹配描述信息
            $preg = "%style=\"width:110px;height:150px;\">(\s+)<img src=\"(.*?)\" alt=\"(.*?)\" class=\"result-game-item-pic-link-img\"(.*?)<a cpos=\"title\" href=\"http:\/\/www.qu.la\/book\/(\d+)\/\" title=\"{$searchword}\" class=\"result-game-item-title-link\" target=\"_blank\">(.*?)<p class=\"result-game-item-desc\">(.*?)<span class=\"result-game-item-info-tag-title preBold\">作者：<\/span>(.*?)<\/span>%s";

            preg_match_all($preg, $data, $match);

            preg_match('/(.*?)<\/p>(\s+)<div class="result-game-item-info">/s', $match[7][0], $desc);

            $desc = strip_tags($desc[1]);

            $obj = new StoryDetail($searchword, trim(ltrim(trim($match[8][0]), '<span>')), $match[2][0], $desc, $match[5][0] );

            return $obj;
        }
    }


    protected function getStoryDirectory_20161026($id)
    {

        // 获得目录页数据
        $url = 'http://www.qu.la/book/' . $id . '/';
        $data = $this->request($url);

        if (empty($data)) {
            return null;
        }

        $preg = '/<dl>(.*?)<\/dl>/s';
        $matchResult = preg_match($preg, $data, $match);
        if (empty($matchResult)) {
            return null;
        }

        //var_dump($match[1]);
        //$mulu = iconv("GB2312//IGNORE", "UTF-8//IGNORE", $match[1]);
        $mulu = $match[1];
        //提取具体章节数据
        //匹配出 章节对应页面
        $preg = '/<a style="" href="(.*?)">(.*?)<\/a>/s';
        $matchResult = preg_match_all($preg, $mulu, $match);
        //var_dump($matchResult);
        if (empty($matchResult)) {
            return null;
        }

        //取得目录 数据
        $menu = $this->getMenu($match);

        return new StoryDirectory($id,$menu);

    }


    protected function getContent_20161026(StoryItem $item)
    {
        // TODO: Implement getContent() method.
        $id = $item->id;
        $chap_id = $item->chap_id;

        $url = 'http://www.qu.la/book/'.$id.'/'.$chap_id.'.html';

        $data = $this->request($url);

        $preg = '/<div id="content">(.*?)<script>chaptererror\(\)\;<\/script>(.*?)<\/div>/s';
        $matchResult = preg_match($preg,$data,$match);

        if(!$matchResult)
            return '';

        //$content = iconv("GB2312//IGNORE","UTF-8//IGNORE",$match[1]) ;
        $content = $match[1] ;


        $content = str_replace('<br />',"\n",$content);
        $content = str_replace('&nbsp;','',$content);

        return $content;
    }
}




