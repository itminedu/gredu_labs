<?php
/**
 * gredu_labs.
 *
 * @link https://github.com/eellak/gredu_labs for the canonical source repository
 *
 * @copyright Copyright (c) 2008-2015 Greek Free/Open Source Software Society (https://gfoss.ellak.gr/)
 * @license GNU GPLv3 http://www.gnu.org/licenses/gpl-3.0-standalone.html
 */

namespace GrEduLabs\Schools\Middleware;

class InputFilterSchoolAsset
{
    use InputFilterTrait;

    public function __construct(callable $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }
}
