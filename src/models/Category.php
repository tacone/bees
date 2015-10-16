<?php
namespace Tacone\Bees\Demo\Models;

/**
 * Category
 */
class Category extends \Eloquent
{
    protected $table = 'demo_categories';

    public function articles()
    {
        return $this->belongsToMany('\Tacone\Bees\Demo\Models\Article', 'demo_article_category', 'category_id', 'article_id');
    }

    public function parent()
    {
        return $this->belongsTo('\Tacone\Bees\Demo\Models\Category', 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany('\Tacone\Bees\Demo\Models\Category', 'parent_id');
    }
}
