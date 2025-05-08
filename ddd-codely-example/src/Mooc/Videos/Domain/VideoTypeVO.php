<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Videos\Domain;

enum VideoTypeVO: string
{
	case SCREENCAST = 'screencast';
	case INTERVIEW = 'interview';
}
