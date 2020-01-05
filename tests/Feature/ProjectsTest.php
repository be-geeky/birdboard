<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase {
	use WithFaker, RefreshDatabase;
	/** @test */
	public function only_authenticated_user_can_create_project() {
		//$this->withoutExceptionHandling();
		$attriutes = factory('App\Project')->raw();
		$this->post('/projects', $attriutes)->assertRedirect('login');
	}
	/** @test */
	public function a_user_can_create_project() {

		$this->withoutExceptionHandling();
		$this->actingAs(factory('App\User')->create());
		$attriutes = [
			'title' => $this->faker->sentence,
			'description' => $this->faker->paragraph,
		];

		$this->post('/projects', $attriutes)->assertRedirect('/projects');

		$this->assertDatabaseHas('projects', $attriutes);

		$this->get('/projects')->assertSee($attriutes['title']);

	}
	/** @test */

	public function a_user_can_view_a_project() {

		//$this->withoutExceptionHandling();
		$project = factory('App\Project')->create();
		$this->get($project->path())
			->assertSee($project->title)
			->assertSee($project->description);
	}
	/** @test */
	public function a_project_requires_a_title() {
		//$this->withoutExceptionHandling();
		$this->actingAs(factory('App\User')->create());
		$attriutes = factory('App\Project')->raw(['title' => '']);
		$this->post('/projects', $attriutes)->assertSessionHasErrors('title');
	}
	/** @test */
	public function a_project_requires_a_description() {
		$this->actingAs(factory('App\User')->create());
		$attriutes = factory('App\Project')->raw(['description' => '']);
		$this->post('/projects', $attriutes)->assertSessionHasErrors('description');
	}
}
