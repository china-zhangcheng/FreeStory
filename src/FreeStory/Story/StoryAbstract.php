<?php
declare(strict_types=1);

namespace FreeStory\Story;


abstract class StoryAbstract
{

    /**
     * 取得贡献此算法的 贡献者 可以使名称 或者 url
     *
     * @return string
     */
    abstract public function getContributor() :string;



    /**
     * 搜索小说返回搜索结果
     * @param string $name
     *
     * @return StoryDetail 搜索的小说结果对象
     */
    abstract public function search(string $name) ;


    /**
     * 取目录结果
     * @param string $id 小说id
     *
     *
     * @return StoryDirectory
     */
    abstract public function getStoryDirectory(string $id) ;

    /**
     * 取得章节内容
     * @param StoryItem $item 小说章节项
     *
     * @return string 单章内容
     */
    abstract public function getContent(StoryItem $item) ;
}