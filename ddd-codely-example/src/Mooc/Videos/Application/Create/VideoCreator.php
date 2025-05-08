<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Application\Create;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Mooc\Shared\Domain\Videos\VideoUrlVO;
use CodelyTv\Mooc\Videos\Domain\VideoAG;
use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Mooc\Videos\Domain\VideoRepositoryInterface;
use CodelyTv\Mooc\Videos\Domain\VideoTitleVO;
use CodelyTv\Mooc\Videos\Domain\VideoTypeVO;
use CodelyTv\Shared\Domain\Bus\Event\EventBusInterface;

final readonly class VideoCreator
{
	public function __construct(private VideoRepositoryInterface $repository, private EventBusInterface $bus) {}

	public function create(VideoIdVO $id, VideoTypeVO $type, VideoTitleVO $title, VideoUrlVO $url, CourseIdVO $courseId): void
	{
		$video = VideoAG::create($id, $type, $title, $url, $courseId);

		$this->repository->save($video);

		$this->bus->publish(...$video->pullDomainEvents());
	}
}
