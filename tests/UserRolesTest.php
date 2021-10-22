<?php

/**
 * @file Tests for UserRoles.
 */

namespace Rezfusion\Tests;

use Rezfusion\UserRoles;
use stdClass;

class UserRolesTest extends BaseTestCase
{
    public function testAdministratorRole()
    {
        $this->assertSame(UserRoles::administrator(), 'administrator');
    }

    public function testEditorRole()
    {
        $this->assertSame(UserRoles::editor(), 'editor');
    }

    public function testUserHasRoles()
    {
        $user = new stdClass;
        $user->roles = [];
        $this->assertFalse(UserRoles::userHasRoles($user, [UserRoles::editor()]));
        $this->assertFalse(UserRoles::userHasRoles($user, [UserRoles::administrator(), UserRoles::editor()]));
        $this->assertFalse(UserRoles::userHasAnyRole($user, [UserRoles::administrator(), UserRoles::editor()]));
        $this->assertFalse(UserRoles::userHasAnyRole($user, [UserRoles::editor()]));
        $user->roles = ['editor'];
        $this->assertTrue(UserRoles::userHasRoles($user, [UserRoles::editor()]));
        $this->assertFalse(UserRoles::userHasRoles($user, [UserRoles::administrator()]));
        $this->assertFalse(UserRoles::userHasRoles($user, [UserRoles::administrator(), UserRoles::editor()]));
        $this->assertTrue(UserRoles::userHasAnyRole($user, [UserRoles::administrator(), UserRoles::editor()]));
        $this->assertFalse(UserRoles::userHasAnyRole($user, ['invalid-user-role']));
        $user->roles = ['editor', 'administrator'];
        $this->assertTrue(UserRoles::userHasRoles($user, [UserRoles::editor()]));
        $this->assertTrue(UserRoles::userHasRoles($user, [UserRoles::administrator(), UserRoles::editor()]));
        $this->assertTrue(UserRoles::userHasAnyRole($user, [UserRoles::administrator(), UserRoles::editor()]));
        $this->assertFalse(UserRoles::userHasAnyRole($user, ['invalid-user-role']));
    }
}
