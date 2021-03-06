<?php

namespace Tacone\Bees\Demo\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Database\QueryException;
use Schema;
use Tacone\Bees\Demo\Documenter;
use Tacone\Bees\Demo\Models\Article;
use View;

class DemoController extends Controller
{
    public $views = [];
    public $widget = null;

    public function __construct()
    {
        error_reporting(-1);
        $me = $this;
        app()['events']->listen('composing:*', function ($view) use ($me) {
            if (!empty($view['form'])) {
                $this->widget = $view['form'];
            }
            if (!empty($view['grid'])) {
                $this->widget = $view['grid'];
            }
            $me->views[] = $view->getPath();
        });
        \View::share('demo', $this);
    }

    public function anyIndex()
    {
        try {
            Article::find(1);
        } catch (QueryException $e) {
            return '
         <div style="text-align: center;margin-top: 100px;">
<p><strong>Database error!</strong></p>
<p>&nbsp;</p>

<ol style="text-align: left;width: 300px; display: inline-block;">
    <li>create a database that matches your config files</li>
    <li><a href="/demo/setup">seed the DEMO database</a></li>
</ol>

</div>
            ';
        }

        return \Redirect::action('\Tacone\Bees\Demo\Controllers\FormController@anyIndex');
    }

    public function source()
    {
        list($controller, $method) = explode('@', \Route::current()->getAction()['controller']);

        $source = Documenter::showMethod($controller, [$method]);
        foreach ($this->views as $v) {
            if (!str_is('*/layout/*', $v)) {
                $source .= Documenter::showCode($v);
            }
        }

        return $source;
    }


    /**
     * Wipe out the demo data, so you can try out the demo
     * with an empty database.
     */
    public function getWipe()
    {
        DB::statement('SET foreign_key_checks=0');
        DB::table('demo_users')->truncate();
        DB::table('demo_articles')->truncate();
        DB::table('demo_article_detail')->truncate();
        DB::table('demo_comments')->truncate();
        DB::table('demo_categories')->truncate();
        DB::table('demo_article_category')->truncate();
        DB::statement('SET foreign_key_checks=1');
    }

    /**
     * Seed the data for the demo.
     */
    public function getSetup()
    {
        Schema::dropIfExists('demo_users');
        Schema::dropIfExists('demo_articles');
        Schema::dropIfExists('demo_article_detail');
        Schema::dropIfExists('demo_comments');
        Schema::dropIfExists('demo_categories');
        Schema::dropIfExists('demo_article_category');

        //create all tables
        Schema::table('demo_users', function ($table) {
            $table->create();
            $table->increments('id');
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->timestamps();
        });
        Schema::table('demo_articles', function ($table) {
            $table->create();
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->string('title', 200);
            $table->text('body');
            $table->string('photo', 200);
            $table->boolean('public');
            $table->timestamp('publication_date');
            $table->timestamps();
        });
        Schema::table('demo_article_detail', function ($table) {
            $table->create();
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->text('note');
            $table->string('note_tags', 200);
        });
        Schema::table('demo_comments', function ($table) {
            $table->create();
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('article_id')->unsigned();
            $table->text('comment');
            $table->timestamps();
        });
        Schema::table('demo_categories', function ($table) {
            $table->create();
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->string('name', 100);
            $table->timestamps();
        });
        Schema::table('demo_article_category', function ($table) {
            $table->create();
            $table->integer('article_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();
        });

        //populate all tables
        $users = DB::table('demo_users');
        $users->insert(array('firstname' => 'Jhon', 'lastname' => 'Doe'));
        $users->insert(array('firstname' => 'Jane', 'lastname' => 'Doe'));

        $categories = DB::table('demo_categories');
        for ($i = 1; $i <= 5; ++$i) {
            $categories->insert(array(
                    'name' => 'Category '.$i,
                )
            );
        }
        $articles = DB::table('demo_articles');
        for ($i = 1; $i <= 20; ++$i) {
            $articles->insert(array(
                    'author_id' => rand(1, 2),
                    'title' => 'Article '.$i,
                    'body' => 'Body of article '.$i,
                    'publication_date' => date('Y-m-d'),
                    'public' => true,
                )
            );
        }
        $categories = DB::table('demo_article_category');
        $categories->insert(array('article_id' => 1, 'category_id' => 1));
        $categories->insert(array('article_id' => 1, 'category_id' => 2));
        $categories->insert(array('article_id' => 20, 'category_id' => 2));
        $categories->insert(array('article_id' => 20, 'category_id' => 3));

        $comments = DB::table('demo_comments');
        $comments->insert(array(
                'user_id' => 1,
                'article_id' => 2,
                'comment' => 'Comment for Article 2',
            )
        );

        $files = glob(public_path().'/uploads/demo/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }

        echo 'All set!';
    }

    public function activeLink($action, $title = null, $parameters = array(), $attributes = array())
    {
        $same = $action == \Route::currentRouteAction();
        $same = $same && array_values(\Route::getCurrentRoute()->parameters()) == array_values($parameters);
        $active = $same ? ' class="active"' : '';

        return "<li$active>"
        .link_to_action($action, $title, $parameters, $attributes)
        .'</li>';
    }
}
