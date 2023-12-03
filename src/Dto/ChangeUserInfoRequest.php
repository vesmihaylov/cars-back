<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Change User Info Request DTO
 */
class ChangeUserInfoRequest
{
    #[Assert\NotBlank(message: 'Моля, въведете вашето име.')]
    #[Assert\Length(
        min: 3,
        max: 100,
        minMessage: 'Минималният брой символи на името е 3.',
        maxMessage: 'Позволеният брой символи на името е 100.'
    )]
    #[Assert\Type('string')]
    public string $name;

    #[Assert\NotBlank(message: 'Моля, въведете вашата електронна поща.')]
    #[Assert\Length(max: 150, maxMessage: 'Позволеният брой символи за пощата е 150.')]
    #[Assert\Email(message: 'Невалидна електронна поща.', mode: Email::VALIDATION_MODE_HTML5)]
    public string $email;

    #[Assert\NotBlank(message: 'Моля, въведете телефонен номер.')]
    #[Assert\Length(
        min: 10,
        max: 15,
        minMessage: 'Минималният брой символи на тел.номер е 10.',
        maxMessage: 'Позволеният брой символи на тел.номер е 15.'
    )]
    #[Assert\Regex(
        '/^\\+?\\d{1,4}?[-.\\s]?\\(?\\d{1,3}?\\)?[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,4}[-.\\s]?\\d{1,9}$/',
        message: 'Телефонният номер не е валиден.'
    )]
    #[Assert\Type(
        type: 'numeric',
        message: 'Телефонният номер не е валиден.',
    )]
    public string $phoneNumber;
}
