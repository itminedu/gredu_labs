<?php
/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */
namespace GrEduLabs\UniversityForm\Action;

use GrEduLabs\UniversityForm\Service\UniversityFormServiceInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\InputFilter\InputFilterInterface;

class UniversityForm
{
    /**
     * @var Twig
     */
    protected $view;
    /**
     *
     * @var UniversityFormServiceInterface
     */
    protected $UniversityFormService;
    /**
     *
     * @var InputFilterInterface
     */
    protected $UniversityFormInputFilter;
    /**
     *
     * @var AuthenticationServiceInterface
     */
    protected $authService;
    /**
     *
     * @var type SLIM application container
     */
    protected $container;
    /**
     *
     * @var string
     */
    protected $successUrl;

    public function __construct(
    Twig $view, UniversityFormServiceInterface $UniversityFormService, InputFilterInterface $UniversityFormInputFilter2,InputFilterInterface $UniversityFormInputFilter1, $successUrl,$container
    )
     {
        $this->view                    = $view;
        $this->UniversityFormService   = $UniversityFormService;
        $this->UniversityFormInputFilter = $UniversityFormInputFilter1;
        $this->UniversityFormInputFilter2 = $UniversityFormInputFilter2;
        $this->UniversityFormInputFilter1 = $UniversityFormInputFilter1;
        $this->successUrl =             $successUrl;
        $this->container               = $container;
    }

    public function __invoke(Request $req, Response $res)
    {

       
        if ($req->isPost()) {
            $reqParams = $req->getParams();

            if (isset($reqParams['newselect'])&& $reqParams['newselect']=='ereunitika')
            {
                $this->UniversityFormInputFilter = $this->UniversityFormInputFilter2;
            }
            else    
            {
                $this->UniversityFormInputFilter = $this->UniversityFormInputFilter1;
            }

            $this->UniversityFormInputFilter->setData($reqParams);
            $isValid = $this->UniversityFormInputFilter->isValid();      

            if ($isValid) {
                
                $data =                            $this->UniversityFormInputFilter->getValues();
                $UniversityForm =                  $this->UniversityFormService->submit($data);
                $_SESSION['UnivForm']['uForm'] =   $UniversityForm;
                $res =                             $res->withRedirect($this->successUrl);
               return $res;
           } 
           else {
                
                $this->view['form'] = [

                'is_valid' => $isValid,
                'values' => $this->UniversityFormInputFilter->getValues(),
                'raw_values' => $this->UniversityFormInputFilter->getRawValues(),
                'messages' => $this->UniversityFormInputFilter->getMessages()
            ];
            $res = $this->view->render($res, 'university_form/form.twig', []);
                } 
    }
    else
    {
        $res = $this->view->render($res, 'university_form/form.twig', [
                ]);
       return $res;

    }
}
}