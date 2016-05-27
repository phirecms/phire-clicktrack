<?php
/**
 * Phire ClickTrack Module
 *
 * @link       https://github.com/phirecms/phire-clicktrack
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\ClickTrack\Model;

use Phire\ClickTrack\Table;
use Phire\Model\AbstractModel;

/**
 * Click Model class
 *
 * @category   Phire\ClickTrack
 * @package    Phire\ClickTrack
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
class Click extends AbstractModel
{

    /**
     * Get all fields
     *
     * @param  string $type
     * @param  int    $limit
     * @param  int    $page
     * @param  string $sort
     * @return array
     */
    public function getAll($type = null, $limit = null, $page = null, $sort = null)
    {
        $order = $this->getSortOrder($sort, $page);

        if (null !== $limit) {
            $page = ((null !== $page) && ((int)$page > 1)) ?
                ($page * $limit) - $limit : null;

            if (null !== $type) {
                $rows = Table\Clicks::findBy(['type' => $type], [
                    'offset' => $page,
                    'limit'  => $limit,
                    'order'  => $order
                ])->rows();
            } else {
                $rows = Table\Clicks::findAll([
                    'offset' => $page,
                    'limit'  => $limit,
                    'order'  => $order
                ])->rows();
            }
        } else {
            if (null !== $type) {
                $rows = Table\Clicks::findBy(['type' => $type], [
                    'order' => $order
                ])->rows();
            } else {
                $rows = Table\Clicks::findAll([
                    'order' => $order
                ])->rows();
            }
        }

        foreach ($rows as $i => $row) {
            $rows[$i]->uniques = count(unserialize($row->ips));
        }

        return $rows;
    }

    /**
     * Save content click
     *
     * @param  string $uri
     * @param  string $type
     * @return void
     */
    public function saveContent($uri, $type)
    {
        $ip    = $_SERVER['REMOTE_ADDR'];
        $click = Table\Clicks::findBy(['uri' => $uri, 'type' => $type]);
        if (isset($click->id)) {
            $click->clicks++;
            $ips = unserialize($click->ips);
            if (!in_array($ip, $ips)) {
                $ips[]      = $ip;
                $click->ips = serialize($ips);
            }
            $click->save();
        } else {
            $click = new Table\Clicks([
                'uri'    => $uri,
                'type'   => $type,
                'clicks' => 1,
                'ips'    => serialize([$ip])
            ]);
            $click->save();
        }
    }

    /**
     * Save file click
     *
     * @param  string $file
     * @return void
     */
    public function saveMedia($file)
    {
        $ip    = $_SERVER['REMOTE_ADDR'];
        $click = Table\Clicks::findBy(['uri' => $file, 'type' => 'media']);
        if (isset($click->id)) {
            $click->clicks++;
            $ips = unserialize($click->ips);
            if (!in_array($ip, $ips)) {
                $ips[]      = $ip;
                $click->ips = serialize($ips);
            }
            $click->save();
        } else {
            $click = new Table\Clicks([
                'uri'    => $file,
                'type'   => 'media',
                'clicks' => 1,
                'ips'    => serialize([$ip])
            ]);
            $click->save();
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
     * @param  int    $limit
     * @param  string $type
     * @return boolean
     */
    public function hasPages($limit, $type = null)
    {
        if (null !== $type) {
            return (Table\Clicks::findBy(['type' => $type])->count() > $limit);
        } else {
            return (Table\Clicks::findAll()->count() > $limit);
        }
    }

    /**
     * Get count of clicks
     *
     * @param  string $type
     * @return int
     */
    public function getCount($type = null)
    {
        if (null !== $type) {
            return Table\Clicks::findBy(['type' => $type])->count();
        } else {
            return Table\Clicks::findAll()->count();
        }
    }

}
