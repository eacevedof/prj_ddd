<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Backoffice\Frontend\Controller\Courses;

use CodelyTv\Mooc\CoursesCounter\Application\Find\CoursesCounterQueryResponse;
use CodelyTv\Mooc\CoursesCounter\Application\Find\FindCoursesCounterQuery;
use CodelyTv\Shared\Domain\ValueObject\SimpleUuidVO;
use CodelyTv\Shared\Infrastructure\Symfony\WebController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CoursesGetWebController extends WebController
{
	public function __invoke(Request $request): Response
	{
		/** @var CoursesCounterQueryResponse $coursesCounterResponse */
		$coursesCounterResponse = $this->ask(new FindCoursesCounterQuery());

		return $this->render(
			'pages/courses/courses.html.twig',
			[
				'title' => 'Courses',
				'description' => 'Courses CodelyTV - Backoffice',
				'courses_counter' => $coursesCounterResponse->total(),
				'new_course_id' => SimpleUuidVO::random()->value(),
			]
		);
	}

	protected function exceptions(): array
	{
		return [];
	}
}
