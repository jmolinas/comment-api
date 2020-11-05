<?php

namespace App\Services;

use App\Models\Comment;

class CommentTree
{
    protected $recursive = 0;

    public function __construct(Comment $comment)
    {
        $this->comments = $comment->get();
    }

    /**
     * Has Children
     *
     * @param array $rows
     * @param null|int $id
     *
     * @return boolean
     */
    protected function hasChildren(array $rows, $id)
    {
        foreach ($rows as $row) {
            if ($row['parent_id'] == $id)
                return true;
        }
        return false;
    }

    public function buildTree()
    {
        $this->comments;
        foreach ($this->comments as $comment) {
            $comment->children = array_values($this->comments->where('parent_id', $comment->id)->all());
        }
        $this->comments = $this->comments->where('parent_id', '');
        return $this->comments;
    }
}
