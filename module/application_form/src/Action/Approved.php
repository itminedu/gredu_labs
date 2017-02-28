<?php

/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\ApplicationForm\Action;

use GrEduLabs\ApplicationForm\Service\ApplicationFormServiceInterface;
use GrEduLabs\Schools\Service\AssetServiceInterface;
use GrEduLabs\Schools\Service\LabServiceInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class Approved {

    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var AssetServiceInterface
     */
    protected $assetsService;

    /**
     * @var LabServiceInterface
     */
    protected $labService;

    /**
     * @var ApplicationFormServiceInterface
     */
    protected $appFormService;

    public function __construct(
    Twig $view, AssetServiceInterface $assetsService, LabServiceInterface $labService, ApplicationFormServiceInterface $appFormService
    ) {
        $this->view = $view;
        $this->assetsService = $assetsService;
        $this->labService = $labService;
        $this->appFormService = $appFormService;
    }

    public function __invoke(Request $req, Response $res) {
        $appForms = $this->appFormService->findApprovedSchoolApplicationForms();
        return $this->view->render($res, 'application_form/approved.twig', [
            'approved_forms' => $appForms
        ]);
    }

}
