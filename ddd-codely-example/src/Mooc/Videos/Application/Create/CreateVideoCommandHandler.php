<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Application\Create;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Mooc\Shared\Domain\Videos\VideoUrlVO;
use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Mooc\Videos\Domain\VideoTitleVO;
use CodelyTv\Mooc\Videos\Domain\VideoTypeVO;
use CodelyTv\Shared\Domain\Bus\Command\CommandHandler;

final readonly class CreateVideoCommandHandler implements CommandHandler
{
	public function __construct(private VideoCreator $creator) {}

	public function __invoke(CreateVideoCommand $command): void
	{
		$id = new VideoIdVO($command->id());
		$type = VideoTypeVO::from($command->type());
		$title = new VideoTitleVO($command->title());
		$url = new VideoUrlVO($command->url());
		$courseId = new CourseIdVO($command->courseId());

		$this->creator->create($id, $type, $title, $url, $courseId);
	}
}
