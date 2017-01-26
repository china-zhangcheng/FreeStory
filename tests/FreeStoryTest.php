<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/1/26
 * Time: 下午4:15
 */
use PHPUnit\Framework\TestCase;

use FreeStory\FreeStory;
use FreeStory\Story\StoryDirectory;
use FreeStory\Story\StoryItem;

class FreeStoryTest extends TestCase
{

    public function testSearch()
    {
        $free = new FreeStory();

        $searchword = '天域苍穹';
        $desc = $free->search($searchword);

        $this->assertNotEmpty($desc);

    }
}