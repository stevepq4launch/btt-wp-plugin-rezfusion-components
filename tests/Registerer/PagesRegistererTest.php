<?php

namespace Rezfusion\Tests;

use Rezfusion\Actions;
use Rezfusion\Tests\TestHelper\TestHelper;
use Rezfusion\Tests\TestHelper\UserHelper;
use Rezfusion\UserRoles;

class PagesRegistererTest extends BaseTestCase
{
    private function doAdminMenu(): void
    {
        TestHelper::includeTemplateFunctions();
        do_action(Actions::adminMenu());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testPrepareReviewsMenuItem(): void
    {
        UserHelper::logInAdminUser();
        $this->doAdminMenu();
        $this->assertTrue(true);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testPrepareReviewsMenuItemForNonAdminUser(): void
    {
        $user = UserHelper::logInAdminUser();
        $user->roles = [UserRoles::editor()];
        $this->doAdminMenu();
        $this->assertTrue(true);
    }
}
