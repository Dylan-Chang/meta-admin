<?php

namespace App\Models;

use Input;
use DB;

class Tag extends BaseModel {

    protected $table = 'Tags';
    protected $fillable = [
        'name',
    ];

    /**
     * 定义订单与标签之间多对多关联关系
     *
     * @return BelongsToMany
     */
    public function orders() {
        return $this->belongsToMany('App\Models\Orderst', 'order_tag');
    }

    //更新关联
    public function updateRelation($oid) {
        $tags = Input::get('tags');

        /* Delete old. */
        DB::table('order_tag')->where('order_id', $oid)->delete();

        /* Insert new. */
        foreach ($tags as $value) {
            DB::table('order_tag')->insert(
                    ['tag_id' => $value, 'order_id' => $oid]
            );
        }
    }

    public function orderTag($id) {
        $tags = DB::table('order_tag')->where('order_id', $id)->select('tag_id')->get();
        $data = array();
        foreach ($tags as $value) {
            $data[$value->tag_id] = $value->tag_id;
        }
        return $data;
    }

    /**
     * Add any tags needed from the list
     *
     * @param array $tags List of tags to check/add
     */
    public static function addNeededTags(array $tags) {
        if (count($tags) === 0) {
            return;
        }

        $found = static::whereIn('name', $tags)->lists('name')->all();

        foreach (array_diff($tags, $found) as $tag) {
            static::create([
                'name' => $tag,
            ]);
        }
    }

}
