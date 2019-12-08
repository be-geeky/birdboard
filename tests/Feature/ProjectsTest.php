<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase {
	use WithFaker, RefreshDatabase;
	/** @test */
	public function a_user_can_create_project() {

		$this->withoutExceptionHandling();
		$attriutes = [
			'title' => $this->faker->sentence,
			'description' => $this->faker->paragraph,
		];

		$this->post('/projects', $attriutes)->assertRedirect('/projects');

		$this->assertDatabaseHas('projects', $attriutes);

		$this->get('/projects')->assertSee($attriutes['title']);

	}
	/** @test */
	public function a_project_requires_a_title() {
		$attriutes = factory('App\Project')->raw(['title' => '']);
		$this->post('/projects', $attriutes)->assertSessionHasErrors('title');
	}
	/** @test */
	public function a_project_requires_a_description() {
		$attriutes = factory('App\Project')->raw(['description' => '']);
		$this->post('/projects', $attriutes)->assertSessionHasErrors('description');
	}
}
