<?php
declare(strict_types=1);

namespace FreeStory\Story;


class StoryDirectory implements \Iterator
{
    /**
     * @var int 数据索引
     */
    protected $index;

    /**
     * 小说的id 在抓取的网站中的id
     * @var string $id
     */
    public $id;

    /**
     * 目录结果数据数组
     * @var array 数组内容 每一项都是 StoryItem
     */
    public  $directory = [];

    /**
     * 初始化数据
     * StoryDirectory constructor.
     *
     * @param $id
     * @param $data
     */
    function __construct($id,$data)
    {
        $this->id = $id;
        $this->directory = $data;
        $this->index = 0;
    }


    /**
     * 取得所有章节数
     *
     * @return int
     */
    public function totalNumber()
    {

        return count($this->directory);
    }

    /**
     * 获取最新的章节
     *
     * @return null | StoryItem
     */
    public function latest()
    {
        return $this->directory[$this->totalNumber() - 1];
    }

    /**
     * 获取第一章
     *
     * @return null | StoryItem
     */
    public function first()
    {
        return $this->directory[0];
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->index;
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->index;
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
        return $this->index;
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     *        Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
        return !$this->index < count($this->directory);

    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
        $this->index = 0;
    }


}
