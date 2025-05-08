<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Courses\Application\Create;

use CodelyTv\Mooc\Courses\Domain\CourseDurationVO;
use CodelyTv\Mooc\Courses\Domain\CourseNameVO;
use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Shared\Domain\Bus\Command\CommandHandler;

final readonly class CreateCourseCommandHandler implements CommandHandler
{
	public function __construct(private CourseCreatorService $creator) {}

	public function __invoke(CreateCourseCommand $command): void
	{
		$id = new CourseIdVO($command->id());
		$name = new CourseNameVO($command->name());
		$duration = new CourseDurationVO($command->duration());

		$this->creator->__invoke($id, $name, $duration);
	}
}
