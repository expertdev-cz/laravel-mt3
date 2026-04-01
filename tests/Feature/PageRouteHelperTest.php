<?php

namespace Tests\Feature;

use App\Attributes\PageRouteAction;
use App\Helpers\PageRouteHelper;
use Tests\TestCase;

class PageRouteHelperTest extends TestCase
{
    /**
     * Test that getControllers returns all controllers in the app/Http/Controllers directory.
     */
    public function test_get_controllers_returns_all_controllers(): void
    {
        $controllers = PageRouteHelper::getControllers();

        // Check that the array is not empty
        $this->assertNotEmpty($controllers);

        // Check that the PagesController is included
        $this->assertArrayHasKey('App\Http\Controllers\PagesController', $controllers);

        // Check that the controller name is correctly extracted
        $this->assertEquals('PagesController', $controllers['App\Http\Controllers\PagesController']);
    }

    /**
     * Test that getActions returns an empty array for non-existent controller.
     */
    public function test_get_actions_returns_empty_array_for_nonexistent_controller(): void
    {
        $actions = PageRouteHelper::getActions('App\Http\Controllers\NonExistentController');
        $this->assertEmpty($actions);
    }
}
