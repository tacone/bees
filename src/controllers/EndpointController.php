<?php

namespace Tacone\Bees\Demo\Controllers;

use Tacone\Bees\Demo\Models\Article;
use Tacone\Bees\Widget\Endpoint;
use View;

class EndpointController extends DemoController
{
    public function anyIndex()
    {
        // load the data
        $model = Article::findOrNew(1);

        // instantiate the form
        $form = new Endpoint($model);

        // define the fields
        $form->text('title')->rules('required|max:10');
        $form->text('author.firstname', 'Author\'s first name')
            ->rules('required');
        $form->text('author.lastname');
        $form->textarea('detail.note');
        $form->textarea('body');
        $form->select('public')->options([
            0 => 'No',
            1 => 'Yes',
        ]);

        // read the POST data, if any
        $form->populate();

        // write new data back to the model
        $form->writeSource();

        // if the form has been sent, and has no errors
        if ($form->submitted() && $form->validate()) {
            // we will save the data in the database
            $form->save();
        }

        // we just need to pass the $form instance to the view
        return $form->toArray();
    }

}
