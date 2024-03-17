<?php

namespace App\Enums;

enum CategoryEnum: string
{
    case MusicEvents = 'music events';
    case SportsEvents = 'sports events';
    case CulturalEvents = 'cultural events';
    case BusinessEvents = 'business events';
    case SocialEvents = 'social events';
    case EducationalEvents = 'educational events';
}
