<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $fillable = [
        'sponsor_id',
        'user_id',
        'upline_placement_id',
        'placement_position',
        'package',
        'count',
        'level'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public $level = 0;

    public function children($parent_id, $limit = 0)
    {
        $children = [];
        $this->getChildren($parent_id, $limit, $children);

        return collect($children);
    }

    public function isChild($parent_id)
    {
        return $this->traverseNetwork($parent_id, $this->user_id);
    }

    private function traverseNetwork($parent_id, $current_id, &$data = [])
    {
        if(array_key_exists($current_id, $data)) return $data[$current_id];

        $network = Network::where('user_id', $current_id)->first();

        if((int) $network->upline_placement_id < $parent_id)
            return false;

        if((int) $network->upline_placement_id !== $parent_id) {
            $data[$current_id] = false;
            return $this->traverseNetwork($parent_id, $network->upline_placement_id, $data);
        }

        return true;
    }

    private function getChildren($parent_id, $limit, &$children)
    {
        if($limit > 0 && count($children) >= $limit) return;

        $networks = Network::where('upline_placement_id', $parent_id)->get();
        if($networks && $networks->count() > 0) {
            $this->level++;
            $networks->each(function($network) use ($limit, &$children) {
                $children[$network->user_id] = $this->level;
                $this->getChildren($network->user_id, $limit, $children);
            });
        }
    }
}
