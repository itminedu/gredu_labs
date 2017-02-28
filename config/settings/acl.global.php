<?php
/**
 * gredu_labs
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */
return [
    'acl' => [
        'default_role' => 'guest',
        'roles' => [
            'guest' => [],
            'user' => [],
            'school' => ['user'],
            'admin' => ['user'],
        ],
        'resoures' => [],
        'guards' => [
            'resources' => [],
            'callables' => [],
            'routes' => [
                ['/', ['guest', 'user'], ['get']],
                ['/about', ['guest', 'user'], ['get']],
                ['/school', ['school'], ['get']],
                ['/school/labs', ['school'], ['get', 'post', 'delete']],
                ['/school/staff', ['school'], ['get', 'post', 'delete']],
                ['/school/assets', ['school'], ['get', 'post', 'delete']],
                ['/school/labs/attachment', ['school'], ['get', 'delete']],
                ['/school/software', ['school'], ['get', 'post', 'delete']],
                ['/application-form', ['school'], ['get', 'post']],
                ['/application-form/submit-success', ['school'], ['get']],
                ['/application-form/report', ['school'], ['get']],
                ['/application-form/approved', ['guest'], ['get']],
                ['/receive-equip', ['school'], ['get', 'post'], GrEduLabs\ReceiveEquip\Acl\Assertion\CanSubmit::class],
                ['/receive-equip/submit-success', ['school'], ['get']],
                ['/receive-equip/report', ['school'], ['get']],
                ['/receive-equip/receive-doc/{fn}', ['school'], ['get']],
                ['/tpe_survey', ['school'], ['get', 'post']],
                ['/tpe_survey/total-teachers', ['school'], ['post']],
                ['/forum', ['guest', 'user'], ['get']],
                ['/sch_sync/sync', ['school'], ['get']],
                ['/in_numbers', ['guest', 'user'], ['get']],
                ['/export/csv/edulabs_{type}.csv', ['guest', 'user'], ['get']],
                ['/open-data', ['guest', 'user'], ['get']],
                ['/university-form', ['guest'], ['get', 'post']],
                ['/university-form/submit-success',['guest'],['get']],
                ['/teacher-form', ['guest'], ['get', 'post']],
                ['/teacher-form/submit-success',['guest'], ['get','post']],
                ['/teacher-form/mm',['guest'], ['get']],
                ['/admin', ['admin'], ['get']],
                ['/admin/university-form/display', ['admin'], ['get']],
                ['/admin/teacher-form/display', ['admin'], ['get']],
            ],
        ],
    ],
];
