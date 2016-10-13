<?php
/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\ApplicationForm\Service;

use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

class ApplicationFormService implements ApplicationFormServiceInterface
{
    public function submit(array $data)
    {
        $appForm                      = R::dispense('applicationform');
        $appForm->school_id           = $data['school_id'];
        $appForm->comments            = $data['comments'];
        $appForm->submitted           = time();
        $appForm->submitted_by        = $data['submitted_by'];
        $items                        = [];
        foreach ($data['items'] as $itemData) {
            $item                  = R::dispense('applicationformitem');
            $item->lab_id          = $itemData['lab_id'];
            $item->itemcategory_id = $itemData['itemcategory_id'];
            $item->qty             = $itemData['qty'];
            $item->qtyacquired     = $itemData['qtyacquired'];
            $item->reasons         = $itemData['reasons'];
            $items[]               = $item;
        }
        if (!empty($items)) {
            $appForm->ownApplicationformitemList = $items;
        }

        R::store($appForm);

        return $this->exportApplicationForm($appForm);
    }

    public function findSchoolApplicationForm($schoolId)
    {
        $appForm = R::findOne('applicationform', ' school_id = ? ORDER BY id DESC', [$schoolId]);
        if (null === $appForm) {
            return;
        }

        return $this->exportApplicationForm($appForm);
    }

    /**
     * 
     * @param OODBBean $bean the application form bean
     * @param boolean $with_school_info if true, the name, eduadmin and regionadmin properties of the school are provided with the exported bean info
     * @return array
     */
    private function exportApplicationForm(OODBBean $bean, $with_school_info = false)
    {
        $appForm          = $bean->export();
        if ($with_school_info === true) {
            $appForm['school'] = $bean->school->name;
            $appForm['eduadmin'] = $bean->school->eduadmin->name;
            $appForm['regioneduadmin'] = $bean->school->eduadmin->regioneduadmin->name;
        }
        $appForm['items'] = array_map(function ($itemBean) use ($with_school_info) {
            return array_merge($itemBean->export(), [
                'lab'          => $itemBean->lab->name,
                'itemcategory' => $itemBean->itemcategory->name,
                'version'      => $itemBean->itemcategory->groupflag,
            ]);
        }, $bean->ownApplicationformitemList);

        return $appForm;
    }

    /**
     * Get all the approved applications
     * 
     * @return array The exported bean info from retrieved data
     */
    public function findApprovedSchoolApplicationForms()
    {
        $selectedAppForms = R::getAll('SELECT applicationform.* '
            . 'FROM applicationform '
            . 'JOIN school ON applicationform.school_id=school.id '
            . 'JOIN eduadmin ON school.eduadmin_id=eduadmin.id '
            . 'JOIN regioneduadmin ON eduadmin.regioneduadmin_id=regioneduadmin.id '
            . 'WHERE applicationform.approved=1 '
            . 'ORDER BY regioneduadmin.name, eduadmin.name, school.name');
        $appForms = R::convertToBeans('applicationform', $selectedAppForms);

        return array_map(function ($c) {
                return $this->exportApplicationForm($c, true);
            },
            $appForms
        );
    }

}
