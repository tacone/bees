<?php

namespace Tacone\Bees\Demo\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Tacone\Bees\Demo\Models\Article;
use Tacone\Bees\Widget\Grid;
use View;

class GridController extends DemoController
{
    public function __construct()
    {
        parent::__construct();
        \View::share('sidebarText', '
        <div class="alert alert-info">
            <strong>Fun fact:</strong> if you just <code>return $grid->toArray();</code>
            from your controller method, you can use this widget like a mini JSON
            API &hearts;
        </div>
        ');
    }

    /**
     * A very simple grid.
     */
    public function anyIndex()
    {
        $grid = new Grid(Article::with('categories')->with('author'));
        $grid->text('id');
        $grid->text('title');
        $grid->text('author.fullname');
        $grid->text('categories', 'In category')->value(function ($v) {
            if ($v instanceof Collection) {
                return implode(', ', $v->lists('name'));
            }
        });
        $grid->select('public')->options([
            1 => 'Yes',
        ]);
        $grid->start->before[] = '<p><em>This is a very simple grid</em></p>';

        return View::make('bees::demo.grid-automatic', compact('grid'));
    }
//        $grid->select('Publish in')->options([
//            'home' => 'Frontpage',
//            'blog' => 'Blog',
//            'magazine' => 'Magazine',
//            'Other destinations' => [
//                'newsletter' => 'Newsletter',
//                'sponsor' => 'Main sponsor website',
//                'drafts' => 'Draft box',
//            ],
//        ]);
    public function anyCallback()
    {
        $grid = new Grid(new Article());
        $grid->text('id');
        $grid->text('title');
        $grid->text('author.firstname');
        $grid->text('author.lastname');
        $grid->text('categories.0.name', 'In category');
        $grid->start->before[] = '<p><em>Customized with a row callback</em></p>';
        $colors = ['success', 'warning', 'info', 'danger'];
        $counter = 0;
        $grid->prototype->output(function ($row) use (&$counter, $colors) {
            $row->class($colors[$counter]);
            if ($colors[$counter] == 'danger') {
                $row->end->after[] = '<tr><td colspan="1000" class="text-danger danger">
Warning: this item has been rejected by the moderators
</td></tr>';
            }
            $counter = ($counter + 1) % count($colors);
        });

        return View::make('bees::demo.grid-automatic', compact('grid'));
    }
}
