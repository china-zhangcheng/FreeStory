<?php
declare(strict_types=1);

namespace FreeStory\Story;

/**
 * 小说章节项
 * Class StoryItem
 *
 * @package FreeStory\Story
 */
class StoryItem
{

    /**
     * @var string 小说的id
     *
     */
    public $id;

    /**
     * @var 章节id
     */
    public $chap_id;

    /**
     * @var 章节名称
     */
    public $title;


    function __construct(string $chap_id,string $title,string $id)
    {
        $this->chap_id = $chap_id;
        $this->title = $title;
        $this->id = $id;
    }
}
