<?php
namespace FreeStory\Story;


class StoryDetail
{
    /**
     * @var 小说标题
     */
    public $title;

    /**
     * @var 小说作者
     */
    public $author;

    /**
     * @var 小说封面图片地址
     */
    public $face_image_url;


    /**
     * @var 小说简短说明
     */
    public $short_description;


    /**
     * @var string 小说在抓取的网站中的id
     */
    public $id;

    function __construct($title = '',$author = '',$face_image_url = '',$short_description = '', $id = '')
    {
        $this->title = $title;
        $this->author = $author;
        $this->face_image_url = $face_image_url;
        $this->short_description = $short_description;
        $this->id = $id;
    }


}