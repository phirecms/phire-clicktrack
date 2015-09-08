<?php

namespace Phire\ClickTrack\Model;

use Phire\ClickTrack\Table;
use Phire\Model\AbstractModel;

class Click extends AbstractModel
{

    /**
     * Get all fields
     *
     * @param  int    $limit
     * @param  int    $page
     * @param  string $sort
     * @return array
     */
    public function getAll($limit = null, $page = null, $sort = null)
    {
        $order = $this->getSortOrder($sort, $page);

        if (null !== $limit) {
            $page = ((null !== $page) && ((int)$page > 1)) ?
                ($page * $limit) - $limit : null;

            return Table\Clicks::findAll([
                'offset' => $page,
                'limit'  => $limit,
                'order'  => $order
            ])->rows();
        } else {
            return Table\Clicks::findAll([
                'order'  => $order
            ])->rows();
        }
    }

    /**
     * Remove search logs
     *
     * @param  array $fields
     * @return void
     */
    public function remove(array $fields)
    {
        if (isset($fields['clear_all']) && ($fields['clear_all'])) {
            $search = new Table\Clicks();
            $search->delete(['id-' => null]);
        } else if (isset($fields['rm_clicks'])) {
            foreach ($fields['rm_clicks'] as $id) {
                $search = Table\Clicks::findById((int)$id);
                if (isset($search->id)) {
                    $search->delete();
                }
            }
        }
    }

    /**
     * Determine if list of clicks has pages
     *
     * @param  int $limit
     * @return boolean
     */
    public function hasPages($limit)
    {
        return (Table\Clicks::findAll()->count() > $limit);
    }

    /**
     * Get count of clicks
     *
     * @return int
     */
    public function getCount()
    {
        return Table\Clicks::findAll()->count();
    }

}
