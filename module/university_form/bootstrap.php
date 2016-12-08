<?php

use Slim\App;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

return function (App $app) {
    $container = $app->getContainer();
    $events    = $container['events'];

$events('on', 'app.autoload', function ($autoloader) {
        $autoloader->addPsr4('GrEduLabs\\UniversityForm\\', __DIR__ . '/src/');
    });

$events('on', 'app.services', function ($container) {

        $container[GrEduLabs\UniversityForm\Service\UniversityFormServiceInterface::class] = function ($c) {
            return new GrEduLabs\UniversityForm\Service\UniversityFormService();
        };

        $container[GrEduLabs\UniversityForm\InputFilter\UniversityForm::class] = function ($c) {
            return new GrEduLabs\UniversityForm\InputFilter\UniversityForm();
        };

        $container[GrEduLabs\UniversityForm\InputFilter\UniversityForm1::class] = function ($c) {
            return new GrEduLabs\UniversityForm\InputFilter\UniversityForm1();
        };

	    $container[GrEduLabs\UniversityForm\Action\UniversityForm::class] = function ($c) {
               return new GrEduLabs\UniversityForm\Action\UniversityForm(
                $c->get('view'),
                $c->get(GrEduLabs\UniversityForm\Service\UniversityFormServiceInterface::class),
                $c->get(GrEduLabs\UniversityForm\InputFilter\UniversityForm::class),
                $c->get(GrEduLabs\UniversityForm\InputFilter\UniversityForm1::class),
                $c->get('router')->pathFor('university_form.submit_success'),
                $c);
        };




        $container[GrEduLabs\UniversityForm\Action\SubmitSuccess::class] = function ($c) {
            return new GrEduLabs\UniversityForm\Action\SubmitSuccess(
                $c->get('view'),
                $c->get('router')->pathFor('university_form')
            );
        };

});

$events('on', 'app.bootstrap', function ($app, $container) {
        $container['view']->getEnvironment()->getLoader()->prependPath(__DIR__ . '/templates');

      $app->group('/university-form', function () {
            $this->map(['get', 'post'], '', GrEduLabs\UniversityForm\Action\UniversityForm::class)
                ->add(GrEduLabs\Application\Middleware\AddCsrfToView::class)
                ->add('csrf')
                ->setName('university_form');
            $this->get('/submit-success', GrEduLabs\UniversityForm\Action\SubmitSuccess::class)
                ->setName('university_form.submit_success');
  
     });
    });

};