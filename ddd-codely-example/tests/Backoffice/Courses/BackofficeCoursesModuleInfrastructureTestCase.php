<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Backoffice\Courses;

use CodelyTv\Backoffice\Courses\Infrastructure\Persistence\ElasticsearchBackofficeCourseRepositoryInterface;
use CodelyTv\Backoffice\Courses\Infrastructure\Persistence\MySqlBackofficeCourseRepositoryInterface;
use CodelyTv\Tests\Backoffice\Shared\Infraestructure\PhpUnit\BackofficeContextInfrastructureTestCase;
use Doctrine\ORM\EntityManager;

abstract class BackofficeCoursesModuleInfrastructureTestCase extends BackofficeContextInfrastructureTestCase
{
	protected function mySqlRepository(): MySqlBackofficeCourseRepositoryInterface
	{
		return new MySqlBackofficeCourseRepositoryInterface($this->service(EntityManager::class));
	}

	protected function elasticRepository(): ElasticsearchBackofficeCourseRepositoryInterface
	{
		return $this->service(ElasticsearchBackofficeCourseRepositoryInterface::class);
	}
}
