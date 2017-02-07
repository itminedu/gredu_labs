<?php
/**
 * gredu_labs.
 * 
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

use GrEduLabs\Schools\Action;
use GrEduLabs\Schools\InputFilter;
use GrEduLabs\Schools\Middleware;
use GrEduLabs\Schools\Service;

return function (Slim\App $app) {

    $container = $app->getContainer();
    $events    = $container['events'];

    $events('on', 'app.autoload', function ($autoloader) {
        $autoloader->addPsr4('GrEduLabs\\Schools\\', __DIR__ . '/src/');
    });

    $events('on', 'app.services', function ($container) {

        // actions

        $container[Action\Index::class] = function ($c) {
            return new Action\Index(
                $c->get('view'),
                $c->get(Service\StaffServiceInterface::class),
                $c->get(Service\LabServiceInterface::class),
                $c->get(Service\SchoolAssetsInterface::class)
            );
        };

        $container[Action\Staff\ListAll::class] = function ($c) {
            return new Action\Staff\ListAll(
                $c->get('view'),
                $c->get(Service\StaffServiceInterface::class)
            );
        };

        $container[Action\Staff\PersistTeacher::class] = function ($c) {
            return new Action\Staff\PersistTeacher(
                $c->get(Service\StaffServiceInterface::class)
            );
        };

        $container[Action\Staff\DeleteTeacher::class] = function ($c) {
            return new Action\Staff\DeleteTeacher(
                $c->get(Service\StaffServiceInterface::class),
                $c->get('logger')
            );
        };

        $container[Action\Lab\ListAll::class] = function ($c) {
            return new GrEduLabs\Schools\Action\Lab\ListAll(
                $c->get('view'),
                $c->get(Service\LabServiceInterface::class),
                $c->get(Service\StaffServiceInterface::class)
            );
        };

        $container[Action\Lab\PersistLab::class] = function ($c) {
            return new Action\Lab\PersistLab(
                 $c->get(Service\LabServiceInterface::class)
            );
        };

        $container[Action\Lab\DeleteLab::class] = function ($c) {
            return new Action\Lab\DeleteLab(
                $c->get(Service\LabServiceInterface::class)
            );
        };

        $container[Action\Lab\DownloadAttachment::class] = function ($c) {
            $settings = $c->get('settings');
            $uploadTargetPath = $settings['schools']['file_upload']['target_path'];

            return new Action\Lab\DownloadAttachment(
                $c->get(Service\LabServiceInterface::class),
                $uploadTargetPath
            );
        };

        $container[Action\Lab\RemoveAttachment::class] = function ($c) {
            return new Action\Lab\RemoveAttachment(
                $c->get(Service\LabServiceInterface::class)
            );
        };

        $container[Action\Assets\ListAssets::class] = function ($c) {
            $settings = $c->get('settings');
            $currentVersion = $settings['application_form']['itemcategory']['currentversion'];
            return new Action\Assets\ListAssets(
                $c->get('view'),
                $c->get(Service\AssetServiceInterface::class),
                $c->get(Service\SchoolAssetsInterface::class),
                $c->get(Service\LabServiceInterface::class),
                $currentVersion
            );
        };

        $container[Action\Assets\PersistAsset::class] = function ($c) {
            return new Action\Assets\PersistAsset(
                $c->get(Service\SchoolAssetsInterface::class)
            );
        };

        $container[Action\Assets\DeleteAsset::class] = function ($c) {
            return new Action\Assets\DeleteAsset(
                $c->get(Service\SchoolAssetsInterface::class)
            );
        };

        $container[Action\Software\ListAll::class] = function ($c) {
            return new Action\Software\ListAll(
                $c->get('view'),
                $c->get(Service\SoftwareServiceInterface::class),
                $c->get(Service\LabServiceInterface::class)
            );
        };

        $container[Action\Software\PersistSoftware::class] = function ($c) {
            return new Action\Software\PersistSoftware(
                $c->get(Service\SoftwareServiceInterface::class)
            );
        };

        $container[Action\Software\DeleteSoftware::class] = function ($c) {
            return new Action\Software\DeleteSoftware(
                $c->get(Service\SoftwareServiceInterface::class)
            );
        };

        // services

        $container['schoolservice'] = function ($c) {
            return $c->get(Service\SchoolServiceInterface::class);
        };

        $container['staffservice'] = function ($c) {
            return $c->get(Service\StaffServiceInterface::class);
        };

        $container['labservice'] = function ($c) {
            return $c->get(Service\LabServiceInterface::class);
        };

        $container[Service\SchoolServiceInterface::class] = function ($c) {
            return new Service\SchoolService();
        };

        $container[Service\StaffServiceInterface::class] = function ($c) {
            return new Service\StaffService();
        };

        $container[Service\LabServiceInterface::class] = function ($c) {
            $settings = $c->get('settings');
            $uploadTargetPath = $settings['schools']['file_upload']['target_path'];

            return new Service\LabService($uploadTargetPath);
        };

        $container[Service\SoftwareServiceInterface::class] = function ($c) {
            return new Service\SoftwareService();
        };

        $container[Service\AssetServiceInterface::class] = function ($c) {
            return new Service\AssetService();
        };

        $container[Service\SchoolAssetsInterface::class] = function ($c) {
            return $c->get(Service\AssetServiceInterface::class);
        };

        // middleware 

        $container[Middleware\InputFilterTeacher::class] = function ($c) {
            return new Middleware\InputFilterTeacher(
                $c->get(InputFilter\Teacher::class)
            );
        };

        $container[Middleware\InputFilterLab::class] = function ($c) {
            return new Middleware\InputFilterLab(
                $c->get(InputFilter\Lab::class)
            );
        };

        $container[Middleware\InputFilterSchoolAsset::class] = function ($c) {
            return new Middleware\InputFilterSchoolAsset(
                $c->get(InputFilter\SchoolAsset::class)
            );
        };

        $container[Middleware\InputFilterSoftware::class] = function ($c) {
            return new Middleware\InputFilterSoftware(
                $c->get(InputFilter\Software::class)
            );
        };

        $container[Middleware\FetchSchoolFromIdentity::class] = function ($c) {
            return new Middleware\FetchSchoolFromIdentity($c['authentication_service']);
        };

        // inputfilters

        $container[InputFilter\Teacher::class] = function ($c) {
            return new InputFilter\Teacher();
        };

        $container[InputFilter\SchoolAsset::class] = function ($c) {
            return new InputFilter\SchoolAsset(
                $c->get(Service\LabServiceInterface::class),
                $c->get(Service\AssetServiceInterface::class)
            );
        };

        $container[InputFilter\School::class] = function ($c) {
            return new InputFilter\School(
                $c->get(Service\SchoolServiceInterface::class)
            );
        };

        $container[InputFilter\Lab::class] = function ($c) {
            $settings = $c->get('settings');
            $uploadTmpPath = $settings['schools']['file_upload']['tmp_path'];
            $attachmentSize = $settings['schools']['file_upload']['max_size'];

            return new InputFilter\Lab(
                $uploadTmpPath,
                $c->get(Service\LabServiceInterface::class),
                $attachmentSize
            );
        };

        $container[InputFilter\Software::class] = function ($c) {
            return new InputFilter\Software();
        };

    });

    $events('on', 'app.bootstrap', function ($app, $container) {
        $container['view']->getEnvironment()->getLoader()->prependPath(__DIR__ . '/templates');

        $app->group('/school', function () {

            $this->get('', Action\Index::class)->setName('school');

            $this->get('/staff', Action\Staff\ListAll::class)->setName('school.staff');
            $this->post('/staff', Action\Staff\PersistTeacher::class)
                ->add(Middleware\InputFilterTeacher::class);
            $this->delete('/staff', Action\Staff\DeleteTeacher::class);

            $this->get('/labs', Action\Lab\ListAll::class)->setName('school.labs');
            $this->post('/labs', Action\Lab\PersistLab::class)
                ->add(Middleware\InputFilterLab::class);
            $this->delete('/labs', Action\Lab\DeleteLab::class);
            $this->get('/labs/attachment', Action\Lab\DownloadAttachment::class)
                ->setName('school.labs.attachment');
            $this->delete('/labs/attachment', Action\Lab\RemoveAttachment::class);

            $this->get('/assets', Action\Assets\ListAssets::class)->setName('school.assets');
            $this->post('/assets', Action\Assets\PersistAsset::class)
                ->add(Middleware\InputFilterSchoolAsset::class);
            $this->delete('/assets', Action\Assets\DeleteAsset::class);

            $this->get('/software', Action\Software\ListAll::class)->setName('school.software');
            $this->post('/software', Action\Software\PersistSoftware::class)
                ->add(Middleware\InputFilterSoftware::class);
            $this->delete('/software', Action\Software\DeleteSoftware::class);

        })->add(Middleware\FetchSchoolFromIdentity::class);
    });
};
