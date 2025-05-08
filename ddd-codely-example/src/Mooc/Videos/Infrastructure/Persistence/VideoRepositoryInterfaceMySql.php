<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Infrastructure\Persistence;

use CodelyTv\Mooc\Videos\Domain\VideoAG;
use CodelyTv\Mooc\Videos\Domain\VideoIdVO;
use CodelyTv\Mooc\Videos\Domain\VideoRepositoryInterface;
use CodelyTv\Mooc\Videos\Domain\VideosCollection;
use CodelyTv\Shared\Domain\Criteria\Criteria;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaConverter;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class VideoRepositoryInterfaceMySql extends DoctrineRepository implements VideoRepositoryInterface
{
	private static array $criteriaToDoctrineFields = [
		'id' => 'id',
		'type' => 'type',
		'title' => 'title',
		'url' => 'url',
		'course_id' => 'courseId',
	];

	public function save(VideoAG $videoAG): void
	{
		$this->persist($videoAG);
	}

	public function search(VideoIdVO $id): ?VideoAG
	{
		return $this->repository(VideoAG::class)->find($id);
	}

	public function searchByCriteria(Criteria $criteria): VideosCollection
	{
		$doctrineCriteria = DoctrineCriteriaConverter::convert($criteria, self::$criteriaToDoctrineFields);
		$videos = $this->repository(VideoAG::class)->matching($doctrineCriteria)->toArray();

		return new VideosCollection($videos);
	}
}
