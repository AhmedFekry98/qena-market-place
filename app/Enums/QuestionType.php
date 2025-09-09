<?php

namespace App\Enums;

enum QuestionType : string
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case RADIO = 'radio';
    case DROPDOWN = 'dropdown';
    case CHECKBOX = 'checkbox';
}
