<?php
namespace Tacone\Bees\Demo\Models;

/**
 * ArticleDetail
 */
class ArticleDetail extends \Eloquent
{
    protected $table = 'demo_article_detail';
    public $timestamps = false;

    public function article()
    {
        return $this->belongsTo('\Tacone\Bees\Demo\Models\Article', 'article_id');
    }
}
