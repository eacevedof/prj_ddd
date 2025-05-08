<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Domain;

use CodelyTv\Mooc\Shared\Domain\Courses\CourseIdVO;
use CodelyTv\Mooc\Shared\Domain\Videos\VideoUrlVO;
use CodelyTv\Shared\Domain\Aggregate\AggregateRoot;

final class VideoAG extends AggregateRoot
{
	public function __construct(
		private readonly VideoIdVO   $videoIdVO,
		private readonly VideoTypeVO $videoTypeVO,
		private VideoTitleVO         $title,
		private readonly VideoUrlVO  $url,
		private readonly CourseIdVO $courseId
	) {}

	public static function create(
        VideoIdVO    $videoIdVO,
        VideoTypeVO  $videoTypeVO,
        VideoTitleVO $videoTitleVO,
        VideoUrlVO   $videoUrlVO,
        CourseIdVO   $courseIdVO
	): self {
		$videoEntity = new self(
            $videoIdVO,
            $videoTypeVO,
            $videoTitleVO,
            $videoUrlVO,
            $courseIdVO
        );

		$videoEntity->recordDispatchEvent(
			new VideoCreatedAbstractDomainEvent(
                $videoIdVO->value(),
                $videoTypeVO->value,
                $videoTitleVO->value(),
                $videoUrlVO->value(),
                $courseIdVO->value()
            )
		);

		return $videoEntity;
	}

	public function updateTitle(VideoTitleVO $newTitle): void
	{
		$this->title = $newTitle;
	}

	public function id(): VideoIdVO
	{
		return $this->videoIdVO;
	}

	public function type(): VideoTypeVO
	{
		return $this->videoTypeVO;
	}

	public function title(): VideoTitleVO
	{
		return $this->title;
	}

	public function url(): VideoUrlVO
	{
		return $this->url;
	}

	public function courseId(): CourseIdVO
	{
		return $this->courseId;
	}
}
