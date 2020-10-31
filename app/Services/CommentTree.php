<?php

namespace App\Services;

use App\Models\Comment;

class CommentTree
{
    public function __construct(Comment $comment)
    {
        $this->comments = $comment->get()->toArray();
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

    /**
     * Build html tree
     *
     * @param array $rows
     * @param null|int $parent
     *
     * @return string
     */
    protected function tree(array $rows, $parent = null)
    {
        $result = [];
        foreach ($rows as $row) {
            if ($row['parent_id'] == $parent) {
                $data = $row;
                if ($this->hasChildren($rows, $row['id'])) {
                    $data['children'] =  $this->tree($rows, $row['id']);
                }
                $result[] = $data;
            }
        }
        return $result;
    }

    public function buildTree()
    {
        return $this->tree($this->comments);
    }
}
