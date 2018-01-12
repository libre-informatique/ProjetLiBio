<?php

/*
 * This file is part of the Lisem Project.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace SeedBatchBundle\Admin;

use Blast\Bundle\CoreBundle\Admin\CoreAdmin;
use Blast\Bundle\CoreBundle\Admin\Traits\Base as BaseAdmin;

class SeedFarmAdmin extends CoreAdmin
{
    use BaseAdmin;

    /**
     * @var string
     */
    protected $translationLabelPrefix = 'sil.seed_batch.seed_farm';

    protected $baseRouteName = 'admin_seed_batch_seed_farm';
    protected $baseRoutePattern = 'seed_batch/seed_farm';
}
