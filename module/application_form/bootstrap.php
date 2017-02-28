<?php
/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

return function (Slim\App $app) {
    $container = $app->getContainer();
    $events    = $container['events'];

    $events('on', 'app.autoload', function ($autoloader) {
        $autoloader->addPsr4('GrEduLabs\\ApplicationForm\\', __DIR__ . '/src/');
    });

    $events('on', 'app.services', function ($container) {

        $container[GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\Service\ApplicationFormService();
        };

        $container[GrEduLabs\ApplicationForm\InputFilter\ApplicationForm::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\InputFilter\ApplicationForm(
                $c->get(GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class),
                $c->get(GrEduLabs\Schools\Service\SchoolServiceInterface::class),
                $c->get(GrEduLabs\ApplicationForm\InputFilter\ApplicationFormItemCollection::class)
            );
        };

        $container[GrEduLabs\ApplicationForm\InputFilter\ApplicationFormItem::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\InputFilter\ApplicationFormItem(
                $c->get(GrEduLabs\Schools\Service\LabServiceInterface::class),
                $c->get(GrEduLabs\Schools\Service\AssetServiceInterface::class)
            );
        };

        $container[GrEduLabs\ApplicationForm\InputFilter\ApplicationFormItemCollection::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\InputFilter\ApplicationFormItemCollection(
                $c->get(GrEduLabs\ApplicationForm\InputFilter\ApplicationFormItem::class)
            );
        };

        $container[GrEduLabs\ApplicationForm\Action\ApplicationForm::class] = function ($c) {
            $settings = $c->get('settings');
            $currentVersion = $settings['application_form']['itemcategory']['currentversion'];
            return new GrEduLabs\ApplicationForm\Action\ApplicationForm(
                $c->get('view'),
                $c->get(GrEduLabs\Schools\Service\AssetServiceInterface::class),
                $c->get(GrEduLabs\Schools\Service\LabServiceInterface::class),
                $c->get(GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class),
                $c->get(GrEduLabs\ApplicationForm\InputFilter\ApplicationForm::class),
                $c->get('authentication_service'),
                $c->get('router')->pathFor('application_form.submit_success'),
                $currentVersion,
                $c
            );
        };

        $container[GrEduLabs\ApplicationForm\Action\SubmitSuccess::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\Action\SubmitSuccess(
                $c->get('view'),
                $c->get('router')->pathFor('application_form')
            );
        };

        $container[GrEduLabs\ApplicationForm\Action\ApplicationFormPdf::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\Action\ApplicationFormPdf(
                $c->get(GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class),
                $c->get('view')
            );
        };

        $container[GrEduLabs\ApplicationForm\Acl\Assertion\CanSubmit::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\Acl\Assertion\CanSubmit(
                $c->get('authentication_service'),
                $c->get(GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class)
            );
        };

        $container[GrEduLabs\ApplicationForm\Middleware\SchoolApplicationForm::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\Middleware\SchoolApplicationForm(
                $c->get('view'),
                $c->get(GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class),
                $c
            );
        };

        $container[GrEduLabs\ApplicationForm\Action\Approved::class] = function ($c) {
            return new GrEduLabs\ApplicationForm\Action\Approved(
                $c->get('view'),
                $c->get(GrEduLabs\Schools\Service\AssetServiceInterface::class),
                $c->get(GrEduLabs\Schools\Service\LabServiceInterface::class),
                $c->get(GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface::class)
            );
        };

    });

    $events('on', 'app.bootstrap', function ($app, $container) {
        $container['view']->getEnvironment()->getLoader()->prependPath(__DIR__ . '/templates');
        $container['router']->getNamedRoute('school')
                ->add(GrEduLabs\ApplicationForm\Middleware\SchoolApplicationForm::class);

        $app->group('/application-form', function () {
            $this->map(['get', 'post'], '', GrEduLabs\ApplicationForm\Action\ApplicationForm::class)
                ->add(GrEduLabs\Application\Middleware\AddCsrfToView::class)
                ->add('csrf')
                ->setName('application_form');
            $this->get('/submit-success', GrEduLabs\ApplicationForm\Action\SubmitSuccess::class)
                ->setName('application_form.submit_success');
            $this->get('/report', GrEduLabs\ApplicationForm\Action\ApplicationFormPdf::class)
                ->setName('application_form.report');
        })->add(GrEduLabs\Schools\Middleware\FetchSchoolFromIdentity::class);

        $app->get('/application-form/approved', GrEduLabs\ApplicationForm\Action\Approved::class)
            ->setName('application_form.approved');
    });
};
