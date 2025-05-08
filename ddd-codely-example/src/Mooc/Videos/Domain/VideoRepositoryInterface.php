<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Domain;

use CodelyTv\Shared\Domain\Criteria\Criteria;

interface VideoRepositoryInterface
{
	public function save(VideoAG $videoAG): void;

	public function search(VideoIdVO $id): ?VideoAG;

	public function searchByCriteria(Criteria $criteria): VideosCollection;
}
